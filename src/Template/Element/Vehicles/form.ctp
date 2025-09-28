<?= $this->Form->create($vehicle, ['type'=>'file']) ?>
  <div class="form-row">
    <div class="form-group col-md-4">
      <?= $this->Form->control('vehicle_code', ['class'=>'form-control']) ?>
    </div>
    <div class="form-group col-md-4">
      <?= $this->Form->control('registration_no', ['class'=>'form-control']) ?>
    </div>
    <div class="form-group col-md-4">
      <?= $this->Form->control('vehicle_type', ['class'=>'form-control']) ?>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-3"><?= $this->Form->control('fuel_type', ['class'=>'form-control']) ?></div>
    <div class="form-group col-md-3"><?= $this->Form->control('make_model', ['class'=>'form-control']) ?></div>
    <div class="form-group col-md-3"><?= $this->Form->control('seating_capacity', ['class'=>'form-control']) ?></div>
    <div class="form-group col-md-3"><?= $this->Form->control('status', ['class'=>'form-control']) ?></div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-4"><?= $this->Form->control('purchase_date', ['class'=>'form-control', 'type'=>'date']) ?></div>
    <div class="form-group col-md-4"><?= $this->Form->control('purchase_value', ['class'=>'form-control']) ?></div>
    <div class="form-group col-md-4"><?= $this->Form->control('vendor', ['class'=>'form-control']) ?></div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-3"><?= $this->Form->control('registration_doc', ['type'=>'file']) ?></div>
    <div class="form-group col-md-3"><?= $this->Form->control('bill_doc', ['type'=>'file']) ?></div>
    <div class="form-group col-md-3"><?= $this->Form->control('photo_front', ['type'=>'file']) ?></div>
    <div class="form-group col-md-3"><?= $this->Form->control('photo_back', ['type'=>'file']) ?></div>
  </div>

  <?= $this->Form->button(__('Save'), ['class'=>'btn btn-success']) ?>
<?= $this->Form->end() ?>
