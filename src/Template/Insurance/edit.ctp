<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-lg mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Edit Insurance Record</h5>
    </div>
    <div class="card-body">
        <?= $this->Form->create($insurance, ['type' => 'file', 'class' => 'needs-validation', 'novalidate' => true]) ?>

        <div class="row mb-3">
            <div class="col-md-6">
               
                <?= $this->Form->control('registration_no', [
                    'class' => 'form-control',
                    'placeholder' => 'Vehicle Registration Number',
                    'required' => true,
                     'readonly' => true,
                     'value'=>$vehicles->registration_no,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
               
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('policy_no', [
                    'class' => 'form-control',
                    'placeholder' => 'Enter Policy Number',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $this->Form->control('nature', [
                    'type' => 'select',
                    'options' => ['Comprehensive' => 'Comprehensive', 'Third Party' => 'Third Party'],
                    'class' => 'form-control',
                    'empty' => 'Select Insurance Type',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('insurer_name', [
                    'class' => 'form-control',
                    'placeholder' => 'Enter Insurer Name',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $this->Form->control('insurer_contact', [
                    'class' => 'form-control',
                    'placeholder' => 'Enter Contact Number',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('insurer_address', [
                    'type' => 'textarea',
                    'rows' => 2,
                    'class' => 'form-control',
                    'placeholder' => 'Enter Address',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?= $this->Form->control('start_date', [
                    'type' => 'text',
                    'class' => 'form-control datepicker',
                    'placeholder' => 'YYYY-MM-DD',
                    'value' => !empty($insurance->start_date) ? $insurance->start_date->format('Y-m-d') : '',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('expiry_date', [
                    'type' => 'text',
                    'class' => 'form-control datepicker',
                    'placeholder' => 'YYYY-MM-DD',
                    'value' => !empty($insurance->expiry_date) ? $insurance->expiry_date->format('Y-m-d') : '',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('next_due', [
                    'label' => 'Next Insurance Due',
                    'type' => 'text',
                    'class' => 'form-control datepicker',
                    'placeholder' => 'YYYY-MM-DD',
                    'value' => !empty($insurance->next_due) ? $insurance->next_due->format('Y-m-d') : '',
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
             <div class="col-md-6">
                <?= $this->Form->control('premium_amount', [
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => 0,
                    'class' => 'form-control',
                    'placeholder' => 'Enter Premium Amount',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
        </div>
        <div class="row mb-3">
            
           
            <div class="col-md-6">
                <?= $this->Form->control('status', [
                    'type' => 'select',
                    'options' => ['Active' => 'Active', 'Expired' => 'Expired', 'Renewed' => 'Renewed'],
                    'class' => 'form-control',
                    'required' => true,
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
             <div class="col-md-6">
                <?= $this->Form->control('addons', [
                    'type' => 'textarea',
                    'rows' => 2,
                    'class' => 'form-control',
                    'placeholder' => 'Add-ons or Notes',
                    'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                ]) ?>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3">
                    <h6 class="fw-bold mb-2"><i class="fas fa-file-upload me-2"></i>Insurance Document</h6>
                    <p class="text-muted small mb-2">Drag & drop file here or click below</p>

                    <?= $this->Form->control('document', [
                        'type' => 'file',
                        'class' => 'd-none',
                        'label' => false,
                        'id' => 'insuranceDoc',
                        'templates' => ['error' => '<div class="form-error">{{content}}</div>']
                    ]) ?>
                    <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#insuranceDoc">
                        Browse File
                    </button>

                    <div id="previewInsurance" class="mt-3">
                        <?php if (!empty($insurance->document)): ?>
                            <a href="<?= $this->Url->build("/img/{$insurance->document}") ?>" target="_blank"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-file-alt"></i> View Current Document
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
             <div class="col-md-6 mt-5">
                <?= $this->Form->control('renewal_alert', ['type' => 'checkbox', 'label' => 'Renewal Alert']) ?>
            </div>
        </div>

        <div class="text-end mt-4">
            <?= $this->Form->button('<i class="fas fa-save"></i> Update Insurance', ['escape' => false, 'class' => 'btn btn-success btn-lg px-5 shadow-sm']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

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
        $(".browse-btn").on("click", function () {
            let target = $(this).data("target");
            $(target).trigger("click");
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

        $("#insuranceDoc").on("change", function () { previewFile(this, "previewInsurance"); });
    });
</script>

<script>
    flatpickr(".datepicker", { dateFormat: "Y-m-d", allowInput: true });
</script>