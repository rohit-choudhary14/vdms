<!-- Back Button -->
<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<!-- Card -->
<div class="card shadow-sm mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><?= $assignment->id ? 'Edit Driver Assignment' : 'Add Driver Assignment' ?></h5>
    </div>

    <div class="card-body">
        <?= $this->Form->create($assignment, [
            'class' => 'row g-4 needs-validation',
            'novalidate' => true
        ]) ?>

        <!-- Driver -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('driver_code', [
                'label' => 'Driver <span class="text-danger">*</span>',
                'escape' => false,
                'options' => $drivers,
                'empty' => 'Select Driver',
                'class' => 'form-control select2',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Vehicle -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('vehicle_code', [
                'label' => 'Vehicle <span class="text-danger">*</span>',
                'escape' => false,
                'options' => $vehicles,
                'empty' => 'Select Vehicle',
                'class' => 'form-control select2',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Start Date -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('start_date', [
                'type' => 'text',
                'label' => 'Start Date',
                'placeholder' => 'Select start date',
                'class' => 'form-control datetimepicker',
                'autocomplete' => 'off',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- End Date -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('end_date', [
                'type' => 'text',
                'label' => 'End Date',
                'placeholder' => 'Select end date',
                'class' => 'form-control datetimepicker',
                'autocomplete' => 'off',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-end mt-4">
            <?= $this->Form->button('<i class="fas fa-save me-1"></i> Save Assignment', [
                'escape' => false,
                'class' => 'btn btn-success btn-lg px-5 shadow-sm'
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
<!-- Flatpickr & Select2 Setup -->
<script>
$(document).ready(function () {
    // Flatpickr DateTime Picker
    flatpickr(".datetimepicker", {
        enableTime: false,
        dateFormat: "Y-m-d",
        allowInput: true,
        altInput: true,
        altFormat: "F j, Y"
    });

    // Select2 with Bootstrap 5 theme
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });

    // Bootstrap client-side validation
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>

<!-- Optional: Error styling (already included in your example) -->
<style>
.form-error {
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
</style>
