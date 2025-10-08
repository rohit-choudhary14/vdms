<?php
// Updated Vehicle Form with Master Tables Integration
?>

<div class="mt-5">
</div>
<?= $this->Html->link(
  '<i class="fas fa-arrow-left me-1"></i> Back',
  ['action' => 'index'],
  ['class' => 'btn btn-outline-dark', 'escape' => false]
) ?>

<div class="card shadow-lg mb-4 mt-2">
  <div class="card-header bg-dark text-white">
    <h5 class="mb-0">Vehicle Details</h5>
  </div>
  <div class="card-body">
    <?= $this->Form->create($vehicle, ['type' => 'file', 'class' => 'needs-validation', 'novalidate' => true]) ?>

    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('registration_no', [
          'class' => 'form-control',
          'label' => 'Registration No',
          'readonly' => !$vehicle->isNew(),
          'placeholder' => 'Enter registration number',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
      
      <!-- UPDATED: Vehicle Type Dropdown -->
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('vehicle_type_id', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Vehicle Type',
          'options' => $vehicleTypes, // From controller
          'empty' => 'Select Vehicle Type',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <div class="form-row mb-3">
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('fuel_type', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Fuel Type',
          'options' => [
            'Petrol' => 'Petrol',
            'Diesel' => 'Diesel',
            'CNG' => 'CNG',
            'Hybrid' => 'Hybrid',
            'Electric' => 'Electric'
          ],
          'empty' => 'Select Fuel Type',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>

      <!-- UPDATED: Manufacturer Dropdown -->
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('manufacturer_id', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Manufacturer',
          'options' => $manufacturers, // From controller
          'empty' => 'Select Manufacturer',
          'required' => true,
          'id' => 'manufacturer-dropdown',
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <div class="form-row mb-3">
      <!-- UPDATED: Model Dropdown (Dependent on Manufacturer) -->
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('model_id', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Vehicle Model',
          'options' => [], // Will be populated via AJAX
          'empty' => 'Select Model (Choose Manufacturer First)',
          'required' => true,
          'id' => 'model-dropdown',
          'disabled' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>

      <!-- UPDATED: Model Year Dropdown (Dependent on Model) -->
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('model_year', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Model Year',
          'options' => [], // Will be populated via AJAX
          'empty' => 'Select Year (Choose Model First)',
          'required' => true,
          'id' => 'year-dropdown',
          'disabled' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <div class="form-row mb-3">
      <!-- UPDATED: Auto-filled Seating Capacity -->
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('seating_capacity', [
          'class' => 'form-control',
          'label' => 'Seating Capacity',
          'type' => 'number',
          'min' => 1,
          'placeholder' => 'Auto-filled from model selection',
          'readonly' => true, // Auto-filled, so readonly
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
        <small class="text-muted">This field will be auto-filled when you select a vehicle model.</small>
      </div>

      <!-- UPDATED: Vehicle Status Dropdown -->
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('status', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Vehicle Status',
          'options' => [
            'Alloted' => 'Alloted',
            'Unalloted' => 'Unalloted',
            'Condemned' => 'Condemned',
            'In-Garage' => 'In-Garage'
          ],
          'empty' => 'Select Status',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('purchase_date', [
          'class' => 'form-control datepicker',
          'label' => 'Purchase Date',
          'type' => 'text',
          'placeholder' => 'YYYY-MM-DD',
          'autocomplete' => 'off',
          'required' => true,
          'value' => !empty($vehicle->purchase_date)
            ? $vehicle->purchase_date->format('Y-m-d')
            : '',
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('purchase_value', [
          'class' => 'form-control',
          'label' => 'Purchase Value',
          'type' => 'number',
          'step' => '0.01',
          'min' => 0,
          'placeholder' => 'Enter purchase value',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('vendor', [
          'class' => 'form-control',
          'label' => 'Vendor',
          'placeholder' => 'Enter vendor name',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <!-- File Upload Sections (keeping original structure) -->
    <div class="row">
      <!-- Registration Document -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneRegistration">
          <h6 class="fw-bold mb-2"><i class="fas fa-file-upload me-2"></i>Registration Document</h6>
          <p class="text-muted small mb-2">Drag & drop file here or click below</p>

          <?= $this->Form->control('registration_doc', [
            'type' => 'file',
            'class' => 'd-none',
            'label' => false,
            'id' => 'registrationDoc',
            'templates' => [
              'error' => '<div class="form-error">{{content}}</div>'
            ]
          ]) ?>
          <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#registrationDoc">
            Browse File
          </button>

          <div id="previewRegistration" class="mt-3">
            <?php if (!empty($vehicle->registration_doc)): ?>
              <a href="<?= $this->Url->build("/img/{$vehicle->registration_doc}") ?>" target="_blank"
                class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-alt"></i> View Current Document
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Bill Document -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneBill">
          <h6 class="fw-bold mb-2"><i class="fas fa-file-invoice me-2"></i>Bill Document</h6>
          <p class="text-muted small mb-2">Drag & drop file here or click below</p>

          <?= $this->Form->control('bill_doc', [
            'type' => 'file',
            'class' => 'd-none',
            'label' => false,
            'id' => 'billDoc',
            'templates' => [
              'error' => '<div class="form-error">{{content}}</div>'
            ]
          ]) ?>
          <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#billDoc">
            Browse File
          </button>

          <div id="previewBill" class="mt-3">
            <?php if (!empty($vehicle->bill_doc)): ?>
              <a href="<?= $this->Url->build("/img/{$vehicle->bill_doc}") ?>" target="_blank"
                class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-alt"></i> View Current Document
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Front Photo -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneFront">
          <h6 class="fw-bold mb-2"><i class="fas fa-car-side me-2"></i>Front Photo</h6>
          <p class="text-muted small mb-2">Drag & drop image here or click below</p>

          <?= $this->Form->control('photo_front', [
            'type' => 'file',
            'class' => 'd-none',
            'label' => false,
            'id' => 'photoFront',
            'templates' => [
              'error' => '<div class="form-error">{{content}}</div>'
            ]
          ]) ?>
          <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#photoFront">
            Browse Image
          </button>

          <div id="previewFront" class="mt-3">
            <?php if (!empty($vehicle->photo_front)): ?>
              <a href="<?= $this->Url->build("/img/{$vehicle->photo_front}") ?>" target="_blank">
                <img src="<?= $this->Url->build("/img/{$vehicle->photo_front}") ?>" class="img-thumbnail shadow-sm"
                  style="max-height:120px;">
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Back Photo -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneBack">
          <h6 class="fw-bold mb-2"><i class="fas fa-car-rear me-2"></i>Back Photo</h6>
          <p class="text-muted small mb-2">Drag & drop image here or click below</p>

          <?= $this->Form->control('photo_back', [
            'type' => 'file',
            'class' => 'd-none',
            'label' => false,
            'id' => 'photoBack',
            'templates' => [
              'error' => '<div class="form-error">{{content}}</div>'
            ]
          ]) ?>
          <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#photoBack">
            Browse Image
          </button>

          <div id="previewBack" class="mt-3">
            <?php if (!empty($vehicle->photo_back)): ?>
              <a href="<?= $this->Url->build("/img/{$vehicle->photo_back}") ?>" target="_blank">
                <img src="<?= $this->Url->build("/img/{$vehicle->photo_back}") ?>" class="img-thumbnail shadow-sm"
                  style="max-height:120px;">
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group text-right">
      <?= $this->Form->button(__('Save'), ['class' => 'btn btn-success px-4']) ?>
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

<!-- UPDATED JAVASCRIPT FOR DEPENDENT DROPDOWNS -->
<script>
  flatpickr(".datepicker", {
    dateFormat: "Y-m-d",
    allowInput: true
  });

  $(document).ready(function () {
    // CSRF Token for AJAX requests
    var csrfToken = $('[name="_csrfToken"]').val();
    
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
                },
                success: function(response) {
                    var options = '<option value="">Select Model</option>';
                    
                    if (response.models && response.models.length > 0) {
                        response.models.forEach(function(model) {
                            options += '<option value="' + model.id + '" data-seats="' + model.seating_capacity + '" data-fuel="' + model.fuel_type + '">' + model.model_name + '</option>';
                        });
                        $('#model-dropdown').prop('disabled', false).html(options);
                    } else {
                        $('#model-dropdown').prop('disabled', true).html('<option value="">No models found</option>');
                    }
                },
                error: function() {
                    alert('Error loading models. Please try again.');
                    $('#model-dropdown').prop('disabled', true).html('<option value="">Error loading models</option>');
                }
            });
        } else {
            // Reset dependent dropdowns
            $('#model-dropdown').prop('disabled', true).html('<option value="">Select Model (Choose Manufacturer First)</option>');
            $('#year-dropdown').prop('disabled', true).html('<option value="">Select Year (Choose Model First)</option>');
            $('#seating-capacity').val('');
        }
    });

    // Model dropdown change event  
    $('#model-dropdown').on('change', function() {
        var modelId = $(this).val();
        var selectedOption = $(this).find('option:selected');
        
        if (modelId) {
            // Auto-fill seating capacity
            var seatingCapacity = selectedOption.data('seats');
            $('#seating-capacity').val(seatingCapacity);
            
            // Load available years for this model
            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'getModelYears']) ?>',
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
                            options += '<option value="' + year + '">' + year + '</option>';
                        });
                        $('#year-dropdown').prop('disabled', false).html(options);
                    } else {
                        $('#year-dropdown').prop('disabled', true).html('<option value="">No years available</option>');
                    }
                },
                error: function() {
                    alert('Error loading model years. Please try again.');
                    $('#year-dropdown').prop('disabled', true).html('<option value="">Error loading years</option>');
                }
            });
        } else {
            // Reset year dropdown and seating capacity
            $('#year-dropdown').prop('disabled', true).html('<option value="">Select Year (Choose Model First)</option>');
            $('#seating-capacity').val('');
        }
    });

    // File upload functionality (keeping original)
    $(".browse-btn").on("click", function () {
      let target = $(this).data("target");
      $(target).trigger("click");
    });

    // Drag & Drop events
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

    // Preview handler (for images)
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

    // Bind previews
    $("#registrationDoc").on("change", function () { previewFile(this, "previewRegistration"); });
    $("#billDoc").on("change", function () { previewFile(this, "previewBill"); });
    $("#photoFront").on("change", function () { previewFile(this, "previewFront"); });
    $("#photoBack").on("change", function () { previewFile(this, "previewBack"); });
  });
</script>