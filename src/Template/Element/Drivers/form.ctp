<?= $this->Form->create($driver, ['type' => 'file']) ?>

<div class="form-row">
  <div class="form-group col-md-6">
    <?= $this->Form->control('name', [
      'label' => 'Driver Name',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-6">
    <?= $this->Form->control('license_no', [
      'label' => 'Driving License Number',
      'class' => 'form-control'
    ]) ?>
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-4">
    <?= $this->Form->control('license_validity', [
      'label' => 'Driving License Valid Upto',
      'type' => 'date',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-4">
    <?= $this->Form->control('joining_date', [
      'label' => 'Date of Appointment',
      'type' => 'date',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-4">
    <?= $this->Form->control('status', [
      'label' => 'Status',
      'options' => ['Active' => 'Active', 'Transferred' => 'Transferred', 'Retired' => 'Retired'],
      'class' => 'form-control'
    ]) ?>
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-4">
    <?= $this->Form->control('status_date', [
      'label' => 'Date of Status Apply',
      'type' => 'date',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-4">
    <?= $this->Form->control('allotted_vehicle_type', [
      'label' => 'Allotted Vehicle Type',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-4">
    <?= $this->Form->control('allotted_vehicle_no', [
      'label' => 'Allotted Vehicle Number',
      'class' => 'form-control'
    ]) ?>
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-6">
    <?= $this->Form->control('allotment_date', [
      'label' => 'Date of Allotment',
      'type' => 'date',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-6">
    <?= $this->Form->control('user_id', [
      'label' => 'User (Assigned Officer/Judge)',
      'type' => 'select',
      'options' => $users, // <-- pass $users list from controller
      'class' => 'form-control',
      'empty' => '-- Select User --'
    ]) ?>
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-6">
    <?= $this->Form->control('license_doc', [
      'label' => 'Upload Driving License',
      'type' => 'file',
      'class' => 'form-control'
    ]) ?>
  </div>
  <div class="form-group col-md-6">
    <?= $this->Form->control('appointment_order', [
      'label' => 'Upload Appointment Order',
      'type' => 'file',
      'class' => 'form-control'
    ]) ?>
  </div>
</div>

<?= $this->Form->button(__('Save Driver'), ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
