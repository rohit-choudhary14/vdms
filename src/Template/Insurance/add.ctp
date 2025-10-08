<?php

use Psy\Readline\Hoa\Autocompleter;
?>
<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Add New Insurance</h5>
    </div>

    <div class="card-body shadow-lg">
        <?= $this->Form->create($insurance, [
            'type' => 'file',
            'class' => 'row g-4 needs-validation',
            'novalidate' => true
        ]) ?>

        <!-- Vehicle Registration -->
        <div class="col-md-6">
            <?= $this->Form->control('vehicle_code', [
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

        <!-- Policy No -->
        <div class="col-md-6">
            <?= $this->Form->control('policy_no', [
                'label' => 'Policy Number',
                'class' => 'form-control',
                'placeholder' => 'Enter policy number',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Nature -->
        <div class="col-md-6">
            <?= $this->Form->control('nature', [
                'options' => ['Comprehensive' => 'Comprehensive', 'Third Party' => 'Third Party', 'Comprehensive + Third Party ' => 'Comprehensive+Third Party'],
                'class' => 'form-select form-control',
                'label' => 'Policy Nature',
                'empty' => 'Select Type',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Insurer -->
        <div class="col-md-6">
            <?= $this->Form->control('insurer_name', [
                'label' => 'Insurer Name',
                'class' => 'form-control',
                'placeholder' => 'Enter insurer name',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Contact & Address -->
        <div class="col-md-6">
            <?= $this->Form->control('insurer_contact', [
                'label' => 'Insurer Contact',
                'type' => 'tel',
                'class' => 'form-control',
                'placeholder' => 'Enter contact number',
                'maxlength' => 10,
                'minlength' => 10,
                'pattern' => '\d{10}',
                'title' => 'Please enter a valid 10-digit contact number (digits only)',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $this->Form->control('insurer_address', [
                'label' => 'Insurer Address',
                'type' => 'textarea',
                'rows' => 2,
                'class' => 'form-control',
                'placeholder' => 'Enter address',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Dates -->
        <div class="col-md-6">
            <?= $this->Form->control('start_date', [
                'label' => 'Start Date',
                'type' => 'text',
                'class' => 'form-control datepicker',
                'placeholder' => 'Select start date',
                'autocomplete' => 'off',
                'value' => !empty($insurance->start_date)
                    ? $insurance->start_date->format('Y-m-d')
                    : '',

                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>



        </div>
        <div class="col-md-6">
            <?= $this->Form->control('expiry_date', [
                'label' => 'Expiry Date',
                'type' => 'text',
                'class' => 'form-control datepicker',
                'placeholder' => 'Select expiry date',
                'value' => !empty($insurance->expiry_date)
                    ? $insurance->expiry_date->format('Y-m-d')
                    : '',
                'autocomplete' => 'off',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->control('next_due', [
                'label' => 'Next Insurance Due',
                'type' => 'text',
                'class' => 'form-control datepicker',
                'placeholder' => 'Select due date',
                'autocomplete' => 'off',
                'value' => !empty($insurance->next_due)
                    ? $insurance->next_due->format('d/m/Y')
                    : '',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>


        <!-- Premium & Addons -->
        <div class="col-md-6">
            <?= $this->Form->control('premium_amount', [
                'label' => 'Premium Amount',
                'class' => 'form-control',
                'placeholder' => 'Enter amount',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        
<div class="col-md-6">
    <?= $this->Form->control('addons[]', [
        'type' => 'select',
        'label' => 'Select Add-ons Coverage',
        'options' => [
            'zero_depreciation' => 'Zero Depreciation Cover',
            'engine_protection' => 'Engine Protection Cover',
            'roadside_assistance' => 'Roadside Assistance Cover',
            'return_to_invoice' => 'Return to Invoice Cover',
            'key_replacement' => 'Key Replacement Cover',
            'consumables' => 'Consumables Cover',
            'ncb_protection' => 'No Claim Bonus Protection',
            'personal_accident' => 'Personal Accident Cover for Owner-Driver',
        ],
        'multiple' => true,
        'class' => 'form-control select2-multi',  // extra class for JS selector
        'labelOptions' => ['style' => 'font-weight:bold;'],
        'empty' => false,
    ]) ?>
</div>









        <div class="col-md-6">
            <?= $this->Form->control('status', [
                'options' => ['Active' => 'Active', 'Expired' => 'Expired', 'Renewed' => 'Renewed'],
                'label' => 'Status',
                'class' => 'form-select form-control',
                'empty' => 'Select Status',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <!-- File Upload -->
        <div class="col-md-6 mt-5">
            <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3">
                <h6 class="fw-bold mb-2"><i class="fas fa-file-alt me-2"></i>Upload Insurance Document</h6>
                <p class="text-muted small mb-2">Drag & drop file here or click below</p>
                <?= $this->Form->control('document', [
                    'type' => 'file',
                    'class' => 'd-none',
                    'label' => false,
                    'id' => 'insurance_doc',
                    'templates' => [
                        'error' => '<div class="form-error text-danger">{{content}}</div>'
                    ]
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#insurance_doc">
                    Browse File
                </button>
                <div id="preview_insurance_doc" class="mt-3"></div>
            </div>
        </div>
        <!-- Renewal & Status -->
        <div class="col-md-6">

            <div class="form-check mt-4">
                <?= $this->Form->control('renewal_alert', [
                    'type' => 'checkbox',
                    'label' => 'Enable Renewal Alert',
                    'class' => 'form-check-input',
                    'templates' => [
                        'inputContainer' => '<div class="form-check">{{content}}</div>'
                    ]
                ]) ?>
            </div>
        </div>




        <!-- Submit -->
        <div class="col-12 text-end mt-4">
            <?= $this->Form->button('<i class="fas fa-save"></i> Save Insurance', [
                'escape' => false,
                'class' => 'btn btn-success btn-lg px-5 shadow-sm'
            ]) ?>
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
    $(document).ready(function() {
         $('.select2-multi').select2({
        placeholder: "Select Add-ons Coverage",
        closeOnSelect: false,
        allowClear: true,
        
    });
   
        $(".browse-btn").on("click", function() {
            let target = $(this).data("target");
            $(target).trigger("click");
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
                    $(`#${previewId}`).html(
                        `<img src="${e.target.result}" class="img-thumbnail shadow-sm" style="max-height:120px;">`
                    );
                } else {
                    $(`#${previewId}`).html(
                        `<span class="badge bg-secondary">${file.name}</span>`
                    );
                }
            };
            reader.readAsDataURL(file);
        }

        $("#insurance_doc").on("change", function() {
            previewFile(this, "preview_insurance_doc");
        });

        flatpickr(".datepicker", {
            dateFormat: "d-m-y",
            allowInput: true
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector('input[name="insurer_contact"]');

        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Keep digits only

            if (/^(\d)\1{9}$/.test(this.value)) {
                alert('Contact number cannot be the same digit repeated.');
                this.value = '';
            }
        });
         $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });
    });
</script>