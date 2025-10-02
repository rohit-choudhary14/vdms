<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">
            <?= isset($fuelLog->fuel_id) ? 'Edit Fuel & Mileage Record' : 'Add Fuel & Mileage Record' ?>
        </h5>
    </div>

    <div class="card-body shadow-lg">
        <?= $this->Form->create($fuelLog, [
            'class' => 'row g-4',
            'novalidate' => true
        ]) ?>
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('vehicle_code', [
                'options' => $vehicles,
                'class' => 'form-control',
                'empty' => 'Select Vehicle',
                'label' => 'Vehicle',
                'required' => true,
                'id' => 'vehicle',
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('driver_code', [
                'options' => $drivers,
                'class' => 'form-control',
                'empty' => 'Select Driver',
                'label' => 'Driver',
                'required' => true,
                'id' => 'driver',
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('refuel_date', [
                'type' => 'text',
                'class' => 'form-control datepicker',
                'label' => 'Refuel Date',
                'placeholder' => 'Select date',
                'id' => 'refuel_date',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('fuel_quantity', [
                'class' => 'form-control',
                'label' => 'Fuel Quantity (L)',
                'placeholder' => 'Enter litres',
                'id' => 'fuel_quantity',
                'required' => true,
                'min' => 1,
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('fuel_cost', [
                'class' => 'form-control',
                'label' => 'Fuel Cost (₹)',
                'placeholder' => 'Enter cost in INR',
                'id' => 'fuel_cost',
                'required' => true,
                'min' => 1,
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('odometer_reading', [
                'class' => 'form-control',
                'label' => 'Odometer Reading (km)',
                'placeholder' => 'Enter odometer reading',
                'id' => 'odometer',
                'required' => true,
                'min' => 1,
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('mileage', [
                'class' => 'form-control',
                'label' => 'Mileage (km/L)',
                'readonly' => true,
                'id' => 'mileage',
                'placeholder' => 'Auto-calculated',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <!-- Submit -->
        <div class="col-12 text-end mt-4">
            <?= $this->Form->button(
                isset($fuelLog->fuel_id) ? '<i class="fas fa-save"></i> Update Record' : '<i class="fas fa-save"></i> Submit Record',
                ['escape' => false, 'class' => 'btn btn-success btn-lg px-5 shadow-sm']
            ) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    flatpickr(".datepicker", { dateFormat: "Y-m-d", allowInput: true });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fuelInput = document.getElementById('fuel_quantity');
        const odoInput = document.getElementById('odometer');
        const mileageInput = document.getElementById('mileage');

        function calculateMileage() {
            const fuel = parseFloat(fuelInput.value);
            const odo = parseFloat(odoInput.value);
            if (!isNaN(fuel) && fuel > 0 && !isNaN(odo)) {
                mileageInput.value = (odo / fuel).toFixed(2);
            } else {
                mileageInput.value = '';
            }
        }

        fuelInput.addEventListener('input', calculateMileage);
        odoInput.addEventListener('input', calculateMileage);
    });
</script>