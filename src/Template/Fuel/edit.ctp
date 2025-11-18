<div class="container mt-4">
    <h3><?= isset($fuelLog->fuel_id) ? 'Edit Fuel & Mileage Record' : 'Add Fuel & Mileage Record' ?></h3>
    <?= $this->Form->create($fuelLog, ['class'=>'mt-3']) ?>

    <div class="row">
        <div class="col-md-6"><?= $this->Form->control('vehicle_code', ['class'=>'form-control', 'readonly'=>true,'label'=>'Vehicle','id'=>'vehicle']) ?></div>
        <div class="col-md-6"><?= $this->Form->control('driver_code', ['class'=>'form-control','readonly'=>true,'label'=>'Driver','id'=>'driver']) ?></div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4"><?= $this->Form->control('refuel_date', ['class'=>'form-control','label'=>'Refuel Date','id'=>'refuel_date']) ?></div>
        <div class="col-md-4"><?= $this->Form->control('fuel_quantity', ['class'=>'form-control','label'=>'Fuel Quantity (L)','id'=>'fuel_quantity']) ?></div>
        <div class="col-md-4"><?= $this->Form->control('fuel_cost', ['class'=>'form-control','label'=>'Fuel Cost (Rs)','id'=>'fuel_cost']) ?></div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6"><?= $this->Form->control('odometer_reading', ['class'=>'form-control','label'=>'Odometer Reading (km)','id'=>'odometer']) ?></div>
        <div class="col-md-6"><?= $this->Form->control('mileage', ['class'=>'form-control','label'=>'Mileage (km/L)','readonly'=>true,'id'=>'mileage']) ?></div>
    </div>

    <div class="mt-4">
        <?= $this->Form->button(isset($fuelLog->fuel_id) ? __('Update') : __('Submit'), ['class'=>'btn btn-success']) ?>
        <?= $this->Html->link('Cancel',['action'=>'index'],['class'=>'btn btn-secondary ml-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fuelInput = document.getElementById('fuel_quantity');
    const odoInput = document.getElementById('odometer');
    const mileageInput = document.getElementById('mileage');

    function calculateMileage() {
        const fuel = parseFloat(fuelInput.value);
        const odo = parseFloat(odoInput.value);
        if(!isNaN(fuel) && fuel>0 && !isNaN(odo)) {
            mileageInput.value = (odo/fuel).toFixed(2);
        } else {
            mileageInput.value = '';
        }
    }

    fuelInput.addEventListener('input', calculateMileage);
    odoInput.addEventListener('input', calculateMileage);
});
</script>
