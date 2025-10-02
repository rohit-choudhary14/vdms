<h1>Accident / Incident Details</h1>

<div class="card">
    <div class="card-body">
        <p><strong>Vehicle:</strong> <?= h(!empty($accident->vehicle->registration_no) ? $accident->vehicle->registration_no : $accident->vehicle_id) ?></p>
<p><strong>Driver:</strong> <?= h(!empty($accident->driver->name) ? $accident->driver->name : $accident->driver_id) ?></p>

        <p><strong>Date & Time:</strong> <?= h($accident->date_time->format('d-m-Y H:i')) ?></p>
        <p><strong>Location:</strong> <?= h($accident->location) ?></p>
        <p><strong>Nature of Accident:</strong> <?= h($accident->nature_of_accident) ?></p>
        <p><strong>FIR No.:</strong> <?= h($accident->fir_no) ?></p>
        <p><strong>Court Case Details:</strong> <?= nl2br(h($accident->court_case_details)) ?></p>
        <p><strong>Repair Cost:</strong> <?= h($accident->repair_cost) ?></p>
        <p><strong>Insurance Claim Status:</strong> <?= h($accident->insurance_claim_status) ?></p>
    </div>
</div>

<div class="mt-3">
    <?= $this->Html->link('Back to List', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Html->link('Edit', ['action' => 'edit', $accident->accident_id], ['class' => 'btn btn-warning']) ?>
    <?= $this->Form->postLink('Delete', ['action' => 'delete', $accident->accident_id], [
        'confirm' => 'Are you sure you want to delete this record?',
        'class' => 'btn btn-danger'
    ]) ?>
</div>
