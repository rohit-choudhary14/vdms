<div class="card shadow-sm mb-4 mt-5">
  <div class="card-header bg-dark text-white">
    <h5 class="mb-0">Add New Driver</h5>
  </div>
        
        <div class="card-body shadow-lg">
        
            <?= $this->Form->create($driver, [
                'type' => 'file',
                'class' => 'row g-4 needs-validation',
                'novalidate' => true
            ]) ?>

            <!-- Driver Name -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('name', [
                    'label' => 'Driver Name',
                    'class' => 'form-control  shadow-sm',
                    'placeholder' => 'Enter full name',
                    'required' => true
                ]) ?>
            </div>

            <!-- License Number -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('license_no', [
                    'label' => 'Driving License Number',
                    'class' => 'form-control  shadow-sm',
                    'placeholder' => 'Enter license number',
                    'required' => true
                ]) ?>
            </div>

            <!-- License Validity -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('license_validity', [
                    'label' => 'License Valid Upto',
                    'type' => 'text', // will replace with flatpickr
                    'class' => 'form-control  datepicker',
                    'placeholder' => 'Select date',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <!-- Joining Date -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('joining_date', [
                    'label' => 'Date of Appointment',
                    'type' => 'text',
                    'class' => 'form-control  datepicker',
                    'placeholder' => 'Select date',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <!-- Status -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('status', [
                    'label' => 'Status',
                    'options' => ['Active' => 'Active', 'Transferred' => 'Transferred', 'Retired' => 'Retired'],
                    'class' => 'form-control   form-select  shadow-sm',
                    'empty' => '-- Select Status --',
                    'id' => 'driver-status'
                ]) ?>

            </div>

            <!-- Status Date (dynamic) -->
            <div class="col-md-6 mt-5" id="status-date-wrapper" style="display:none;">
                <?= $this->Form->control('status_date', [
                    'label' => 'Date of Status Apply',
                    'type' => 'text',
                    'class' => 'form-control  datepicker',
                    'placeholder' => 'Select date',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <!-- Vehicle Type -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('allotted_vehicle_type', [
                    'label' => 'Allotted Vehicle Type',
                    'class' => 'form-control  shadow-sm',
                    'placeholder' => 'E.g., Sedan, SUV'
                ]) ?>
            </div>

            <!-- Vehicle Number -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('allotted_vehicle_no', [
                    'label' => 'Allotted Vehicle Number',
                    'class' => 'form-control  shadow-sm',
                    'placeholder' => 'Enter number'
                ]) ?>
            </div>

            <!-- Allotment Date -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('allotment_date', [
                    'label' => 'Date of Allotment',
                    'type' => 'text',
                    'class' => 'form-control  datepicker',
                    'placeholder' => 'Select date',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <!-- Assigned User -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('user_id', [
                    'label' => 'Assigned Officer/Judge',
                    'type' => 'select',
                    // 'options' => $users,
                    'empty' => '-- Select User --',
                    'class' => 'form-control   form-select  shadow-sm'
                ]) ?>
            </div>

            <!-- File Uploads -->
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('license_doc', [
                    'label' => 'Upload Driving License',
                    'type' => 'file',
                    'class' => 'form-control  shadow-sm',
                    'accept' => '.pdf,.jpg,.jpeg,.png'
                ]) ?>
            </div>
            <div class="col-md-6 mt-5">
                <?= $this->Form->control('appointment_order', [
                    'label' => 'Upload Appointment Order',
                    'type' => 'file',
                    'class' => 'form-control  shadow-sm',
                    'accept' => '.pdf,.jpg,.jpeg,.png'
                ]) ?>
            </div>

            <!-- Submit -->
            <div class="col-12 text-end mt-4">
                <?= $this->Form->button('<i class="fas fa-save"></i> Save Driver', [
                    'escape' => false,
                    'class' => 'btn btn-success btn-lg px-5 shadow-sm'
                ]) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
   
</div>

<!-- JS: Dynamic Status Date -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('driver-status');
        const statusDateWrapper = document.getElementById('status-date-wrapper');

        function toggleStatusDate() {
            statusDateWrapper.style.display = ['Transferred', 'Retired'].includes(statusSelect.value) ? 'block' : 'none';
        }

        statusSelect.addEventListener('change', toggleStatusDate);
        toggleStatusDate();
    });
</script>

<!-- JS: Flatpickr Date Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>