<div class="card shadow-sm mb-4">
  <div class="card-header bg-dark text-white">
    <h5 class="mb-0">Vehicle Details</h5>
  </div>
  <div class="card-body">
    <?= $this->Form->create($vehicle, ['type' => 'file', 'class' => 'needs-validation', 'novalidate' => true]) ?>
    
    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-4">
        <?= $this->Form->control('vehicle_code', [
          'class' => 'form-control', 
          'label' => 'Vehicle Code', 
          'placeholder' => 'Enter vehicle code',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-4">
        <?= $this->Form->control('registration_no', [
          'class' => 'form-control', 
          'label' => 'Registration No', 
          'placeholder' => 'Enter registration number',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-4">
        <?= $this->Form->control('vehicle_type', [
          'class' => 'form-control', 
          'label' => 'Vehicle Type', 
          'placeholder' => 'Enter vehicle type',
          'required' => true
        ]) ?>
      </div>
    </div>
    
    <div class="form-row mb-3">
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('fuel_type', [
          'class' => 'form-control', 
          'label' => 'Fuel Type', 
          'placeholder' => 'Enter fuel type',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('make_model', [
          'class' => 'form-control', 
          'label' => 'Make & Model', 
          'placeholder' => 'Enter make and model',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('seating_capacity', [
          'class' => 'form-control', 
          'label' => 'Seating Capacity', 
          'type' => 'number', 
          'min' => 1, 
          'placeholder' => 'Enter seating capacity',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('status', [
          'class' => 'form-control', 
          'label' => 'Status', 
          'placeholder' => 'Enter status',
          'required' => true
        ]) ?>
      </div>
    </div>
    
    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-4">
        <?= $this->Form->control('purchase_date', [
          'class' => 'form-control datepicker',
          'label' => 'Purchase Date',
          'type' => 'text',
          'placeholder' => 'YYYY-MM-DD',
          'autocomplete' => 'off',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-4">
        <?= $this->Form->control('purchase_value', [
          'class' => 'form-control', 
          'label' => 'Purchase Value', 
          'type' => 'number', 
          'step' => '0.01', 
          'min' => 0, 
          'placeholder' => 'Enter purchase value',
          'required' => true
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-4">
        <?= $this->Form->control('vendor', [
          'class' => 'form-control', 
          'label' => 'Vendor', 
          'placeholder' => 'Enter vendor name',
          'required' => true
        ]) ?>
      </div>
    </div>
    
    <div class="form-row mb-4">
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('registration_doc', [
          'type' => 'file', 
          'class' => 'form-control-file', 
          'label' => 'Registration Document'
          // placeholders are not typical on file inputs
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('bill_doc', [
          'type' => 'file', 
          'class' => 'form-control-file', 
          'label' => 'Bill Document'
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('photo_front', [
          'type' => 'file', 
          'class' => 'form-control-file', 
          'label' => 'Photo Front'
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-3">
        <?= $this->Form->control('photo_back', [
          'type' => 'file', 
          'class' => 'form-control-file', 
          'label' => 'Photo Back'
        ]) ?>
      </div>
    </div>
    
    <div class="form-group text-right">
      <?= $this->Form->button(__('Save'), ['class' => 'btn btn-success px-4']) ?>
    </div>
    
    <?= $this->Form->end() ?>
  </div>
</div>

<!-- Flatpickr CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  flatpickr(".datepicker", {
    dateFormat: "Y-m-d",
    allowInput: true
  });
</script>
