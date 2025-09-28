<h3>Dashboard</h3>
<div class="row">
  <div class="col-md-3">
    <div class="card card-sm p-3">
      <h5>Total Vehicles</h5>
      <h2><?= $totalVehicles ?></h2>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-sm p-3">
      <h5>Active</h5>
      <h2><?= $activeVehicles ?></h2>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-sm p-3">
      <h5>Idle / Others</h5>
      <h2><?= $idleVehicles ?></h2>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-sm p-3">
      <h5>Drivers</h5>
      <h2><?= $totalDrivers ?></h2>
    </div>
  </div>
</div>

<div class="mt-4">
  <h5>Upcoming Alerts</h5>
  <p>Insurance expiry within 30 days: <strong><?= $insuranceDue ?></strong></p>
  <p><?= $this->Html->link('View Vehicles', ['controller'=>'Vehicles','action'=>'index'], ['class'=>'btn btn-primary']) ?></p>
</div>
