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
          <i class="fas fa-info-circle me-2"></i> Vehicle Information
        </div>
        <div class="card-body p-3">
          <div class="table-responsive">
            <table class="table table-borderless table-striped align-middle mb-0">
              <tbody>
                <tr>
                  <th scope="row">Vehicle Code</th>
                  <td><?= h($vehicle->vehicle_code) ?></td>
                </tr>
                <tr>
                  <th scope="row">Registration No</th>
                  <td><?= h($vehicle->registration_no) ?></td>
                </tr>
                <tr>
                  <th scope="row">Type</th>
                  <td><?= h($vehicle->vehicle_type) ?></td>
                </tr>
                <tr>
                  <th scope="row">Fuel</th>
                  <td><?= h($vehicle->fuel_type) ?></td>
                </tr>
                <tr>
                  <th scope="row">Make/Model</th>
                  <td><?= h($vehicle->make_model) ?></td>
                </tr>
                <tr>
                  <th scope="row">Seating Capacity</th>
                  <td><?= h($vehicle->seating_capacity) ?></td>
                </tr>
                <tr>
                  <th scope="row">Status</th>
                  <td>
                    <?php if ($vehicle->status === 'Active'): ?>
                      <span class="badge bg-success text-white p-2 ">Active</span>
                    <?php else: ?>
                      <span class="badge bg-dark text-white p-2"><?=$vehicle->status?></span>
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
          <i class="fas fa-camera me-2"></i> Vehicle Photos
        </div>
        <div class="card-body text-center">
          <?php if ($vehicle->photo_front): ?>
            <img src="<?= $this->Url->build('/img/' . $vehicle->photo_front) ?>"
              class="img-fluid rounded shadow-sm border mb-3" alt="Front">
          <?php endif; ?>
          <?php if ($vehicle->photo_back): ?>
            <img src="<?= $this->Url->build('/img/' . $vehicle->photo_back) ?>" class="img-fluid rounded shadow-sm border"
              alt="Back">
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
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