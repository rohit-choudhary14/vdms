<h3><?= $assignment->id ? 'Edit' : 'Add' ?> Driver Assignment</h3>

<?= $this->Form->create($assignment) ?>

<div class="form-row">
    <div class="form-group col-md-6">
        <?= $this->Form->control('driver_id', ['options'=>$drivers, 'class'=>'form-control', 'label'=>'Driver']) ?>
    </div>
    <div class="form-group col-md-6">
        <?= $this->Form->control('vehicle_id', ['options'=>$vehicles, 'class'=>'form-control', 'label'=>'Vehicle']) ?>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <?= $this->Form->control('start_date', ['type'=>'date', 'class'=>'form-control']) ?>
    </div>
    <div class="form-group col-md-6">
        <?= $this->Form->control('end_date', ['type'=>'date', 'class'=>'form-control']) ?>
    </div>
</div>

<?= $this->Form->button(__('Save'), ['class'=>'btn btn-success']) ?>
<?= $this->Html->link('Back', ['action'=>'index'], ['class'=>'btn btn-secondary ml-2']) ?>

<?= $this->Form->end() ?>
