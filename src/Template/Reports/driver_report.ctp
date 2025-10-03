<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Driver Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, h3 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Driver Report</h2>
    <h3>Driver Details</h3>
    <p><strong>Name:</strong> <?= h($driver->name) ?></p>
    <p><strong>License No:</strong> <?= h($driver->license_no ?: 'N/A') ?></p>
    <p><strong>Phone:</strong> <?= h($driver->contact_no ?: 'N/A') ?></p>

    <h3>Fuel Logs</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Fuel Qty</th>
                <th>Cost</th>
                <th>Mileage</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($fuelLogs)): ?>
            <?php foreach ($fuelLogs as $log): ?>
                <tr>
                    <td><?= h($log->refuel_date->format('Y-m-d')) ?></td>
                    <td><?= h($log->vehicle->registration_no ?$vehicle->registration_no : 'N/A') ?></td>
                    <td><?= h($log->fuel_quantity) ?></td>
                    <td><?= h($log->fuel_cost) ?></td>
                    <td><?= h($log->mileage ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No fuel records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <h3>Accidents</h3>
    <table>
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Vehicle</th>
                <th>Details</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($accidents)): ?>
            <?php foreach ($accidents as $accident): ?>
                <tr>
                    <td><?= h($accident->date_time->format('Y-m-d H:i')) ?></td>
                    <td><?= h($accident->vehicle->registration_no ?: 'N/A') ?></td>
                    <td><?= h($accident->details ?: '-') ?></td>
                    <td><?= h($accident->repair_cost ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No accident records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
