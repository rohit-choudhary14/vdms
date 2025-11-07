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
        <!-- engine no  -->
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
        <!-- chesis no  -->
        <div class="col-md-6">
            <?= $this->Form->control('chesis_no', [
                'label' => 'Chesis No',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <!-- vendor -->
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
        <!-- fuel type -->
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
        <!-- Policy No -->
        <div class="col-md-6">
            <?= $this->Form->control('policy_no', [
                'label' => 'Policy Number',
                'class' => 'form-control',
                'readonly' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <!-- Insurance Company Dropdown -->
        <div class="col-md-6">
            <?= $this->Form->control('insurance_company_id', [
                'label' => 'Insurance Company',
                'options' => $insuranceCompanies,
                'class' => 'form-select form-control select2',
                'empty' => 'Select Insurance Company',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <!-- Nature -->
        <div class="col-md-6">
            <?= $this->Form->control('nature', [
                'id' => "nature",
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
        <div class="col-md-6" id="idv-container">
            <?= $this->Form->control('idv', [
                'label' => 'IDV (Auto Calculated)',
                'class' => 'form-control',
                'readonly' => true,
                'placeholder' => 'Auto Calculated'
            ]) ?>
        </div>


        <!-- Auto-filled Contact -->
        <div class="col-md-6">
            <?= $this->Form->control('insurer_contact', [
                'label' => 'Contact Number',
                'type' => 'text',
                'readonly' => true,
                'class' => 'form-control',
                'placeholder' => 'Auto-filled contact number',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Auto-filled Address -->
        <div class="col-md-6">
            <?= $this->Form->control('insurer_address', [
                'label' => 'Address',
                'type' => 'textarea',
                'readonly' => true,
                'rows' => 2,
                'class' => 'form-control',
                'placeholder' => 'Auto-filled address',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>

        <!-- Insurer -->
        <!-- <div class="col-md-6">
            <?= $this->Form->control('insurer_name', [
                'label' => 'Insurer Name',
                'class' => 'form-control',
                'placeholder' => 'Enter insurer name',
                'required' => true,
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>  -->

        <!-- Contact & Address -->
        <!-- <div class="col-md-6">
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
        </div> -->

        <!-- <div class="col-md-6">
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
        </div> -->

        <!-- Dates -->
        <div class="col-md-6">
            <?= $this->Form->control('start_date', [
                'label' => 'Start Date',
                'type' => 'text',
                'class' => 'form-control datepicker',
                'placeholder' => 'Select start date',
                'autocomplete' => 'off',
                'value' => $insurance->start_date ?? '',

                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>



        </div>
        <div class="col-md-6">
            <?= $this->Form->control('expiry_date', [
                'id' => 'expiry-date',
                'label' => 'Expiry Date',
                'type' => 'text',
                'class' => 'form-control datepicker',
                'placeholder' => 'Select expiry date',
                'value' => $insurance->expiry_date ?? '',
                'autocomplete' => 'off',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ]
            ]) ?>
        </div>
        <div class="col-md-6">

            <?= $this->Form->control('next_due', [
                'id' => 'next-due',
                'label' => 'Next Insurance Due Date',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $insurance->next_due ?? '',

                'readonly' => true
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
                'options' => [
                    'Active' => 'Active',
                    'Expired' => 'Expired',
                    'Renewed' => 'Renewed'
                ],
                'label' => 'Status',
                'id' => 'status',
                'class' => 'form-select form-control',
                'empty' => 'Select Status',
                'disabled' => true,
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

    function toValidDate(dateStr) {
        const [day, month, year] = dateStr.split("-");

        let fullYear = parseInt(year);
        if (fullYear < 100) {
            fullYear += 2000;
        }

        return new Date(fullYear, parseInt(month) - 1, parseInt(day));
    }

    function updateDates() {

        const startVal = $('input[name="start_date"]').val();
        const expiryVal = $('#expiry-date').val();
        const nextDue = $('#next-due');
        const status = $('#status');
        if (!startVal || !expiryVal) return;
        const startDate = toValidDate(startVal);
        const expiryDate = toValidDate(expiryVal);
        let today = new Date();
        today.setHours(0, 0, 0, 0);
        if (expiryDate < startDate) {
            if ($('#expiry-date').data('datepicker')) {
                $('#expiry-date').datepicker('setDate', null);
            }
            if ($('#expiry-date')[0]._flatpickr) {
                $('#expiry-date')[0]._flatpickr.clear();
            }
            $('#expiry-date').val('');
            nextDue.val('');
            status.val('').trigger('change');
            alert("Expiry Date must be greater than or equal to Start Date!");
            return;
        }
        let nextDay = new Date(expiryDate);
        nextDay.setDate(nextDay.getDate() + 1);

        const dd = String(nextDay.getDate()).padStart(2, "0");
        const mm = String(nextDay.getMonth() + 1).padStart(2, "0");
        const yyyy = nextDay.getFullYear();

        nextDue.val(`${dd}-${mm}-${yyyy}`);
        status.val(expiryDate >= today ? "Active" : "Expired");
    }


    $('#expiry-date, input[name="start_date"]').on('change', updateDates);

    $('input[name="policy_no"]').on('input', function() {
        let value = $(this).val().toUpperCase();
        value = value.replace(/[^A-Z0-9/-]/g, '');
        $(this).val(value);
        if (value.length < 8 || value.length > 20) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    $('input[name="premium_amount"]').on('input', function() {
        let value = parseFloat($(this).val());

        // Remove invalid characters (Keep only numbers & decimal)
        $(this).val($(this).val().replace(/[^0-9.]/g, ''));

        if (isNaN(value) || value <= 0) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    function updatePolicyNature() {
        const policyType = $('#nature').val();
        const addonsField = $('#addons'); // ✅ Correct selector
        const addonsWrapper = addonsField.closest('.col-md-6'); // ✅ Hide the whole field block
        const renewalAlert = $('input[name="renewal_alert"]');

        if (policyType === "Third Party") {
            addonsWrapper.hide();
            addonsField.val(null).trigger('change.select2');

            renewalAlert.prop('checked', false).prop('disabled', true);

            $('#nature').css({
                "background-color": "#fff3cd",
                "border": "2px solid #ffc107"
            });

        } else {
            addonsWrapper.show();
            renewalAlert.prop('disabled', false);

            $('#nature').css({
                "background-color": "#ffd3cdff",
                "border": "2px solid #ff4107ff"
            });
        }
    }
    $('#nature').on('change', updatePolicyNature);
    updatePolicyNature();
    $("#insurance_doc").on("change", function() {
        const input = this;
        const file = input.files[0];
        const previewId = "preview_insurance_doc";
        if (!file) return;

        // Step 1: File size validation (5 MB limit)
        const maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
            alert("File too large! Maximum size allowed is 5 MB.");
            resetFileInput(input, previewId);
            return;
        }

        // Step 2: Basic MIME and extension check
        const isPdfType = file.type === "application/pdf";
        const isPdfExtension = file.name.toLowerCase().endsWith(".pdf");

        if (!isPdfType || !isPdfExtension) {
            alert("Only valid PDF files are allowed!");
            resetFileInput(input, previewId);
            return;
        }

        // Step 3: Validate PDF header (%PDF-)
        const reader = new FileReader();
        reader.onload = function(e) {
            const bytes = new Uint8Array(e.target.result).subarray(0, 5);
            const header = Array.from(bytes)
                .map(b => b.toString(16).padStart(2, "0"))
                .join("");

            if (header !== "255044462d") {
                alert("Invalid or corrupted PDF file!");
                resetFileInput(input, previewId);
                return;
            }
            showFileLink(file, previewId);
        };

        reader.onerror = function() {
            alert("Error reading file. Please try again.");
            resetFileInput(input, previewId);
        };

        reader.readAsArrayBuffer(file);
    });

    function resetFileInput(input, previewId) {
        input.value = "";
        $(`#${previewId}`).html('<span class="text-muted">No file chosen</span>');
    }

    function showFileLink(file, previewId) {
        const fileURL = URL.createObjectURL(file);
        $(`#${previewId}`).html(`
        <a href="${fileURL}" target="_blank" class="btn btn-sm btn-primary">
            <i class="fa fa-file-pdf-o"></i>${file.name}
        </a>
    `);
    }
    $('#insurance-company-id').on('change', function() {
        const companyId = $(this).val();
        if (!companyId) {
            $('textarea[name="insurer_address"]').val('');
            $('input[name="insurer_contact"]').val('');
            return;
        }

        $.ajax({
            url: '<?= $this->Url->build(["controller" => "InsuranceCompanies", "action" => "getDetails"]); ?>/' + companyId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('input[name="insurer_contact"]').val(response.data.contact_number);
                    $('textarea[name="insurer_address"]').val(response.data.address);
                } else {
                    $('input[name="insurer_contact"]').val('');
                    $('textarea[name="insurer_address"]').val('');
                }
            },
            error: function() {
                console.error("Error fetching company details");
            }
        });
    });

    $('#vehicle-code').on('change', function() {
        const vehical_code = $(this).val();
        if (!vehical_code) {
            $('textarea[name="policy_no"]').val('');
            return;
        }

        $.ajax({
            url: '<?= $this->Url->build(["controller" => "Insurance", "action" => "getVehicleDetails"]); ?>/' + vehical_code,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('input[name="policy_no"]').val(response.data.insurance_policy_no);
                    $('input[name="vendor"]').val(response.data.vendor);
                    $('input[name="fuel_type"]').val(response.data.fuel_type);
                }
                //  else {
                //     $('input[name="insurer_contact"]').val('');
                //     $('textarea[name="insurer_address"]').val('');
                // }
            },
            error: function() {
                console.error("Error fetching company details");
            }
        });
    });
</script>