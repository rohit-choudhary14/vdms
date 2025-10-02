<div class="container-fluid py-4 mt-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h2 class="fw-bold text-dark"><i class="fas fa-car-side me-2"></i> Vehicle Details</h2> -->
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-1"></i> Back',
            ['action' => 'index'],
            ['class' => 'btn btn-outline-dark', 'escape' => false]
        ) ?>
    </div>

    <div class="row g-4">
        <!-- Vehicle Info Card -->
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-dark text-white fw-bold rounded-top-4">
                    <h3>Driver: <?= h($driver->name) ?></h3>
                    <!-- <i class="fas fa-info-circle me-2"></i> Driver Information -->
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped align-middle mb-0">
                            <tbody>
                                 <tr>
                                    <th>Driver ID</th>
                                    <td><?= h($driver->driver_code) ?></td>
                                </tr>
                                <tr>
                                    <th>Father Name</th>
                                    <td><?= h($driver->father_name) ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?= h($driver->address) ?></td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td><?= h($driver->contact_no) ?></td>
                                </tr>
                                <tr>
                                    <th>License No</th>
                                    <td><?= h($driver->license_no) ?></td>
                                </tr>
                                <tr>
                                    <th>License Validity</th>
                                    <td><?= h($driver->license_validity) ?></td>
                                </tr>
                                <tr>
                                    <th>Joining Date</th>
                                    <td><?= h($driver->joining_date) ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?= h($driver->status) ?></td>
                                </tr>

                                <tr>
                                    <th>License</th>
                                    <td>
                                        <?php if (!empty($driver->license_doc)): ?>
                                            <a href="<?= $this->Url->build("/img/{$driver->license_doc}") ?>"
                                                target="_blank" class="d-block mt-2">
                                                <i class="fas fa-file-alt"></i> View current document
                                            </a>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Photos Card -->
        <div class="col-lg-4">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-dark text-white fw-bold rounded-top-4 text-center">
                    <i class="fas fa-camera me-2"></i> Driver Photo
                </div>
                <div class="card-body text-center">
                    <?php if ($driver->driver_photo): ?>
                        <img src="<?= $this->Url->build("/img/{$driver->driver_photo}") ?>"
                            class="img-fluid rounded shadow-sm border mb-3" alt="Front">
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <?php if ($vehicle): ?>
        <div class="row g-4 mt-5">
            <!-- Vehicle Info Card -->
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-dark text-white fw-bold rounded-top-4">
                        <h4 class="mt-4">Currently Assigned Vehicle</h4>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th>Vehicle Code</th>
                                        <td><?= h($vehicle->vehicle_code) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Registration No</th>
                                        <td><?= h($vehicle->registration_no) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td><?= h($vehicle->vehicle_type) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Fuel</th>
                                        <td><?= h($vehicle->fuel_type) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Make/Model</th>
                                        <td><?= h($vehicle->make_model) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Seating</th>
                                        <td><?= h($vehicle->seating_capacity) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><?= h($vehicle->status) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Photos Card -->
            <div class="col-lg-4">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-dark text-white fw-bold rounded-top-4 text-center">
                        <i class="fas fa-camera me-2"></i> Vehicle Photos
                    </div>
                    <div class="card-body text-center">
                        <?php if ($vehicle->photo_front): ?>
                            <img src="<?= $this->Url->build('/img/' . $vehicle->photo_front) ?>" class="img-fluid mb-2"
                                alt="Front">
                        <?php endif; ?>
                        <?php if ($vehicle->photo_back): ?>
                            <img src="<?= $this->Url->build('/img/' . $vehicle->photo_back) ?>" class="img-fluid" alt="Back">
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="mt-4">No vehicle currently assigned to this driver.</p>
    <?php endif; ?>
</div>

<!-- Custom CSS for Admin-style Professional Look -->
<style>
    body {
        background-color: #f8f9fa;
    }

    h2 {
        font-size: 1.8rem;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .table th {
        width: 40%;
        color: #495057;
        font-weight: 600;
    }

    .table td {
        color: #343a40;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .card-header {
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
</style>