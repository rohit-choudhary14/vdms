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
    <div class="col-lg-6">
      <div class="card shadow-lg border-0 rounded-4 p-3">
        <h6 class="fw-bold mb-3"><i class="fas fa-bell me-2"></i> Upcoming Alerts</h6>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Insurance expiry within 30 days: <strong><?= $insuranceDue ?></strong></li>
          <li class="list-group-item">Vehicle registration renewal: <strong>3 vehicles</strong></li>
          <li class="list-group-item">Pending driver approvals: <strong>2 drivers</strong></li>
        </ul>
      </div>
    </div>

  </div>

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
                <th>Status</th>
                <th>Last Update</th>
                <th>Driver</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentVehicles as $v): ?>
                <tr>
                  <td><?= h($v->vehicle_code) ?></td>
                  <td>
                    <?php if ($v->status == 'Active'): ?>
                      <span class="badge bg-success"><?= h($v->status) ?></span>
                    <?php else: ?>
                      <span class="badge bg-warning"><?= h($v->status) ?></span>
                    <?php endif; ?>
                  </td>
                  <td><?= h($v->modified) ?></td>
                  <td><?= h($v->driver_name) ?></td>
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