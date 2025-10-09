<div class="container-fluid py-4 mt-5">
  <!-- Dashboard Header -->
 

  <!-- Top Summary Cards -->
  <div class="row g-4">
    <div class="col-md-3">
      <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>" class="text-decoration-none">
        <div class="card shadow-lg border-0 rounded-4 text-center p-3 hover-card ">
          <h6 class="text-uppercase text-muted">Total Vehicles</h6>
          <h2 class="fw-bold"><?= $totalVehicles ?></h2>
          <i class="fas fa-car fa-2x text-primary mt-2"></i>
        </div>
      </a>
    </div>
    <div class="col-md-3 ">
      <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>" class="text-decoration-none">
        <div class="card shadow-lg border-0 rounded-4 text-center p-3 hover-card">
          <h6 class="text-uppercase text-muted">Active Vehicles</h6>
          <h2 class="fw-bold text-success"><?= $activeVehicles ?></h2>
          <i class="fas fa-check-circle fa-2x text-success mt-2"></i>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>" class="text-decoration-none">
        <div class="card shadow-lg border-0 rounded-4 text-center p-3 hover-card">
          <h6 class="text-uppercase text-muted">Idle / Others</h6>
          <h2 class="fw-bold text-warning"><?= $idleVehicles ?></h2>
          <i class="fas fa-clock fa-2x text-warning mt-2"></i>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="<?= $this->Url->build(['controller' => 'Drivers', 'action' => 'index']) ?>" class="text-decoration-none">
        <div class="card shadow-lg border-0 rounded-4 text-center p-3 hover-card">
          <h6 class="text-uppercase text-muted">Drivers</h6>
          <h2 class="fw-bold text-info"><?= $totalDrivers ?></h2>
          <i class="fas fa-user-tie fa-2x text-info mt-2"></i>
        </div>
      </a>
    </div>
  </div>

 
 <div class="row mt-4">
    <div class="col-lg-12">
           <div class="card shadow-lg border-0 rounded-4 p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-tasks me-2"></i> Quick Actions</h6>
      <div class="d-flex justify-content-between gap-2">
        <?= $this->Html->link('<i class="fas fa-car-plus me-1"></i> Add Vehicle', ['controller' => 'Vehicles', 'action' => 'add'], ['class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-user-plus me-1"></i> Add Driver', ['controller' => 'Drivers', 'action' => 'add'], ['class' => 'btn btn-info btn-sm', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-file-invoice me-1"></i> Generate Reports', ['controller' => 'Reports', 'action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
      </div>
    </div>
    </div>
  </div>
  <!-- Charts Section -->
  <div class="row mt-4 g-4">
    <div class="col-lg-6">
      <div class="card shadow-lg border-0 rounded-4 p-3">
        <h6 class="fw-bold mb-3">Vehicle Status Distribution</h6>
        <canvas id="vehicleStatusChart" height="200"></canvas>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-lg border-0 rounded-4 p-3">
        <h6 class="fw-bold mb-3">Driver Distribution</h6>
        <canvas id="driverChart" height="200"></canvas>
      </div>
    </div>
  </div>

 <!-- Quick Alerts & Actions -->
<div class="row mt-4 g-4">
  <div class="col-lg-12">
    <div class="card shadow-lg border-0 rounded-4 p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-bell me-2"></i> Upcoming Alerts</h6>
      <ul class="list-group list-group-flush">

        <!-- Overdue Maintenance Warning -->
        <?php if (!empty($overdueServices) && $overdueServices > 0): ?>
          <li class="list-group-item bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
            <div>
              <i class="fas fa-exclamation-triangle me-2"></i>
              <?= h($overdueServices) ?> vehicle(s) have overdue maintenance!
            </div>
            <a href="<?= $this->Url->build(['controller' => 'Maintenance', 'action' => 'index']) ?>"
               class="btn btn-sm btn-light text-danger fw-bold">
               View
            </a>
          </li>
        <?php endif; ?>

        <!-- Insurance Alert -->
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="fas fa-file-shield text-primary me-2"></i>
            Insurance expiry within 30 days
          </div>
          <div>
            <span class="badge bg-warning text-dark me-2"><?= h($insuranceDue) ?></span>
            <a href="<?= $this->Url->build(['controller' => 'Insurance', 'action' => 'index']) ?>" class="btn btn-sm btn-outline-primary">
              View
            </a>
          </div>
        </li>

        <!-- Registration Alert -->
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="fas fa-id-card text-success me-2"></i>
            Vehicle registration renewal within 30 days
          </div>
          <div>
            <span class="badge bg-warning text-dark me-2"><?= h($registrationDue) ?></span>
            <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>" class="btn btn-sm btn-outline-primary">
              View
            </a>
          </div>
        </li>

        <!-- Pending Driver Approvals -->
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="fas fa-user-clock text-secondary me-2"></i>
            Pending driver approvals
          </div>
          <div>
            <span class="badge bg-info text-dark me-2"><?= h($pendingDriverApprovals) ?></span>
            <a href="<?= $this->Url->build(['controller' => 'Drivers', 'action' => 'index']) ?>" class="btn btn-sm btn-outline-primary">
              View
            </a>
          </div>
        </li>

        <!-- Service & Maintenance Alert -->
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="fas fa-tools text-danger me-2"></i>
            Service & Maintenance due within 30 days
          </div>
          <div>
            <span class="badge bg-danger me-2"><?= h($serviceDue) ?></span>
            <a href="<?= $this->Url->build(['controller' => 'Maintenance', 'action' => 'index']) ?>" class="btn btn-sm btn-outline-primary">
              View
            </a>
          </div>
        </li>

      </ul>
    </div>
  </div>
</div>




  <!-- Recent Activity Table -->
<!-- Recent Activity Table -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card shadow-lg border-0 rounded-4 p-3">
      <h6 class="fw-bold mb-3"><i class="fas fa-history me-2"></i> Recent Vehicle Activity</h6>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Vehicle Code</th>
              <th>Vehicle Type</th>
              <th>Fuel Type</th>
              <th>Status</th>
              <th>Last Update</th>
              <th>Driver</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentVehicles as $v): ?>
              <tr>
                <td><?= h($v->vehicle_code) ?></td>
                <td><?= h($v->vehicle_type) ?></td>
                <td><?= h($v->fuel_type) ?></td>
                <td>
                  <?php
                    $statusClass = 'bg-info'; // default
                    switch ($v->status) {
                        case 'Active': $statusClass = 'bg-success'; break;
                        case 'Idle': $statusClass = 'bg-secondary'; break;
                        case 'Condemned': $statusClass = 'bg-danger'; break;
                        case 'On Duty': $statusClass = 'bg-primary'; break;
                        case 'Leave': $statusClass = 'bg-warning'; break;
                    }
                  ?>
                  <span class="badge <?= $statusClass ?>"><?= h($v->status) ?></span>
                </td>
                <td><?= h(date('d-m-Y H:i', strtotime($v->modified))) ?></td>
                <td>
                  <?= h(!empty($v->driver_assignments) && $v->driver_assignments[0]->driver
                        ? $v->driver_assignments[0]->driver->name
                        : '-') ?>
                </td>
                <td>
                  <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'view', $v->vehicle_code]) ?>" class="btn btn-sm btn-outline-primary me-1">
                    View
                  </a>
                  <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'edit', $v->vehicle_code]) ?>" class="btn btn-sm btn-outline-secondary">
                    Edit
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const vehicleCtx = document.getElementById('vehicleStatusChart').getContext('2d');
  new Chart(vehicleCtx, {
    type: 'doughnut',
    data: {
      labels: ['Active', 'Idle / Others'],
      datasets: [{
        data: [<?= $activeVehicles ?>, <?= $idleVehicles ?>],
        backgroundColor: ['#28a745', '#ffc107'],
        borderWidth: 1
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });

  const driverCtx = document.getElementById('driverChart').getContext('2d');
  new Chart(driverCtx, {
    type: 'bar',
    data: {
      labels: ['Drivers'],
      datasets: [{
        label: 'Total Drivers',
        data: [<?= $totalDrivers ?>],
        backgroundColor: ['#17a2b8']
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });
</script>

<style>
  .bg-gradient-light {
    background: linear-gradient(145deg, #f8f9fa, #e9ecef);
  }

  .hover-card:hover {
    transform: translateY(-4px);
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
  }

  h3 {
    font-weight: 600;
  }

  h6 {
    font-size: 0.85rem;
    letter-spacing: 0.5px;
  }
</style>