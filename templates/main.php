<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Count by Tag</title>
    <link rel="stylesheet" href="<?php echo rtrim(htmlspecialchars($ucrmPublicUrl, ENT_QUOTES), '/'); ?>/assets/fonts/lato/lato.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/main.css">
</head>
<body>
    <div id="header">
        <h1>Client Count by Tag</h1>
    </div>
    <div id="content" class="container-fluid ml-0 mr-0 p-3">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col mb-3">
                <div class="card summary-card total-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total Clients</h5>
                        <h2 class="card-text font-weight-bold"><?php echo number_format($grandTotal['total']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card summary-card active-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Active</h5>
                        <h2 class="card-text font-weight-bold text-success"><?php echo number_format($grandTotal['active']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card summary-card suspended-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Suspended</h5>
                        <h2 class="card-text font-weight-bold text-warning"><?php echo number_format($grandTotal['suspended']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card summary-card archived-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Archived</h5>
                        <h2 class="card-text font-weight-bold text-secondary"><?php echo number_format($grandTotal['archived']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card summary-card lead-card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Lead</h5>
                        <h2 class="card-text font-weight-bold text-info"><?php echo number_format($grandTotal['lead']); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Client Statistics by Tag</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 sortable" id="tagTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="sortable-header" data-sort="string">Tag <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Total <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Active <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Suspended <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Archived <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Lead <span class="sort-icon">⇅</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tagStats as $tag): ?>
                                    <tr>
                                        <td data-value="<?php echo htmlspecialchars($tag['name'], ENT_QUOTES); ?>">
                                            <span class="badge tag-badge" style="background-color: <?php echo htmlspecialchars($tag['colorBackground'], ENT_QUOTES); ?>; color: <?php echo htmlspecialchars($tag['colorText'], ENT_QUOTES); ?>;">
                                                <?php echo htmlspecialchars($tag['name'], ENT_QUOTES); ?>
                                            </span>
                                        </td>
                                        <td class="text-center font-weight-bold" data-value="<?php echo $tag['total']; ?>"><?php echo number_format($tag['total']); ?></td>
                                        <td class="text-center text-success" data-value="<?php echo $tag['active']; ?>"><?php echo number_format($tag['active']); ?></td>
                                        <td class="text-center text-warning" data-value="<?php echo $tag['suspended']; ?>"><?php echo number_format($tag['suspended']); ?></td>
                                        <td class="text-center text-secondary" data-value="<?php echo $tag['archived']; ?>"><?php echo number_format($tag['archived']); ?></td>
                                        <td class="text-center text-info" data-value="<?php echo $tag['lead']; ?>"><?php echo number_format($tag['lead']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <th>Grand Total</th>
                                        <th class="text-center"><?php echo number_format($grandTotal['total']); ?></th>
                                        <th class="text-center text-success"><?php echo number_format($grandTotal['active']); ?></th>
                                        <th class="text-center text-warning"><?php echo number_format($grandTotal['suspended']); ?></th>
                                        <th class="text-center"><?php echo number_format($grandTotal['archived']); ?></th>
                                        <th class="text-center text-info"><?php echo number_format($grandTotal['lead']); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tag Cards Grid -->
        <div class="row mt-4">
            <?php foreach ($tagStats as $tag): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="card tag-card h-100">
                    <div class="card-header" style="background-color: <?php echo htmlspecialchars($tag['colorBackground'], ENT_QUOTES); ?>; color: <?php echo htmlspecialchars($tag['colorText'], ENT_QUOTES); ?>;">
                        <h6 class="mb-0 font-weight-bold"><?php echo htmlspecialchars($tag['name'], ENT_QUOTES); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Total:</span>
                            <span class="font-weight-bold"><?php echo number_format($tag['total']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-success">Active:</span>
                            <span class="font-weight-bold text-success"><?php echo number_format($tag['active']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-warning">Suspended:</span>
                            <span class="font-weight-bold text-warning"><?php echo number_format($tag['suspended']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary">Archived:</span>
                            <span class="font-weight-bold text-secondary"><?php echo number_format($tag['archived']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Service Plans Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Service Plan Statistics</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 sortable" id="planTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="sortable-header" data-sort="string">Service Plan <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Total Services <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Active <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Suspended <span class="sort-icon">⇅</span></th>
                                        <th class="text-center sortable-header" data-sort="number">Archived <span class="sort-icon">⇅</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $planGrandTotal = ['total' => 0, 'active' => 0, 'suspended' => 0, 'archived' => 0];
                                    foreach ($servicePlanStats as $plan): 
                                        $planGrandTotal['total'] += $plan['total'];
                                        $planGrandTotal['active'] += $plan['active'];
                                        $planGrandTotal['suspended'] += $plan['suspended'];
                                        $planGrandTotal['archived'] += $plan['archived'];
                                    ?>
                                    <tr>
                                        <td class="font-weight-bold" data-value="<?php echo htmlspecialchars($plan['name'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($plan['name'], ENT_QUOTES); ?></td>
                                        <td class="text-center font-weight-bold" data-value="<?php echo $plan['total']; ?>"><?php echo number_format($plan['total']); ?></td>
                                        <td class="text-center text-success" data-value="<?php echo $plan['active']; ?>"><?php echo number_format($plan['active']); ?></td>
                                        <td class="text-center text-warning" data-value="<?php echo $plan['suspended']; ?>"><?php echo number_format($plan['suspended']); ?></td>
                                        <td class="text-center text-secondary" data-value="<?php echo $plan['archived']; ?>"><?php echo number_format($plan['archived']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <th>Grand Total</th>
                                        <th class="text-center"><?php echo number_format($planGrandTotal['total']); ?></th>
                                        <th class="text-center text-success"><?php echo number_format($planGrandTotal['active']); ?></th>
                                        <th class="text-center text-warning"><?php echo number_format($planGrandTotal['suspended']); ?></th>
                                        <th class="text-center"><?php echo number_format($planGrandTotal['archived']); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sortable table functionality
        document.querySelectorAll('.sortable').forEach(function(table) {
            const headers = table.querySelectorAll('.sortable-header');
            
            headers.forEach(function(header, columnIndex) {
                header.style.cursor = 'pointer';
                header.addEventListener('click', function() {
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    const sortType = header.getAttribute('data-sort');
                    const currentOrder = header.getAttribute('data-order') || 'none';
                    
                    // Determine new sort order
                    let newOrder = 'asc';
                    if (currentOrder === 'asc') newOrder = 'desc';
                    else if (currentOrder === 'desc') newOrder = 'asc';
                    
                    // Reset all headers
                    headers.forEach(function(h) {
                        h.setAttribute('data-order', 'none');
                        h.querySelector('.sort-icon').textContent = '⇅';
                    });
                    
                    // Set current header
                    header.setAttribute('data-order', newOrder);
                    header.querySelector('.sort-icon').textContent = newOrder === 'asc' ? '↑' : '↓';
                    
                    // Sort rows
                    rows.sort(function(a, b) {
                        const aCell = a.cells[columnIndex];
                        const bCell = b.cells[columnIndex];
                        let aValue = aCell.getAttribute('data-value') || aCell.textContent.trim();
                        let bValue = bCell.getAttribute('data-value') || bCell.textContent.trim();
                        
                        if (sortType === 'number') {
                            aValue = parseFloat(aValue) || 0;
                            bValue = parseFloat(bValue) || 0;
                            return newOrder === 'asc' ? aValue - bValue : bValue - aValue;
                        } else {
                            aValue = aValue.toLowerCase();
                            bValue = bValue.toLowerCase();
                            if (aValue < bValue) return newOrder === 'asc' ? -1 : 1;
                            if (aValue > bValue) return newOrder === 'asc' ? 1 : -1;
                            return 0;
                        }
                    });
                    
                    // Re-append sorted rows
                    rows.forEach(function(row) {
                        tbody.appendChild(row);
                    });
                });
            });
        });
    });
    </script>
</body>
</html>
