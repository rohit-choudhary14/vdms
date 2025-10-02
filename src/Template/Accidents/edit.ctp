<h1>Edit Accident / Incident Record</h1>

<div class="accidents form">
<?= $this->Form->create($accident, ['class' => 'form-horizontal']) ?>

<div class="form-group">
    <?= $this->Form->control('vehicle_id', [
        'label' => 'Vehicle',
        'options' => $vehicles,
        'class' => 'form-control'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('driver_id', [
        'label' => 'Driver',
        'options' => $drivers,
        'class' => 'form-control'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('date_time', ['type' => 'datetime', 'class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('location', ['class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('nature_of_accident', [
        'type' => 'select',
        'options' => ['Minor' => 'Minor', 'Major' => 'Major', 'Damage' => 'Damage'],
        'class' => 'form-control'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('fir_no', ['label' => 'FIR No.', 'class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('court_case_details', ['type' => 'textarea', 'class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('repair_cost', ['class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('insurance_claim_status', [
        'type' => 'select',
        'options' => ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'],
        'class' => 'form-control'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->button(__('Update Record'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>

<?= $this->Form->end() ?>
</div>
