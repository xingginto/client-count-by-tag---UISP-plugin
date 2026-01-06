<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Count by Tag</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lato', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: transparent;
            padding: 10px;
            margin: 0;
        }
        .widget-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .summary-item {
            text-align: center;
            flex: 1;
            min-width: 70px;
            padding: 8px;
            border-radius: 6px;
            background: #f8f9fa;
        }
        .summary-item .label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
        }
        .summary-item .value {
            font-size: 18px;
            font-weight: 700;
        }
        .summary-item.active .value { color: #28a745; }
        .summary-item.suspended .value { color: #ffc107; }
        .summary-item.archived .value { color: #6c757d; }
        .summary-item.total .value { color: #007bff; }
        .summary-item.discounted .value { color: #dc3545; }
        
        .tag-list {
            max-height: 280px;
            overflow-y: auto;
        }
        .tag-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        .tag-row:last-child {
            border-bottom: none;
        }
        .tag-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .tag-stats {
            display: flex;
            gap: 12px;
            font-size: 12px;
        }
        .tag-stats span {
            min-width: 30px;
            text-align: center;
        }
        .stat-active { color: #28a745; }
        .stat-suspended { color: #ffc107; }
        .stat-archived { color: #6c757d; }
        .stat-total { font-weight: 600; }
    </style>
</head>
<body>
    <div class="widget-title">Client Count by Tag</div>
    
    <!-- Summary Row -->
    <div class="summary-row">
        <div class="summary-item total">
            <div class="value"><?php echo number_format($grandTotal['total']); ?></div>
            <div class="label">Total</div>
        </div>
        <div class="summary-item active">
            <div class="value"><?php echo number_format($grandTotal['active']); ?></div>
            <div class="label">Active</div>
        </div>
        <div class="summary-item suspended">
            <div class="value"><?php echo number_format($grandTotal['suspended']); ?></div>
            <div class="label">Suspended</div>
        </div>
        <div class="summary-item archived">
            <div class="value"><?php echo number_format($grandTotal['archived']); ?></div>
            <div class="label">Archived</div>
        </div>
    </div>
    
    <!-- Tag List -->
    <div class="tag-list">
        <?php foreach ($tagStats as $tag): ?>
        <div class="tag-row">
            <span class="tag-badge" style="background-color: <?php echo htmlspecialchars($tag['colorBackground'], ENT_QUOTES); ?>; color: <?php echo htmlspecialchars($tag['colorText'], ENT_QUOTES); ?>;">
                <?php echo htmlspecialchars($tag['name'], ENT_QUOTES); ?>
            </span>
            <div class="tag-stats">
                <span class="stat-total" title="Total"><?php echo number_format($tag['total']); ?></span>
                <span class="stat-active" title="Active"><?php echo number_format($tag['active']); ?></span>
                <span class="stat-suspended" title="Suspended"><?php echo number_format($tag['suspended']); ?></span>
                <span class="stat-archived" title="Archived"><?php echo number_format($tag['archived']); ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
