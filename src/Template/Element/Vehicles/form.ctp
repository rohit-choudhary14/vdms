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
      <!-- <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('vehicle_code', [
          'class' => 'form-control',
          'label' => 'Vehicle Code',
          'placeholder' => 'Enter vehicle code',
          'required' => true
        ]) ?>
      </div> -->
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('registration_no', [
          'class' => 'form-control',
          'label' => 'Registration No',
          'placeholder' => 'Enter registration number',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
      <div class="form-group col-sm-12 col-md-6">
        <?= $this->Form->control('vehicle_type', [
          'class' => 'form-control',
          'label' => 'Vehicle Type',
          'placeholder' => 'Enter vehicle type (Car, Bus, Jeep, etc.)',
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
          'empty' => 'Select Fuel Type', // optional placeholder
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>

      </div>
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('make_model', [
          'class' => 'form-control',
          'label' => 'Manufacturer & Model',
          'placeholder' => 'Enter manufacturer and model',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('seating_capacity', [
          'class' => 'form-control',
          'label' => 'Seating Capacity',
          'type' => 'number',
          'min' => 1,
          'placeholder' => 'Enter seating capacity',
          'required' => true,
          'templates' => [
            'error' => '<div class="form-error">{{content}}</div>'
          ]
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('status', [
          'type' => 'select',
          'class' => 'form-control',
          'label' => 'Status',
          'options' => [
            'Active' => 'Active',
            'In-Service' => 'In-Service',
            'Condemned' => 'Condemned',
            'Unused' => 'Unused'
          ],
          'empty' => 'Select status', // optional placeholder
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

    <!-- <div class="form-row mb-4">
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('registration_doc', [
          'type' => 'file',
          'class' => 'form-control-file',
          'label' => 'Registration Document'
          // placeholders are not typical on file inputs
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('bill_doc', [
          'type' => 'file',
          'class' => 'form-control-file',
          'label' => 'Bill Document'
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('photo_front', [
          'type' => 'file',
          'class' => 'form-control-file',
          'label' => 'Photo Front'
        ]) ?>
      </div>
      <div class="form-group col-sm-6 col-md-6">
        <?= $this->Form->control('photo_back', [
          'type' => 'file',
          'class' => 'form-control-file',
          'label' => 'Photo Back'
        ]) ?>
      </div>
    </div> -->
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

<script>
  flatpickr(".datepicker", {
    dateFormat: "Y-m-d",
    allowInput: true
  });
</script>

<script>
  $(document).ready(function () {
    // Open file input when Browse button is clicked
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