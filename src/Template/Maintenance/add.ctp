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

        <!-- Vehicle -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('vehicle_code', [
                'options' => $vehicles,
                'label' => 'Vehicle',
                'class' => 'form-control',
                'required' => true
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



        <!-- Vendor & Parts -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('vendor', [
                'label' => 'Service Vendor',
                'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

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

        <!-- Cost, Work Order, Bill No -->
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('cost', ['label' => 'Cost Incurred', 'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]]) ?>
        </div>
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('work_order_no', ['label' => 'Work Order No', 'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]]) ?>
        </div>
        <div class="col-md-4 mt-3">
            <?= $this->Form->control('bill_no', ['label' => 'Bill No', 'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]]) ?>
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
            <?= $this->Form->control('bill_amount', ['label' => 'Bill Amount', 'class' => 'form-control',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]]) ?>
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
    $(document).ready(function () {

        flatpickr(".datepicker", {
            dateFormat: "d-m-Y",
            allowInput: true
        });
    });

</script>
<script>
    $(function () {
        $(".browse-btn").on("click", function () {
            $($(this).data("target")).trigger("click");
        });

        $(".upload-zone").on("dragover", function (e) {
            e.preventDefault(); $(this).addClass("dragover");
        }).on("dragleave", function (e) {
            e.preventDefault(); $(this).removeClass("dragover");
        }).on("drop", function (e) {
            e.preventDefault(); $(this).removeClass("dragover");
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

        $("#bill_doc").on("change", function () { previewFile(this, "preview_bill_doc"); });
    });
</script>