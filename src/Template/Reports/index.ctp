<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-3">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Generate Reports</h5>
    </div>

    <div class="card-body shadow-lg">
        <?= $this->Form->create(null, ['class' => 'row g-4 needs-validation', 'novalidate' => true]) ?>

        <!-- Report Type -->
        <div class="col-md-4">
            <?= $this->Form->control('report_type', [
                'label' => 'Select Report Type',
                'type' => 'select',
                'options' => ['driver' => 'Driver Report', 'vehicle' => 'Vehicle Report'],
                'empty' => 'Choose...',
                'class' => 'form-control',
                'id' => 'reportType',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Driver Select -->
        <div class="col-md-4" id="driverSelect" style="display:none;">
            <?= $this->Form->control('driver_code', [
                'label' => 'Select Driver',
                'options' => $drivers,
                'empty' => 'Choose Driver...',
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Vehicle Select -->
        <div class="col-md-4" id="vehicleSelect" style="display:none;">
            <?= $this->Form->control('vehicle_code', [
                'label' => 'Select Vehicle',
                'options' => $vehicles,
                'empty' => 'Choose Vehicle...',
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Start Date -->
        <div class="col-md-4">
            <?= $this->Form->control('start_date', [
                'label' => 'Start Date',
                'type' => 'text',
                  'placeholder' => 'Select  start date',
                'class' => 'form-control datepicker',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- End Date -->
        <div class="col-md-4">
            <?= $this->Form->control('end_date', [
                'label' => 'End Date',
                'type' => 'text',
                  'placeholder' => 'Select end date',
                'class' => 'form-control datepicker',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Output Format -->
        <div class="col-md-4">
            <?= $this->Form->control('output', [
                'label' => 'Output Format',
                'type' => 'select',
                'options' => ['view' => 'View on Screen', 'pdf' => 'Export PDF', 'excel' => 'Export Excel'],
                'class' => 'form-control',
                'templates' => ['error' => '<div class="form-error text-danger">{{content}}</div>']
            ]) ?>
        </div>

        <!-- Submit -->
        <div class="col-12 text-end mt-4">
            <?= $this->Form->button('<i class="fas fa-file-alt me-1"></i> Generate Report', [
                'escape' => false,
                'class' => 'btn btn-primary btn-lg px-5 shadow-sm'
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const reportType = document.getElementById("reportType");
    const driverSelect = document.getElementById("driverSelect");
    const vehicleSelect = document.getElementById("vehicleSelect");

    reportType.addEventListener("change", function () {
        if (this.value === "driver") {
            driverSelect.style.display = "block";
            vehicleSelect.style.display = "none";
        } else if (this.value === "vehicle") {
            driverSelect.style.display = "none";
            vehicleSelect.style.display = "block";
        } else {
            driverSelect.style.display = "none";
            vehicleSelect.style.display = "none";
        }
    });
});
</script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>

<style>
.form-error {
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
</style>
