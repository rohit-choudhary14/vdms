<?php
// Updated Vehicle Form with Master Tables Integration and Validations
?>

<style>
  .upload-zone {
    border: 2px dashed #ccc;
    border-radius: 10px;
    transition: all 0.3s;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    background: #f8f9fa;
  }

  .upload-zone.dragover {
    border-color: #007bff;
    background: #f0f8ff;
  }

  .upload-zone:hover {
    border-color: #007bff;
    background: #f8f9fa;
  }

  .file-info {
    margin-top: 10px;
    font-size: 14px;
    color: #666;
  }

  .additional-info-section {
    display: none;
  }

  .additional-info-section.show {
    display: block;
  }
</style>

<!-- UPDATED JAVASCRIPT FOR DEPENDENT DROPDOWNS AND VALIDATIONS -->
<script>
  flatpickr(".datepicker", {
    dateFormat: "d-m-Y",
    allowInput: true
  });

  $(document).ready(function () {
    // CSRF Token for AJAX requests
    var csrfToken = $('[name="_csrfToken"]').val();

    // Vehicle Status Toggle - Show/Hide Additional Information
    $('input[name="vehicle_status"]').on('change', function() {
        if ($(this).val() === 'existing') {
            $('.additional-info-section').addClass('show');
        } else {
            $('.additional-info-section').removeClass('show');
        }
    });

    // Manufacturer dropdown change event
    $('#manufacturer-dropdown').on('change', function() {
        var manufacturerId = $(this).val();

        if (manufacturerId) {
            // Enable and populate model dropdown
            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'getModels']) ?>',
                type: 'POST',
                data: {
                    manufacturer_id: manufacturerId,
                    _csrfToken: csrfToken
                },
                beforeSend: function() {
                    $('#model-dropdown').prop('disabled', true).html('<option value="">Loading models...</option>');
                    $('#year-dropdown').prop('disabled', true).html('<option value="">Select Year (Choose Model First)</option>');
                    $('#seating-capacity').val('');
                    $('#fuel-type').val('');
                },
                success: function(response) {
                    var options = '<option value="">Select Model</option>';

                    if (response.models && response.models.length > 0) {
                        response.models.forEach(function(model) {
                            options += '<option value="' + model.id + '" data-seats="' + model.seating_capacity + '" data-fuel="' + model.fuel_type + '">' + model.model_name + '</option>';
                        });
                        $('#model-dropdown').prop('disabled', false).html(options);
                    } else {
                        $('#model-dropdown').html('<option value="">No models available</option>');
                    }
                },
                error: function() {
                    alert('Error loading models');
                }
            });
        } else {
            $('#model-dropdown').prop('disabled', true).html('<option value="">Select Model (Choose Manufacturer First)</option>');
            $('#year-dropdown').prop('disabled', true).html('<option value="">Select Year (Choose Model First)</option>');
            $('#seating-capacity').val('');
            $('#fuel-type').val('');
        }
    });

    // Model dropdown change event
    $('#model-dropdown').on('change', function() {
        var modelId = $(this).val();
        var selectedOption = $(this).find('option:selected');

        if (modelId) {
            // Auto-fill seating capacity and fuel type
            var seats = selectedOption.data('seats');
            var fuel = selectedOption.data('fuel');

            $('#seating-capacity').val(seats || '');
            $('#fuel-type').val(fuel || '');

            // Fetch years for selected model
            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'getYears']) ?>',
                type: 'POST',
                data: {
                    model_id: modelId,
                    _csrfToken: csrfToken
                },
                beforeSend: function() {
                    $('#year-dropdown').prop('disabled', true).html('<option value="">Loading years...</option>');
                },
                success: function(response) {
                    var options = '<option value="">Select Year</option>';

                    if (response.years && response.years.length > 0) {
                        response.years.forEach(function(year) {
                            options += '<option value="' + year.id + '" data-year="' + year.year + '">' + year.year + '</option>';
                        });
                        $('#year-dropdown').prop('disabled', false).html(options);
                    } else {
                        $('#year-dropdown').html('<option value="">No years available</option>');
                    }
                },
                error: function() {
                    alert('Error loading years');
                }
            });
        } else {
            $('#year-dropdown').prop('disabled', true).html('<option value="">Select Year (Choose Model First)</option>');
            $('#seating-capacity').val('');
            $('#fuel-type').val('');
        }
    });

    // Store selected model year for validation
    $('#year-dropdown').on('change', function() {
        var selectedYear = $(this).find('option:selected').data('year');
        $(this).data('selected-year', selectedYear);
    });

    // Date validation against model year
    function validateDateAgainstModelYear(dateField, fieldName) {
        var modelYear = $('#year-dropdown').data('selected-year');
        var dateValue = dateField.val();

        if (modelYear && dateValue) {
            // Parse date (assuming d-m-Y format)
            var dateParts = dateValue.split('-');
            if (dateParts.length === 3) {
                var day = parseInt(dateParts[0]);
                var month = parseInt(dateParts[1]) - 1; // JS months are 0-indexed
                var year = parseInt(dateParts[2]);
                var selectedDate = new Date(year, month, day);
                var modelYearStart = new Date(modelYear, 0, 1); // Jan 1 of model year

                if (selectedDate < modelYearStart) {
                    alert(fieldName + ' cannot be before the model year (' + modelYear + ')');
                    dateField.val('');
                    return false;
                }
            }
        }
        return true;
    }

    // Purchase Date validation
    $('#purchase-date').on('change', function() {
        validateDateAgainstModelYear($(this), 'Purchase Date');
    });

    // Insurance Expiry validation
    $('#insurance-expiry').on('change', function() {
        validateDateAgainstModelYear($(this), 'Insurance Expiry Date');
    });

    // File upload validations
    function validatePDFFile(fileInput, maxSize) {
        var file = fileInput[0].files[0];
        if (file) {
            // Check file type
            var fileType = file.type;
            if (fileType !== 'application/pdf') {
                alert('Only PDF files are allowed for this document');
                fileInput.val('');
                return false;
            }

            // Check file size (maxSize in MB)
            var fileSize = file.size / 1024 / 1024; // Convert to MB
            if (fileSize > maxSize) {
                alert('File size must not exceed ' + maxSize + 'MB');
                fileInput.val('');
                return false;
            }

            return true;
        }
    }

    function validateImageFile(fileInput, maxSize) {
        var file = fileInput[0].files[0];
        if (file) {
            // Check file type
            var fileType = file.type;
            if (fileType !== 'image/jpeg' && fileType !== 'image/jpg') {
                alert('Only JPG/JPEG files are allowed for photos');
                fileInput.val('');
                return false;
            }

            // Check file size (maxSize in MB)
            var fileSize = file.size / 1024 / 1024; // Convert to MB
            if (fileSize > maxSize) {
                alert('Image size must not exceed ' + maxSize + 'MB');
                fileInput.val('');
                return false;
            }

            return true;
        }
    }

    // Registration Document validation (PDF, 5MB)
    $('#registrationDoc').on('change', function() {
        if (validatePDFFile($(this), 5)) {
            var fileName = this.files[0].name;
            $(this).closest('.upload-zone').find('.file-info').text('Selected: ' + fileName);
        }
    });

    // Bill Document validation (PDF, 5MB)
    $('#billDoc').on('change', function() {
        if (validatePDFFile($(this), 5)) {
            var fileName = this.files[0].name;
            $(this).closest('.upload-zone').find('.file-info').text('Selected: ' + fileName);
        }
    });

    // Photo Front validation (JPG/JPEG, 2MB)
    $('#photoFront').on('change', function() {
        if (validateImageFile($(this), 2)) {
            var fileName = this.files[0].name;
            $(this).closest('.upload-zone').find('.file-info').text('Selected: ' + fileName);
        }
    });

    // Photo Back validation (JPG/JPEG, 2MB)
    $('#photoBack').on('change', function() {
        if (validateImageFile($(this), 2)) {
            var fileName = this.files[0].name;
            $(this).closest('.upload-zone').find('.file-info').text('Selected: ' + fileName);
        }
    });

    // Form submission validation
    $('form').on('submit', function(e) {
        var modelYear = $('#year-dropdown').data('selected-year');

        // Validate purchase date
        if (!validateDateAgainstModelYear($('#purchase-date'), 'Purchase Date')) {
            e.preventDefault();
            return false;
        }

        // Validate insurance expiry
        if (!validateDateAgainstModelYear($('#insurance-expiry'), 'Insurance Expiry Date')) {
            e.preventDefault();
            return false;
        }

        return true;
    });

    // Drag and drop functionality
    $('.upload-zone').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    $('.upload-zone').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    $('.upload-zone').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');

        var fileInput = $(this).find('input[type="file"]');
        var files = e.originalEvent.dataTransfer.files;

        if (files.length > 0) {
            fileInput[0].files = files;
            fileInput.trigger('change');
        }
    });

    // Click to upload
    $('.upload-zone').on('click', function() {
        $(this).find('input[type="file"]').click();
    });
  });
</script>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= __('Add New Vehicle') ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Vehicle</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-car me-1"></i>
            Vehicle Information Form
        </div>
        <div class="card-body">
            <?= $this->Form->create($vehicle, ['type' => 'file', 'class' => 'needs-validation']) ?>

            <!-- Vehicle Status Radio Buttons -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Vehicle Status <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="vehicle_status" id="vehicleStatusNew" value="new" checked>
                            <label class="form-check-label" for="vehicleStatusNew">
                                Newly Purchased Vehicle
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="vehicle_status" id="vehicleStatusExisting" value="existing">
                            <label class="form-check-label" for="vehicleStatusExisting">
                                Already Existed Vehicle
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Basic Vehicle Information -->
            <h5 class="mb-3">Basic Information</h5>

            <div class="row mb-3">
                <!-- Vehicle Code -->
                <div class="col-md-4">
                    <?= $this->Form->control('vehicle_code', [
                        'class' => 'form-control',
                        'label' => ['text' => 'Vehicle Code <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true,
                        'placeholder' => 'Enter unique vehicle code'
                    ]) ?>
                </div>

                <!-- Registration Number -->
                <div class="col-md-4">
                    <?= $this->Form->control('registration_no', [
                        'class' => 'form-control',
                        'label' => ['text' => 'Registration Number <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true,
                        'placeholder' => 'e.g., RJ14AB1234'
                    ]) ?>
                </div>

                <!-- Chassis Number -->
                <div class="col-md-4">
                    <?= $this->Form->control('chassis_no', [
                        'class' => 'form-control',
                        'label' => ['text' => 'Chassis Number', 'escape' => false],
                        'placeholder' => 'Enter chassis number'
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Engine Number -->
                <div class="col-md-4">
                    <?= $this->Form->control('engine_no', [
                        'class' => 'form-control',
                        'label' => ['text' => 'Engine Number', 'escape' => false],
                        'placeholder' => 'Enter engine number'
                    ]) ?>
                </div>

                <!-- Manufacturer -->
                <div class="col-md-4">
                    <?= $this->Form->control('manufacturer_id', [
                        'options' => $manufacturers,
                        'empty' => 'Select Manufacturer',
                        'class' => 'form-select',
                        'label' => ['text' => 'Manufacturer <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true,
                        'id' => 'manufacturer-dropdown'
                    ]) ?>
                </div>

                <!-- Model -->
                <div class="col-md-4">
                    <?= $this->Form->control('model_id', [
                        'options' => [],
                        'empty' => 'Select Model (Choose Manufacturer First)',
                        'class' => 'form-select',
                        'label' => ['text' => 'Model <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true,
                        'disabled' => true,
                        'id' => 'model-dropdown'
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Fuel Type (after model) -->
                <div class="col-md-4">
                    <?= $this->Form->control('fuel_type', [
                        'class' => 'form-control',
                        'label' => 'Fuel Type',
                        'readonly' => true,
                        'id' => 'fuel-type',
                        'placeholder' => 'Auto-filled from model'
                    ]) ?>
                </div>

                <!-- Model Year -->
                <div class="col-md-4">
                    <?= $this->Form->control('model_year_id', [
                        'options' => [],
                        'empty' => 'Select Year (Choose Model First)',
                        'class' => 'form-select',
                        'label' => ['text' => 'Model Year <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true,
                        'disabled' => true,
                        'id' => 'year-dropdown'
                    ]) ?>
                </div>

                <!-- Seating Capacity -->
                <div class="col-md-4">
                    <?= $this->Form->control('seating_capacity', [
                        'class' => 'form-control',
                        'label' => 'Seating Capacity',
                        'readonly' => true,
                        'id' => 'seating-capacity',
                        'placeholder' => 'Auto-filled from model'
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Vehicle Condition - Normal Dropdown -->
                <div class="col-md-4">
                    <?= $this->Form->control('vehicle_condition', [
                        'type' => 'select',
                        'options' => [
                            'excellent' => 'Excellent',
                            'good' => 'Good',
                            'fair' => 'Fair',
                            'poor' => 'Poor'
                        ],
                        'empty' => 'Select Condition',
                        'class' => 'form-select',
                        'label' => ['text' => 'Vehicle Condition <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true
                    ]) ?>
                </div>

                <!-- Color -->
                <div class="col-md-4">
                    <?= $this->Form->control('color', [
                        'class' => 'form-control',
                        'label' => 'Color',
                        'placeholder' => 'e.g., White, Black, Red'
                    ]) ?>
                </div>

                <!-- Vehicle Type -->
                <div class="col-md-4">
                    <?= $this->Form->control('vehicle_type_id', [
                        'options' => $vehicleTypes,
                        'empty' => 'Select Vehicle Type',
                        'class' => 'form-select',
                        'label' => ['text' => 'Vehicle Type <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true
                    ]) ?>
                </div>
            </div>

            <hr class="my-4">

            <!-- Purchase & Insurance Information -->
            <h5 class="mb-3">Purchase & Insurance Details</h5>

            <div class="row mb-3">
                <!-- Purchase Date -->
                <div class="col-md-4">
                    <?= $this->Form->control('purchase_date', [
                        'type' => 'text',
                        'class' => 'form-control datepicker',
                        'label' => ['text' => 'Purchase Date <span class="text-danger">*</span>', 'escape' => false],
                        'required' => true,
                        'id' => 'purchase-date',
                        'placeholder' => 'DD-MM-YYYY'
                    ]) ?>
                    <small class="text-muted">Cannot be before model year</small>
                </div>

                <!-- Current Odometer Reading -->
                <div class="col-md-4">
                    <?= $this->Form->control('current_odometer_reading', [
                        'type' => 'number',
                        'class' => 'form-control',
                        'label' => 'Current Odometer Reading (km)',
                        'placeholder' => 'Enter kilometers'
                    ]) ?>
                </div>

                <!-- Last Service Date -->
                <div class="col-md-4">
                    <?= $this->Form->control('last_service_date', [
                        'type' => 'text',
                        'class' => 'form-control datepicker',
                        'label' => 'Last Service Date',
                        'placeholder' => 'DD-MM-YYYY'
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Number of Keys -->
                <div class="col-md-4">
                    <?= $this->Form->control('number_of_keys', [
                        'type' => 'number',
                        'class' => 'form-control',
                        'label' => 'Number of Keys',
                        'placeholder' => 'Enter number'
                    ]) ?>
                </div>

                <!-- Insurance Policy Number -->
                <div class="col-md-4">
                    <?= $this->Form->control('insurance_policy_number', [
                        'class' => 'form-control',
                        'label' => 'Insurance Policy Number',
                        'placeholder' => 'Enter policy number'
                    ]) ?>
                </div>

                <!-- Insurance Expiry Date -->
                <div class="col-md-4">
                    <?= $this->Form->control('insurance_expiry', [
                        'type' => 'text',
                        'class' => 'form-control datepicker',
                        'label' => 'Insurance Expiry Date',
                        'id' => 'insurance-expiry',
                        'placeholder' => 'DD-MM-YYYY'
                    ]) ?>
                    <small class="text-muted">Cannot be before model year</small>
                </div>
            </div>

            <hr class="my-4">

            <!-- Additional Information (Only for Existing Vehicles) -->
            <div class="additional-info-section">
                <h5 class="mb-3">Additional Information (Already Existed Vehicle)</h5>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <?= $this->Form->control('additional_info', [
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'label' => 'Additional Information',
                            'rows' => 4,
                            'placeholder' => 'Enter any additional details about this existing vehicle...'
                        ]) ?>
                    </div>
                </div>

                <hr class="my-4">
            </div>

            <!-- Document Uploads -->
            <h5 class="mb-3">Document Uploads</h5>

            <div class="row mb-4">
                <!-- Registration Document (PDF, 5MB) -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Registration Document (PDF only, Max 5MB)</label>
                    <div class="upload-zone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                        <p class="mb-0">Drag & drop file here or click to browse</p>
                        <p class="text-muted small">Accepted: PDF only | Max size: 5MB</p>
                        <div class="file-info text-primary"></div>
                        <?= $this->Form->control('registration_doc', [
                            'type' => 'file',
                            'class' => 'd-none',
                            'label' => false,
                            'id' => 'registrationDoc',
                            'templates' => [
                                'error' => '<div class="invalid-feedback d-block">{content}</div>'
                            ]
                        ]) ?>
                    </div>
                </div>

                <!-- Bill Document (PDF, 5MB) -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Bill/Purchase Document (PDF only, Max 5MB)</label>
                    <div class="upload-zone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                        <p class="mb-0">Drag & drop file here or click to browse</p>
                        <p class="text-muted small">Accepted: PDF only | Max size: 5MB</p>
                        <div class="file-info text-primary"></div>
                        <?= $this->Form->control('bill_doc', [
                            'type' => 'file',
                            'class' => 'd-none',
                            'label' => false,
                            'id' => 'billDoc',
                            'templates' => [
                                'error' => '<div class="invalid-feedback d-block">{content}</div>'
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Photo Uploads -->
            <h5 class="mb-3">Vehicle Photos</h5>

            <div class="row mb-4">
                <!-- Photo Front (JPG/JPEG, 2MB) -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Front Photo (JPG/JPEG only, Max 2MB)</label>
                    <div class="upload-zone">
                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                        <p class="mb-0">Drag & drop image here or click to browse</p>
                        <p class="text-muted small">Accepted: JPG, JPEG only | Max size: 2MB</p>
                        <div class="file-info text-primary"></div>
                        <?= $this->Form->control('photo_front', [
                            'type' => 'file',
                            'class' => 'd-none',
                            'label' => false,
                            'id' => 'photoFront',
                            'templates' => [
                                'error' => '<div class="invalid-feedback d-block">{content}</div>'
                            ]
                        ]) ?>
                    </div>
                </div>

                <!-- Photo Back (JPG/JPEG, 2MB) -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Back Photo (JPG/JPEG only, Max 2MB)</label>
                    <div class="upload-zone">
                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                        <p class="mb-0">Drag & drop image here or click to browse</p>
                        <p class="text-muted small">Accepted: JPG, JPEG only | Max size: 2MB</p>
                        <div class="file-info text-primary"></div>
                        <?= $this->Form->control('photo_back', [
                            'type' => 'file',
                            'class' => 'd-none',
                            'label' => false,
                            'id' => 'photoBack',
                            'templates' => [
                                'error' => '<div class="invalid-feedback d-block">{content}</div>'
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Form Actions -->
            <div class="d-flex justify-content-between">
                <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <?= $this->Form->button(__('Save Vehicle'), [
                    'class' => 'btn btn-primary',
                    'type' => 'submit'
                ]) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
