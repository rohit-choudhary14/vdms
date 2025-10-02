<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <!-- Header -->
        <div class="card-header bg-dark bg-gradient text-white d-flex align-items-center py-3">
            <i class="fas fa-tasks me-2 fs-5"></i>
            <h5 class="mb-0"><?= $assignment->id ? 'Edit Driver Assignment' : 'Add Driver Assignment' ?></h5>
        </div>

        <!-- Body -->
        <div class="card-body p-4">
            <?= $this->Form->create($assignment, ['class' => 'needs-validation', 'novalidate' => true]) ?>

            <div class="row g-4">
                <!-- Driver -->
                <!-- Driver -->
                <div class="col-md-6 col-sm-12">
                    <label class="form-label fw-semibold" for="driver-id">Driver <span
                            class="text-danger">*</span></label>
                    <?= $this->Form->control('driver_id', [
                        'options' => $drivers,
                        'class' => 'form-select select2',
                        'label' => false,
                        'empty' => 'Select Driver'
                    ]) ?>
                </div>

                <!-- Vehicle -->
                <div class="col-md-6 col-sm-12">
                    <label class="form-label fw-semibold" for="vehicle-id">Vehicle <span
                            class="text-danger">*</span></label>
                    <?= $this->Form->control('vehicle_id', [
                        'options' => $vehicles,
                        'class' => 'form-select select2',
                        'label' => false,
                        'empty' => 'Select Vehicle'
                    ]) ?>
                </div>


                <!-- Start Date -->
                <div class="col-md-6 col-sm-12">
                    <label class="form-label fw-semibold" for="start-date">Start Date</label>
                    <div class="input-group  ">
                        <span class="input-group-text bg-white border-0"><i
                                class="fas fa-calendar-alt text-primary"></i></span>
                        <?= $this->Form->control('start_date', [
                            'type' => 'text',
                            'class' => 'form-control rounded-end border-0 datepicker',
                            'label' => false,
                            'placeholder' => 'Select start date',
                            'autocomplete' => 'off'
                        ]) ?>
                    </div>
                </div>

                <!-- End Date -->
                <div class="col-md-6 col-sm-12">
                    <label class="form-label fw-semibold" for="end-date">End Date</label>
                    <div class="input-group  ">
                        <span class="input-group-text bg-white border-0"><i
                                class="fas fa-calendar-check text-primary"></i></span>
                        <?= $this->Form->control('end_date', [
                            'type' => 'text',
                            'class' => 'form-control rounded-end border-0 datepicker',
                            'label' => false,
                            'placeholder' => 'Select end date',
                            'autocomplete' => 'off'
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap justify-content-end gap-3 mt-4">
                <?= $this->Form->button('<i class="fas fa-save me-1"></i> Save', [
                    'class' => 'btn btn-success px-4 py-2  fw-semibold text-white ',
                    'escapeTitle' => false
                ]) ?>

                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left me-1"></i> Back',
                    ['action' => 'index'],
                    ['class' => 'btn btn-secondary px-4 py-2  fw-semibold ', 'escapeTitle' => false]
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- Datepicker + Validation -->
<script>
$(document).ready(function(){

    // Initialize datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom auto'
    });

    // Initialize Select2 with Bootstrap 5 theme
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });

    // Bootstrap client-side validation
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form){
        form.addEventListener('submit', function(event){
            if (!form.checkValidity()){
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
