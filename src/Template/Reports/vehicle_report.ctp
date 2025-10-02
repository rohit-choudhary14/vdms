<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Report</title>
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
    <h2>Vehicle Report</h2>
    <h3>Vehicle Details</h3>
    <p><strong>Registration No:</strong> <?= h($vehicle->registration_no) ?></p>
    <p><strong>Make/Model:</strong> <?= h($vehicle->make_model ?$vehicle->make_model: 'N/A') ?></p>
    <p><strong>Type:</strong> <?= h($vehicle->vehicle_type ?$vehicle->vehicle_type: 'N/A') ?></p>

    <h3>Fuel Logs</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Driver</th>
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
                    <td><?= h($log->driver->name ?$log->driver->name: 'N/A') ?></td>
                    <td><?= h($log->fuel_quantity) ?></td>
                    <td><?= h($log->fuel_cost) ?></td>
                    <td><?= h($log->mileage ?$log->mileage: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No fuel records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <h3>Maintenance</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Service Type</th>
                <th>Vendor</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($maintenance)): ?>
            <?php foreach ($maintenance as $m): ?>
                <tr>
                    <td><?= h($m->service_date->format('Y-m-d')) ?></td>
                    <td><?= h($m->service_type) ?></td>
                    <td><?= h($m->service_vendor ?$m->service_vendor: '-') ?></td>
                    <td><?= h($m->cost_incurred ?$m->cost_incurred: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No maintenance records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <h3>Insurance</h3>
    <table>
        <thead>
            <tr>
                <th>Policy No</th>
                <th>Provider</th>
                <th>Start</th>
                <th>Expiry</th>
                <th>Premium</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($insurance)): ?>
            <?php foreach ($insurance as $ins): ?>
                <tr>
                    <td><?= h($ins->policy_no) ?></td>
                    <td><?= h($ins->provider) ?></td>
                    <td><?= h($ins->start_date->format('Y-m-d')) ?></td>
                    <td><?= h($ins->expiry_date->format('Y-m-d')) ?></td>
                    <td><?= h($ins->premium_amount) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No insurance records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <h3>Accidents</h3>
    <table>
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Details</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($accidents)): ?>
            <?php foreach ($accidents as $accident): ?>
                <tr>
                    <td><?= h($accident->date_time->format('Y-m-d H:i')) ?></td>
                    <td><?= h($accident->details ?$accident->details : '-') ?></td>
                    <td><?= h($accident->cost ?$accident->cost: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No accident records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
