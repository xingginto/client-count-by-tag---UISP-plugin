<?php

declare(strict_types=1);

use App\Service\TemplateRenderer;
use Ubnt\UcrmPluginSdk\Security\PermissionNames;
use Ubnt\UcrmPluginSdk\Service\UcrmApi;
use Ubnt\UcrmPluginSdk\Service\UcrmOptionsManager;
use Ubnt\UcrmPluginSdk\Service\UcrmSecurity;

chdir(__DIR__);

require __DIR__ . '/vendor/autoload.php';

// Retrieve API connection.
$api = UcrmApi::create();

// Ensure that user is logged in and has permission to view clients.
$security = UcrmSecurity::create();
$user = $security->getUser();
if (! $user || $user->isClient || ! $user->hasViewPermission(PermissionNames::CLIENTS_CLIENTS)) {
    \App\Http::forbidden();
}

// Retrieve renderer.
$renderer = new TemplateRenderer();

// Check if this is a widget view
$isWidget = isset($_GET['widget']) && $_GET['widget'] === '1';

// Fetch all client tags
$clientTags = $api->get('client-tags');

// Create a map of tag ID to tag name
$tagMap = [];
foreach ($clientTags as $tag) {
    $tagMap[$tag['id']] = [
        'id' => $tag['id'],
        'name' => $tag['name'],
        'colorBackground' => $tag['colorBackground'] ?? '#6c757d',
        'colorText' => $tag['colorText'] ?? '#ffffff',
    ];
}

// Fetch active clients (non-archived)
$activeClients = $api->get('clients', ['limit' => 10000, 'isArchived' => 0]);

// Fetch archived clients separately
$archivedClients = $api->get('clients', ['limit' => 10000, 'isArchived' => 1]);

// Merge all clients
$allClients = array_merge($activeClients, $archivedClients);

// Fetch all services to determine client status and plan info
// Service statuses: 0 = Prepared, 1 = Active, 2 = Ended, 3 = Suspended, 4 = Prepared blocked, 5 = Obsolete, 6 = Deferred, 7 = Quoted
$services = $api->get('clients/services', ['limit' => 10000]);

// Build maps for service data
$clientServiceStatus = [];
$servicePlanStats = [];

foreach ($services as $service) {
    $clientId = $service['clientId'] ?? null;
    if ($clientId === null) continue;
    
    // Track service status per client
    if (!isset($clientServiceStatus[$clientId])) {
        $clientServiceStatus[$clientId] = [
            'hasActive' => false,
            'hasSuspended' => false,
        ];
    }
    
    $status = $service['status'] ?? null;
    if ($status === 1) {
        $clientServiceStatus[$clientId]['hasActive'] = true;
    } elseif ($status === 3) {
        $clientServiceStatus[$clientId]['hasSuspended'] = true;
    }
    
    // Track service plan statistics
    $planId = $service['servicePlanId'] ?? null;
    $planName = $service['servicePlanName'] ?? 'Unknown Plan';
    if ($planId !== null) {
        if (!isset($servicePlanStats[$planId])) {
            $servicePlanStats[$planId] = [
                'id' => $planId,
                'name' => $planName,
                'total' => 0,
                'active' => 0,
                'suspended' => 0,
                'archived' => 0,
            ];
        }
        $servicePlanStats[$planId]['total']++;
        if ($status === 1) {
            $servicePlanStats[$planId]['active']++;
        } elseif ($status === 3) {
            $servicePlanStats[$planId]['suspended']++;
        } elseif ($status === 2 || $status === 5) {
            // Status 2 = Ended, Status 5 = Obsolete (treated as archived)
            $servicePlanStats[$planId]['archived']++;
        }
    }
    
}

// Initialize statistics array for each tag
$tagStats = [];
$untaggedStats = [
    'id' => 0,
    'name' => 'Untagged',
    'colorBackground' => '#6c757d',
    'colorText' => '#ffffff',
    'total' => 0,
    'active' => 0,
    'suspended' => 0,
    'archived' => 0,
    'lead' => 0,
];

foreach ($tagMap as $tagId => $tag) {
    $tagStats[$tagId] = [
        'id' => $tag['id'],
        'name' => $tag['name'],
        'colorBackground' => $tag['colorBackground'],
        'colorText' => $tag['colorText'],
        'total' => 0,
        'active' => 0,
        'suspended' => 0,
        'archived' => 0,
        'lead' => 0,
    ];
}

// Determine client status based on isLead, isArchived, and service status
function getClientStatus($client, $clientServiceStatus) {
    $clientId = $client['id'] ?? null;
    $isLead = $client['isLead'] ?? false;
    $isArchived = $client['isArchived'] ?? false;
    
    if ($isArchived) {
        return 'archived';
    }
    if ($isLead) {
        return 'lead';
    }
    
    // Check service status
    if ($clientId && isset($clientServiceStatus[$clientId])) {
        if ($clientServiceStatus[$clientId]['hasSuspended']) {
            return 'suspended';
        }
        if ($clientServiceStatus[$clientId]['hasActive']) {
            return 'active';
        }
    }
    
    return 'active'; // Default to active if no service info
}

// Process clients and count by tag
foreach ($allClients as $client) {
    $clientId = $client['id'] ?? null;
    $status = getClientStatus($client, $clientServiceStatus);
    $tags = $client['tags'] ?? [];
    
    // If client has no tags, count as untagged
    if (empty($tags)) {
        $untaggedStats['total']++;
        $untaggedStats[$status]++;
    } else {
        // Count client for each of their tags
        foreach ($tags as $tag) {
            // Tags can be objects with 'id' key or just integer IDs
            $tagId = is_array($tag) ? ($tag['id'] ?? null) : $tag;
            if ($tagId !== null && isset($tagStats[$tagId])) {
                $tagStats[$tagId]['total']++;
                $tagStats[$tagId][$status]++;
            }
        }
    }
}

// Sort tags by total count descending
uasort($tagStats, function($a, $b) {
    return $b['total'] - $a['total'];
});

// Add untagged at the end if there are any
if ($untaggedStats['total'] > 0) {
    $tagStats['untagged'] = $untaggedStats;
}

// Calculate grand totals (count unique clients, not per-tag duplicates)
$grandTotal = [
    'total' => count($allClients),
    'active' => 0,
    'suspended' => 0,
    'archived' => 0,
    'lead' => 0,
];

foreach ($allClients as $client) {
    $status = getClientStatus($client, $clientServiceStatus);
    $grandTotal[$status]++;
}

// Sort service plans by total count descending
uasort($servicePlanStats, function($a, $b) {
    return $b['total'] - $a['total'];
});

// Get UCRM public URL
$optionsManager = UcrmOptionsManager::create();
$ucrmPublicUrl = $optionsManager->loadOptions()->ucrmPublicUrl;

// Render appropriate template
$template = $isWidget ? __DIR__ . '/templates/widget.php' : __DIR__ . '/templates/main.php';

$renderer->render(
    $template,
    [
        'tagStats' => $tagStats,
        'grandTotal' => $grandTotal,
        'servicePlanStats' => $servicePlanStats,
        'ucrmPublicUrl' => $ucrmPublicUrl,
        'isWidget' => $isWidget,
    ]
);
