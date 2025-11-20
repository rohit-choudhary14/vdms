<?php

use Psy\Readline\Hoa\Autocompleter;
?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">




<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>
<!-- Previous Insurance Details Section -->
<div class="col-12 mt-4" id="previous-insurance-section" style="display:none;">
    <h5 class="mb-3">
        <i class="fas fa-history me-2"></i> Previous Insurance History
    </h5>

    <table class="table table-bordered table-striped" id="previous-insurance-table">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Policy No</th>
                <th>Company</th>
                <th>Start</th>
                <th>Expiry</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="previous-insurance-body"></tbody>
    </table>
</div>

<!-- Modal for Detailed View -->
<div class="modal fade" id="insuranceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Insurance Details</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="insurance-modal-body">
                <!-- Filled by JS -->
            </div>

        </div>
    </div>
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
            <?= $this->Form->control('chassis_no', [
                'label' => 'Chasis No',
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

        <!-- Insurer -->
        <div class="col-md-6">
            <?= $this->Form->control('insurer_name', [
                'label' => 'Insurer Name',
                'class' => 'form-control',
                'readonly' => true,
                'placeholder' => 'Auto-filled  insurer name',
                'required' => true,
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
                // 'value' => $insurance->next_due ?? '',
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ],
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
            <?= $this->Form->control('addons', [
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
                'templates' => [
                    'error' => '<div class="form-error text-danger">{{content}}</div>'
                ],
                'multiple' => true,
                'class' => 'form-control select2-multi',
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

.btn-close {
    width: 1em;
    height: 1em;
    background: none;
    border: 0;
    font-size: 1.5rem;
    line-height: 1;
    opacity: .7;
}
.btn-close::after {
    content: "×";
    font-weight: bold;
}

</style>

<script>
    $(document).ready(function () {
        $('.select2-multi').select2({
            placeholder: "Select Add-ons Coverage",
            closeOnSelect: false,
            allowClear: true,

        });

        $(".browse-btn").on("click", function () {
            let target = $(this).data("target");
            $(target).trigger("click");
        });

        $(".upload-zone").on("dragover", function (e) {
            e.preventDefault();
            $(this).addClass("dragover");
        }).on("dragleave", function (e) {
            e.preventDefault();
            $(this).removeClass("dragover");
        }).on("drop", function (e) {
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
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('input[name="insurer_contact"]');

        input.addEventListener('input', function () {
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

    $('input[name="policy_no"]').on('input', function () {
        let value = $(this).val().toUpperCase();
        value = value.replace(/[^A-Z0-9/-]/g, '');
        $(this).val(value);
        if (value.length < 8 || value.length > 20) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    $('input[name="premium_amount"]').on('input', function () {
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
    $("#insurance_doc").on("change", function () {
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
        reader.onload = function (e) {
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

        reader.onerror = function () {
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
    $('#insurance-company-id').on('change', function () {

        const companyId = $(this).val();

        if (!companyId) {
            $('textarea[name="insurer_address"]').val('');
            $('input[name="insurer_contact"]').val('');
            return;
        }
        showLoader();
        $.ajax({
            url: '<?= $this->Url->build(["controller" => "InsuranceCompanies", "action" => "getDetails"]); ?>/' + companyId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log(response.data);
                    $('input[name="insurer_contact"]').val(response.data.contact_number);
                    $('textarea[name="insurer_address"]').val(response.data.address);
                    $('input[name="insurer_name"]').val(response.data.insurer_name);
                } else {
                    $('input[name="insurer_contact"]').val('');
                    $('textarea[name="insurer_address"]').val('');
                }
                hideLoader();
            },
            error: function () {
                hideLoader();
                console.error("Error fetching company details");
            }
        });
    });

    $('#vehicle-code').on('change', function () {
        const vehical_code = $(this).val();
        console.log(vehical_code);
        if (!vehical_code) {
            $('textarea[name="policy_no"]').val('');
            return;
        }
        showLoader();
        $.ajax({
            url: '<?= $this->Url->build(["controller" => "Insurance", "action" => "getVehicleDetails"]); ?>/' + vehical_code,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('input[name="policy_no"]').val(response.data.insurance_policy_no);
                    $('input[name="vendor"]').val(response.data.vendor);
                    $('input[name="fuel_type"]').val(response.data.fuel_type);
                    $('input[name="chassis_no"]').val(response.data.chassis_no);
                    $('input[name="engine_no"]').val(response.data.engine_no);
                   if (response.previous_insurance && response.previous_insurance.length > 0) {

    $("#previous-insurance-section").show();

    let rows = "";

    response.previous_insurance.forEach(function(item, index) {

        let badge = `<span class="badge ${item.status === 'active' ? 'bg-success' : 'bg-secondary'}">${item.status}</span>`;

        rows += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.policy_no}</td>
                <td>${item.company_name}</td>
                <td>${item.start_date}</td>
                <td>${item.expiry_date}</td>
                <td>${badge}</td>
                <td>
                    <button class="btn btn-sm btn-primary view-details" 
                            data-item='${JSON.stringify(item)}'>
                        View
                    </button>
                </td>
            </tr>
        `;
    });

    $("#previous-insurance-body").html(rows);

} else {
    $("#previous-insurance-section").hide();
}

                    hideLoader();
                }

            },
            error: function () {
                hideLoader();
                console.error("Error fetching company details");
            }
        });
    });

// ================= VIEW DETAILS MODAL =================

$(document).on("click", ".view-details", function () {

    let item = $(this).data("item");

    let doc = item.document 
        ? `<a href="${item.document}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-file-pdf"></i> View Document
           </a>`
        : `<span class="text-muted">No document</span>`;

    let html = `
        <div class="row g-3">

            <div class="col-md-4"><b>Policy Number:</b><br>${item.policy_no}</div>
            <div class="col-md-4"><b>Company:</b><br>${item.company_name}</div>
            <div class="col-md-4"><b>Premium:</b><br>₹ ${item.premium_amount}</div>

            <div class="col-md-4"><b>Start Date:</b><br>${item.start_date}</div>
            <div class="col-md-4"><b>Expiry Date:</b><br>${item.expiry_date}</div>
            <div class="col-md-4"><b>Status:</b><br>${item.status}</div>

            <div class="col-md-12"><b>Document:</b><br>${doc}</div>

        </div>
    `;

    $("#insurance-modal-body").html(html);
    $("#insuranceModal").modal("show");
});
</script>