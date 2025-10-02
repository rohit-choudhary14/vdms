<h1>Accident / Incident Report</h1>

<div class="card mb-3 p-3">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>

    <div class="form-group mr-2">
        <?= $this->Form->control('vehicle_id', [
            'label' => 'Vehicle',
            'options' => $vehicles,
            'empty' => 'All',
            'value' => $filters['vehicle_id'] ?$filters['vehicle_id']: '',
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group mr-2">
        <?= $this->Form->control('driver_id', [
            'label' => 'Driver',
            'options' => $drivers,
            'empty' => 'All',
            'value' => $filters['driver_id'] ?$filters['driver_id']: '',
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group mr-2">
        <?= $this->Form->control('nature_of_accident', [
            'label' => 'Nature',
            'type' => 'select',
            'options' => ['Minor' => 'Minor', 'Major' => 'Major', 'Damage' => 'Damage'],
            'empty' => 'All',
            'value' => $filters['nature_of_accident'] ? $filters['nature_of_accident']:'',
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group mr-2">
        <?= $this->Form->control('from_date', [
            'label' => 'From',
            'type' => 'date',
            'value' => $filters['from_date'] ?$filters['from_date']: '',
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group mr-2">
        <?= $this->Form->control('to_date', [
            'label' => 'To',
            'type' => 'date',
            'value' => $filters['to_date'] ?$filters['to_date']: '',
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group mr-2 mt-4">
        <?= $this->Form->button('Filter', ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link('Reset', ['action' => 'report'], ['class' => 'btn btn-secondary ml-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<div class="table-responsive">
    <div class="mb-3">
    <?= $this->Html->link('Export to Excel', ['action' => 'exportExcel'], ['class' => 'btn btn-success mr-2']) ?>
    <?= $this->Html->link('Export to PDF', ['action' => 'exportPdf'], ['class' => 'btn btn-danger']) ?>
</div>

    <table class="table table-bordered table-striped">

        <thead class="thead-dark">

            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Nature</th>
                <th>Repair Cost</th>
                <th>Insurance Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalCost = 0; ?>
            <?php foreach ($accidents as $accident): ?>
                <tr>
                    <td><?= h($accident->accident_id) ?></td>
                    <td><?= h(!empty($accident->vehicle->registration_no) ? $accident->vehicle->registration_no : $accident->vehicle_id) ?></td>
<td><?= h(!empty($accident->driver->name) ? $accident->driver->name : $accident->driver_id) ?></td>

                    <td><?= h($accident->date_time->format('d-m-Y H:i')) ?></td>
                    <td><?= h($accident->location) ?></td>
                    <td><?= h($accident->nature_of_accident) ?></td>
                    <td><?= number_format($accident->repair_cost, 2) ?></td>
                    <td><?= h($accident->insurance_claim_status) ?></td>
                </tr>
                <?php $totalCost += $accident->repair_cost; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="alert alert-info">
    <strong>Total Accidents:</strong> <?= count($accidents) ?> |
    <strong>Total Repair Cost:</strong> ₹<?= number_format($totalCost, 2) ?>
</div>
