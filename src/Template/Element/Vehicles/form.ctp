<?php
// Updated Vehicle Form with Master Tables Integration
?>

<!-- <div class="mt-5">
</div> -->


<!-- <style>
  .upload-zone {
    border: 2px dashed #ccc;
    border-radius: 10px;
    transition: all 0.3s;
  }

  .upload-zone.dragover {
    border-color: #007bff;
    background: #f0f8ff;
  }
</style> -->

<!-- UPDATED JAVASCRIPT FOR DEPENDENT DROPDOWNS -->
<!-- <script>
  flatpickr(".datepicker", {
    dateFormat: "d-m-Y",
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
</script> -->


<!-- new changes for existed vehicle  -->
 
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

    <!-- VEHICLE CONDITION SELECTION -->
<div class="form-row mb-4">
  <div class="col-12">
    <div class="card border-primary">
      <div class="card-header bg-primary text-white">
        <h6 class="mb-0">Vehicle Condition</h6>
      </div>
      <div class="card-body">
        
        <div class="form-check form-check-inline">
          <input class="form-check-input" 
                 type="radio" 
                 name="vehicle_condition" 
                 id="vehicle_condition_new" 
                 value="newly_purchased"
                 <?= (!isset($vehicle->vehicle_condition) || $vehicle->vehicle_condition === 'newly_purchased') ? 'checked' : '' ?>>
          <label class="form-check-label" for="vehicle_condition_new">
            Newly Purchased Vehicle
          </label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" 
                 type="radio" 
                 name="vehicle_condition" 
                 id="vehicle_condition_used" 
                 value="already_existed"
                 <?= (isset($vehicle->vehicle_condition) && $vehicle->vehicle_condition === 'already_existed') ? 'checked' : '' ?>>
          <label class="form-check-label" for="vehicle_condition_used">
            Already Existed Vehicle
          </label>
        </div>

      </div>
    </div>
  </div>
</div>

    <!-- BASIC VEHICLE INFORMATION -->
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
      
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('vehicle_type_id', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Vehicle Type',
          'options' => $vehicleTypes,
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

      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('manufacturer_id', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Manufacturer',
          'options' => $manufacturers,
          'empty' => 'Select Manufacturer',
          'required' => true,
          'id' => 'manufacturer-dropdown',
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <!-- Dependent dropdowns for Model and Year -->
    <div class="form-row mb-3">
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('model_id', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Vehicle Model',
          'options' => [],
          'empty' => 'Select Model (Choose Manufacturer First)',
          'required' => true,
          'id' => 'model-dropdown',
          'disabled' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>

      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('model_year', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Model Year',
          'options' => [],
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
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('seating_capacity', [
          'class' => 'form-control',
          'label' => 'Seating Capacity',
          'type' => 'number',
          'min' => 1,
          'placeholder' => 'Auto-filled from model selection',
          'readonly' => true,
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
        <small class="text-muted">Auto-filled when you select a vehicle model.</small>
      </div>

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

    <!-- PURCHASE INFORMATION (Common for both) -->
    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('purchase_date', [
          'class' => 'form-control datepicker',
          'label' => 'Purchase Date',
          'type' => 'text',
          'placeholder' => 'DD-MM-YYYY',
          'autocomplete' => 'off',
          'required' => true,
          'value' => !empty($vehicle->insurance_expiry_date) 
    ? (new \DateTime($vehicle->insurance_expiry_date))->format('d-m-Y') 
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

    <!-- INSURANCE INFORMATION (Common for both) -->
    <div class="form-row mb-3">
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('insurance_policy_no', [
          'class' => 'form-control',
          'label' => 'Insurance Policy Number',
          'placeholder' => 'Enter insurance policy number',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('insurance_expiry_date', [
          'class' => 'form-control datepicker',
          'label' => 'Insurance Expiry Date',
          'type' => 'text',
          'placeholder' => 'DD-MM-YYYY',
          'autocomplete' => 'off',
          'required' => true,
        'value' => !empty($vehicle->insurance_expiry_date) 
    ? (new \DateTime($vehicle->insurance_expiry_date))->format('d-m-Y') 
    : '',
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
    </div>

    <!-- ALREADY EXISTED VEHICLE SPECIFIC FIELDS -->
    <div id="already-existed-fields" style="display: none;">
      <div class="card border-warning mb-4">
        <div class="card-header bg-warning text-dark">
          <h6 class="mb-0">Additional Information (Already Existed Vehicle)</h6>
        </div>
        <div class="card-body">
          <div class="form-row mb-3">
            <div class="form-group col-sm-6 col-md-6">
              <?= $this->Form->control('odometer_reading', [
                'class' => 'form-control',
                'label' => 'Odometer Reading (KMs)',
                'type' => 'number',
                'min' => 0,
                'placeholder' => 'Enter current odometer reading',
                'templates' => [
                  'error' => '<div class="form-error">{{content}}</div>'
                ]
              ]) ?>
            </div>
            <div class="form-group col-sm-6 col-md-6">
              <?= $this->Form->control('last_service_date', [
                'class' => 'form-control datepicker',
                'label' => 'Last Service Date',
                'type' => 'text',
                'placeholder' => 'DD-MM-YYYY',
                'autocomplete' => 'off',
                'value' => !empty($vehicle->insurance_expiry_date) 
    ? (new \DateTime($vehicle->insurance_expiry_date))->format('d-m-Y') 
    : '',
                'templates' => [
                  'error' => '<div class="form-error">{{content}}</div>'
                ]
              ]) ?>
            </div>
          </div>

          <div class="form-row mb-3">
            <div class="form-group col-sm-12 col-md-6">
              <?= $this->Form->control('keys_available', [
                'type' => 'select',
                'class' => 'form-control',
                'label' => 'Keys Available',
                'options' => [
                  '1_key' => '1 Key',
                  '2_keys' => '2 Keys'
                ],
                'empty' => 'Select Keys Available',
                'templates' => [
                  'error' => '<div class="form-error">{{content}}</div>'
                ]
              ]) ?>
            </div>
          </div>

          <!-- CURRENT CONDITION PHOTOS (4 sides) -->
          <h6 class="mb-3">Current Condition Photos (4 Sides)</h6>
          <div class="row">
            <!-- Front Left Photo -->
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneFrontLeft">
                <h6 class="fw-bold mb-2"><i class="fas fa-camera me-2"></i>Front Left</h6>
                <p class="text-muted small mb-2">Current condition photo</p>

                <?= $this->Form->control('condition_photo_front_left', [
                  'type' => 'file',
                  'class' => 'd-none',
                  'label' => false,
                  'id' => 'conditionPhotoFrontLeft',
                  'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                  ]
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#conditionPhotoFrontLeft">
                  Browse Image
                </button>

                <div id="previewFrontLeft" class="mt-3">
                  <?php if (!empty($vehicle->condition_photo_front_left)): ?>
                    <img src="<?= $this->Url->build("/img/{$vehicle->condition_photo_front_left}") ?>" class="img-thumbnail shadow-sm" style="max-height:120px;">
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Front Right Photo -->
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneFrontRight">
                <h6 class="fw-bold mb-2"><i class="fas fa-camera me-2"></i>Front Right</h6>
                <p class="text-muted small mb-2">Current condition photo</p>

                <?= $this->Form->control('condition_photo_front_right', [
                  'type' => 'file',
                  'class' => 'd-none',
                  'label' => false,
                  'id' => 'conditionPhotoFrontRight',
                  'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                  ]
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#conditionPhotoFrontRight">
                  Browse Image
                </button>

                <div id="previewFrontRight" class="mt-3">
                  <?php if (!empty($vehicle->condition_photo_front_right)): ?>
                    <img src="<?= $this->Url->build("/img/{$vehicle->condition_photo_front_right}") ?>" class="img-thumbnail shadow-sm" style="max-height:120px;">
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Back Left Photo -->
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneBackLeft">
                <h6 class="fw-bold mb-2"><i class="fas fa-camera me-2"></i>Back Left</h6>
                <p class="text-muted small mb-2">Current condition photo</p>

                <?= $this->Form->control('condition_photo_back_left', [
                  'type' => 'file',
                  'class' => 'd-none',
                  'label' => false,
                  'id' => 'conditionPhotoBackLeft',
                  'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                  ]
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#conditionPhotoBackLeft">
                  Browse Image
                </button>

                <div id="previewBackLeft" class="mt-3">
                  <?php if (!empty($vehicle->condition_photo_back_left)): ?>
                    <img src="<?= $this->Url->build("/img/{$vehicle->condition_photo_back_left}") ?>" class="img-thumbnail shadow-sm" style="max-height:120px;">
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Back Right Photo -->
            <div class="col-md-6 mb-4">
              <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" id="zoneBackRight">
                <h6 class="fw-bold mb-2"><i class="fas fa-camera me-2"></i>Back Right</h6>
                <p class="text-muted small mb-2">Current condition photo</p>

                <?= $this->Form->control('condition_photo_back_right', [
                  'type' => 'file',
                  'class' => 'd-none',
                  'label' => false,
                  'id' => 'conditionPhotoBackRight',
                  'templates' => [
                    'error' => '<div class="form-error">{{content}}</div>'
                  ]
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#conditionPhotoBackRight">
                  Browse Image
                </button>

                <div id="previewBackRight" class="mt-3">
                  <?php if (!empty($vehicle->condition_photo_back_right)): ?>
                    <img src="<?= $this->Url->build("/img/{$vehicle->condition_photo_back_right}") ?>" class="img-thumbnail shadow-sm" style="max-height:120px;">
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ORIGINAL DOCUMENT PHOTOS (Common for both) -->
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
              <a href="<?= $this->Url->build("/img/{$vehicle->registration_doc}") ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
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
              <a href="<?= $this->Url->build("/img/{$vehicle->bill_doc}") ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
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
                <img src="<?= $this->Url->build("/img/{$vehicle->photo_front}") ?>" class="img-thumbnail shadow-sm" style="max-height:120px;">
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
                <img src="<?= $this->Url->build("/img/{$vehicle->photo_back}") ?>" class="img-thumbnail shadow-sm" style="max-height:120px;">
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

  .form-check-inline {
    margin-right: 2rem;
  }
</style>

<script>
  flatpickr(".datepicker", {
    dateFormat: "d-m-Y",
    allowInput: true
  });

  $(document).ready(function () {
    var csrfToken = $('[name="_csrfToken"]').val();
    
    // Vehicle condition toggle
    function toggleConditionalFields() {
      const selectedCondition = $('input[name="vehicle_condition"]:checked').val();
      const alreadyExistedFields = $('#already-existed-fields');
      
      if (selectedCondition === 'already_existed') {
        alreadyExistedFields.slideDown();
        // Make already existed fields required
        alreadyExistedFields.find('input, select').each(function() {
          if ($(this).attr('name')) {
            $(this).prop('required', true);
          }
        });
      } else {
        alreadyExistedFields.slideUp();
        // Remove required from already existed fields
        alreadyExistedFields.find('input, select').each(function() {
          $(this).prop('required', false);
        });
      }
    }

    // Initialize on page load
    toggleConditionalFields();

    // Handle radio button change
    $('input[name="vehicle_condition"]').change(function() {
      toggleConditionalFields();
    });

    // Manufacturer dropdown change event
    $('#manufacturer-dropdown').on('change', function() {
        var manufacturerId = $(this).val();
        
        if (manufacturerId) {
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
                            options += '<option value="' + model.id + '" data-seats="' + model.seating_capacity + '">' + model.model_name + '</option>';
                        });
                        $('#model-dropdown').prop('disabled', false).html(options);
                    } else {
                        $('#model-dropdown').prop('disabled', true).html('<option value="">No models found</option>');
                    }
                },
                error: function() {
                    alert('Error loading models. Please try again.');
                }
            });
        } else {
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
            var seatingCapacity = selectedOption.data('seats');
            $('#seating-capacity').val(seatingCapacity);
            
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
                }
            });
        } else {
            $('#year-dropdown').prop('disabled', true).html('<option value="">Select Year (Choose Model First)</option>');
            $('#seating-capacity').val('');
        }
    });

    // File upload functionality
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

    // Preview handler for images
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

    // Bind previews for all upload fields
    $("#registrationDoc").on("change", function () { previewFile(this, "previewRegistration"); });
    $("#billDoc").on("change", function () { previewFile(this, "previewBill"); });
    $("#photoFront").on("change", function () { previewFile(this, "previewFront"); });
    $("#photoBack").on("change", function () { previewFile(this, "previewBack"); });
    $("#conditionPhotoFrontLeft").on("change", function () { previewFile(this, "previewFrontLeft"); });
    $("#conditionPhotoFrontRight").on("change", function () { previewFile(this, "previewFrontRight"); });
    $("#conditionPhotoBackLeft").on("change", function () { previewFile(this, "previewBackLeft"); });
    $("#conditionPhotoBackRight").on("change", function () { previewFile(this, "previewBackRight"); });
  });
</script>
