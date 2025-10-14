<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Add Accident / Incident Record</h5>
    </div>

    <div class="card-body shadow-lg">
        <?= $this->Form->create($accident, [
            'class' => 'row g-4 needs-validation',
            'novalidate' => true,
            'type' => 'file' // Enable file uploads
        ]) ?>

        <!-- Vehicle -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('vehicle_code', [
                'label' => 'Vehicle',
                'options' => $vehicles,
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Driver -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('driver_code', [
                'label' => 'Driver',
                'options' => $drivers,
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Date & Time -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('date_time', [
                'type' => 'text',
                'placeholder' => 'Select date',
                'label' => 'Date & Time',
                'class' => 'form-control datetimepicker',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Location -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('location', [
                'label' => 'Location',
                'class' => 'form-control',
                'placeholder' => 'Enter accident location',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Nature of Accident -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('nature_of_accident', [
                'type' => 'select',
                'label' => 'Nature of Accident',
                'options' => ['Minor' => 'Minor', 'Major' => 'Major', 'Damage' => 'Damage'],
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Insurance Claim Status -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('insurance_claim_status', [
                'type' => 'select',
                'label' => 'Insurance Claim Status',
                'options' => ['Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'],
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- FIR Registered Checkbox -->
        <div class="col-md-6 mt-3 form-check">
            <?= $this->Form->control('is_fir_registered', [
                'type' => 'checkbox',
                'label' => 'Is FIR Registered?',
                'class' => 'form-check-input',
                'id' => 'isFIRRegisteredCheckbox',
                'templates' => [
                    'inputContainer' => '<div class="form-check">{{content}}</div>',
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- FIR No -->
        <div class="col-md-6 mt-3 fir-related" style="display:none;">
            <?= $this->Form->control('fir_no', [
                'label' => 'FIR No.',
                'class' => 'form-control',
                'placeholder' => 'Enter FIR number',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- FIR Date -->
        <div class="col-md-6 mt-3 fir-related" style="display:none;">
            <?= $this->Form->control('fir_date', [
                'type' => 'text',
                'label' => 'Date of FIR',
                'class' => 'form-control datetimepicker-fir',
                'placeholder' => 'Select FIR date',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Supporting Documents -->
        <div class="col-md-6 mt-3 fir-related" style="display:none;">
            <?= $this->Form->control('supporting_docs', [
                'type' => 'file',
                'label' => 'Supporting Documents (PDF only)',
                'class' => 'form-control',
                'multiple' => true,
                'accept' => 'application/pdf',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Court Case Details -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('court_case_details', [
                'label' => 'Court Case Details',
                'type' => 'textarea',
                'rows' => 2,
                'class' => 'form-control',
                'placeholder' => 'Enter court case details',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Repair Cost -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('repair_cost', [
                'label' => 'Repair Cost (Rs.)',
                'class' => 'form-control',
                'placeholder' => 'Enter repair cost',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Submit -->
        <div class="col-12 text-end mt-4">
            <?= $this->Form->button('<i class="fas fa-save"></i> Save Record', [
                'escape' => false,
                'class' => 'btn btn-success btn-lg px-5 shadow-sm'
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Flatpickr for datetime -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".datetimepicker", {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
        allowInput: true
    });

    flatpickr(".datetimepicker-fir", {
        enableTime: false,
        dateFormat: "d-m-Y",
        allowInput: true
    });

    const firCheckbox = document.getElementById('isFIRRegisteredCheckbox');
    const firFields = document.querySelectorAll('.fir-related');

    function toggleFIRFields() {
        if (firCheckbox.checked) {
            firFields.forEach(field => {
                field.style.display = 'block';
                const input = field.querySelector('input, textarea, select');
                if (input) input.setAttribute('required', 'required');
            });
        } else {
            firFields.forEach(field => {
                field.style.display = 'none';
                const input = field.querySelector('input, textarea, select');
                if (input) {
                    input.removeAttribute('required');
                    input.value = '';
                }
            });
        }
    }

    firCheckbox.addEventListener('change', toggleFIRFields);

    // Initialize fields on page load (for edit or validation errors)
    toggleFIRFields();
});
</script>

<style>
.form-error {
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
</style>
