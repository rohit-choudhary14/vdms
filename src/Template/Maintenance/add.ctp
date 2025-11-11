<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><?= $record->id ? 'Edit Maintenance Record' : 'Add Maintenance Record' ?></h5>
    </div>

    <div class="card-body shadow-lg">
        <?= $this->Form->create($record, [
            'type' => 'file',
            'class' => 'row g-4 needs-validation',
            'novalidate' => true
        ]) ?>

        <!-- Vehicle Registration -->
        <div class="col-md-6">
            <?= $this->Form->control('vehicle_code', [
                'id' => 'vehicle-code',
                'options' => $vehicles,
                'label' => 'Vehicle Registration Number',
                'class' => 'form-select form-control select2',
                'empty' => 'Select Vehicle ',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('department', [
                'label' => 'Department / Section',
                'class' => 'form-select form-control select2',
                'options' => [
                    'Chief Justice Office' => 'Chief Justice Office',
                    'Registrar Administration' => 'Registrar Administration',
                    'Registrar Vigilance' => 'Registrar Vigilance',
                    'Protocol Section' => 'Protocol Section',
                    'Pool Vehicles' => 'Pool Vehicles'
                ],
                'empty' => 'Select Department'
            ]) ?>
        </div>
        <!-- Make -->
        <div class="col-md-4">
            <?= $this->Form->control('make', [
                'label' => 'Make',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Model -->
        <div class="col-md-4">
            <?= $this->Form->control('model', [
                'label' => 'Model',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Year -->
        <div class="col-md-4">
            <?= $this->Form->control('year', [
                'label' => 'Year',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Engine No -->
        <div class="col-md-6">
            <?= $this->Form->control('engine_no', [
                'label' => 'Engine No',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Chesis No -->
        <div class="col-md-6">
            <?= $this->Form->control('chassis_no', [
                'label' => 'Chassis No',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Vendor -->
        <div class="col-md-6">
            <?= $this->Form->control('vendor', [
                'label' => 'Vendor',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Fuel Type -->
        <div class="col-md-6">
            <?= $this->Form->control('fuel_type', [
                'label' => 'Fuel Type',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Mileage at Service -->
        <div class="col-md-6">
            <?= $this->Form->control('mileage_at_service', [
                'label' => 'Mileage at Service (km)',
                'class' => 'form-control',
                'placeholder' => 'Enter current mileage',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Service Date -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('service_date', [
                'type' => 'text',
                'class' => 'form-control datepicker',
                'label' => 'Service Date',
                'placeholder' => 'Select date',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Service Type -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('service_type', [
                'type' => 'select',
                'options' => ['Scheduled' => 'Scheduled', 'Breakdown' => 'Breakdown', 'Repair' => 'Repair'],
                'class' => 'form-control',
                'label' => 'Service Type',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Performed By -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('performed_by', [
                'label' => 'Performed By (Dealer / Workshop)',
                'class' => 'form-control',
                'placeholder' => 'Enter who performed service',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Parts Replaced -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('parts_replaced', [
                'label' => 'Parts Replaced',
                'class' => 'form-control',
                'placeholder' => 'Enter parts replaced',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Service Details -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('service_details', [
                'label' => 'Service Details',
                'class' => 'form-control',
                'placeholder' => 'Enter details',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Cost, Work Order, Invoice No -->
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('cost', [
                'label' => 'Cost Incurred',
                'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <div class="col-md-4 mt-3">
            <?= $this->Form->control('work_order_no', [
                'label' => 'Work Order No',
                'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <div class="col-md-4 mt-3">
            <?= $this->Form->control('invoice_no', [
                'label' => 'Invoice / Receipt #',
                'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Bill Date, Amount, Next Due -->
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('bill_date', [
                'type' => 'text',
                'class' => 'form-control datepicker',
                'label' => 'Bill Date',
                'placeholder' => 'Select date',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <div class="col-md-4 mt-3">
            <?= $this->Form->control('bill_amount', [
                'label' => 'Bill Amount',
                'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <div class="col-md-4 mt-3">
            <?= $this->Form->control('next_service_due', [
                'type' => 'text',
                'class' => 'form-control datepicker',
                'label' => 'Next Service Due',
                'placeholder' => 'Select date',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Notes -->
        <div class="col-md-12 mt-3">
            <?= $this->Form->control('notes', [
                'type' => 'textarea',
                'label' => 'Notes',
                'class' => 'form-control',
                'rows' => 3,
                'placeholder' => 'Enter remarks or warranty details',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Upload Bill/Invoice -->
        <div class="col-md-6 mb-4 mt-4">
            <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3">
                <h6 class="fw-bold mb-2"><i class="fas fa-file-invoice me-2"></i> Upload Bill / Invoice</h6>
                <p class="text-muted small mb-2">Drag & drop file here or click below</p>

                <?= $this->Form->control('bill_document', [
                    'type' => 'file',
                    'class' => 'd-none',
                    'label' => false,
                    'id' => 'bill_doc',
                    'templates' => [
                        'error' => '<div class="form-error text-danger">{{content}}</div>'
                    ]
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#bill_doc">
                    Browse File
                </button>

                <div id="preview_bill_doc" class="mt-3">
                    <?php if (!empty($record->bill_document)): ?>
                        <a href="<?= $this->Url->build("/uploads/{$record->bill_document}") ?>" target="_blank"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-file-alt"></i> View Uploaded Bill
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- AMC / Warranty -->
        <div class="col-md-6 mt-3 d-flex align-items-center">
            <?= $this->Form->control('amc_warranty', [
                'type' => 'checkbox',
                'label' => 'AMC / Warranty',
                'class' => 'form-check-input ms-2',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
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


<!-- Styles -->
<style>
    .upload-zone {
        border: 2px dashed #ccc;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .upload-zone.dragover {
        border-color: #007bff;
        background: #f0f8ff;
    }
</style>
<script>
    $(document).ready(function() {

        flatpickr(".datepicker", {
            dateFormat: "d-m-Y",
            allowInput: true
        });
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });
    });
</script>
<script>
    $(function() {
        $(".browse-btn").on("click", function() {
            $($(this).data("target")).trigger("click");
        });

        $(".upload-zone").on("dragover", function(e) {
            e.preventDefault();
            $(this).addClass("dragover");
        }).on("dragleave", function(e) {
            e.preventDefault();
            $(this).removeClass("dragover");
        }).on("drop", function(e) {
            e.preventDefault();
            $(this).removeClass("dragover");
            let input = $(this).find("input[type=file]")[0];
            input.files = e.originalEvent.dataTransfer.files;
            $(input).trigger("change");
        });

        function previewFile(input, previewId) {
            let file = input.files[0];
            if (!file) return;
            let reader = new FileReader();
            reader.onload = (e) => {
                if (file.type.startsWith("image/")) {
                    $(`#${previewId}`).html(`<img src="${e.target.result}" class="img-thumbnail shadow-sm" style="max-height:120px;">`);
                } else {
                    $(`#${previewId}`).html(`<span class="badge bg-secondary">${file.name}</span>`);
                }
            };
            reader.readAsDataURL(file);
        }

        $("#bill_doc").on("change", function() {
            previewFile(this, "preview_bill_doc");
        });

        $('#vehicle-code').on('change', function() {

            const vehical_code = $(this).val();
            if (!vehical_code) {
                $('textarea[name="policy_no"]').val('');
                return;
            }
            showLoader();
            $.ajax({
                url: '<?= $this->Url->build(["controller" => "Insurance", "action" => "getVehicleDetails"]); ?>/' + vehical_code,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('input[name="policy_no"]').val(response.data.insurance_policy_no);
                        $('input[name="vendor"]').val(response.data.vendor);
                        $('input[name="fuel_type"]').val(response.data.fuel_type);
                        $('input[name="chassis_no"]').val(response.data.chassis_no);
                        $('input[name="engine_no"]').val(response.data.engine_no);
                        $('input[name="year"]').val(response.data.model_year);
                        hideLoader()
                    }
                    //  else {
                    //     $('input[name="insurer_contact"]').val('');
                    //     $('textarea[name="insurer_address"]').val('');
                    // }
                },
                error: function() {
                    hideLoader()
                    console.error("Error fetching company details");
                }
            });
        });
    });
</script>