<div class="mt-5">
    <?= $this->Html->link(
        '<i class="fas fa-arrow-left me-1"></i> Back',
        ['action' => 'index'],
        ['class' => 'btn btn-outline-dark', 'escape' => false]
    ) ?>
</div>

<div class="card shadow-sm mb-4 mt-2">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Edit Driver</h5>
    </div>

    <div class="card-body shadow-lg">
        <?= $this->Form->create($driver, [
            'type' => 'file',
            'class' => 'row g-4 needs-validation',
            'novalidate' => true
        ]) ?>

        <!-- Driver Name -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('name', [
                'label' => 'Driver Name',
                'class' => 'form-control',
                'placeholder' => 'Enter full name',
                'required' => true
            ]) ?>
        </div>

        <!-- Father's Name -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('father_name', [
                'label' => 'Father\'s Name',
                'class' => 'form-control',
                'placeholder' => 'Enter father\'s name',
                'required' => true
            ]) ?>
        </div>

        <!-- Present Address -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('address', [
                'label' => 'Present Address',
                'type' => 'textarea',
                'rows' => 2,
                'class' => 'form-control',
                'placeholder' => 'Enter present address'
            ]) ?>
        </div>

        <!-- Contact Number -->
        <div class="col-md-6 mt-3">
            <label for="contact_number">Contact Number</label>
            <div class="input-group">
                <span class="input-group-text">+91</span>
                <?= $this->Form->text('contact_no', [
                    'id' => 'contact_number',
                    'class' => 'form-control',
                    'placeholder' => 'Enter 10-digit number',
                    'required' => true,
                    'maxlength' => 10,
                    'pattern' => '[0-9]{10}',
                    'title' => 'Enter valid 10-digit phone number'
                ]) ?>
            </div>
        </div>

        <!-- License Number -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('license_no', [
                'label' => 'License Number',
                'class' => 'form-control',
                'placeholder' => 'Enter license number',
                'required' => true
            ]) ?>
        </div>

        <!-- License Validity -->
        <div class="col-md-6 mt-3">
            <?= $this->Form->control('license_validity', [
                'label' => 'License Validity / Renewal Date',
                'type' => 'text',
                'class' => 'form-control datepicker',
                'placeholder' => 'Select date',
                'autocomplete' => 'off',
                'value' => !empty($driver->license_validity)
                    ? $driver->license_validity->format('Y-m-d')
                    : ''
            ]) ?>
        </div>
        <!-- Self Photo Upload with Preview -->

        <div class="col-md-6 mb-4 mt-4">
            <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3" >
                <h6 class="fw-bold mb-2"><i class="fas fa-car-rear me-2"></i>Upload Driver Photo</h6>
                <p class="text-muted small mb-2">Drag & drop image here or click below</p>

                <?= $this->Form->control('driver_photo', [
                    'type' => 'file',
                    'class' => 'd-none',
                    'label' => false,
                    'id' => 'driver-photo'
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#driver-photo">
                    Browse Image
                </button>

                <div id="preview_driver_photo" class="mt-3">
                    <?php if (!empty($driver->driver_photo)): ?>
                        <a href="<?= $this->Url->build("/img/{$driver->driver_photo}") ?>" target="_blank">
                            <img src="<?= $this->Url->build("/img/{$driver->driver_photo}") ?>"
                                class="img-thumbnail shadow-sm" style="max-height:120px;">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- License Document Upload -->

        <div class="col-md-6 mb-4 mt-4">
            <div class="card shadow-sm border-0 h-100 upload-zone text-center p-3">
                <h6 class="fw-bold mb-2"><i class="fas fa-car-rear me-2"></i>Upload Driving License</h6>
                <p class="text-muted small mb-2">Drag & drop document here or click below</p>

                <?= $this->Form->control('license_doc', [
                    'type' => 'file',
                    'class' => 'd-none',
                    'label' => false,
                    'id' => 'license_doc'
                ]) ?>
                <button type="button" class="btn btn-outline-primary btn-sm browse-btn" data-target="#license_doc">
                    Browse Document
                </button>

                <div id="preview_license_doc" class="mt-3">
                    <?php if (!empty($driver->license_doc)): ?>
                        <a href="<?= $this->Url->build("/img/{$driver->license_doc}") ?>" target="_blank"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-file-alt"></i> View Current Document
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Complaint Details -->
        <div class="col-md-12 mt-3">
            <?= $this->Form->control('complaint_details', [
                'label' => 'Complaint Details (if any)',
                'type' => 'textarea',
                'rows' => 3,
                'class' => 'form-control',
                'placeholder' => 'Provide details if complaints exist'
            ]) ?>
        </div>

        <!-- Leave / Availability Details -->
        <div class="col-md-12 mt-3">
            <?= $this->Form->control('leave_availability', [
                'label' => 'Leave / Availability Details',
                'type' => 'textarea',
                'rows' => 3,
                'class' => 'form-control',
                'placeholder' => 'E.g., On leave from 2025-10-01 to 2025-10-05'
            ]) ?>
        </div>

        <!-- Submit -->
        <div class="col-12 text-end mt-4">
            <?= $this->Form->button('<i class="fas fa-save"></i> Update Driver', [
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
        $("#license_doc").on("change", function () { previewFile(this, "preview_license_doc"); });
        $("#driver-photo").on("change", function () { previewFile(this, "preview_driver_photo"); });
    });
</script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>