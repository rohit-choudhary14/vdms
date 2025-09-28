<h3>Vehicle: <?= h($vehicle->vehicle_code) ?></h3>
<div class="row">
  <div class="col-md-8">
    <table class="table">
      <tr><th>Registration No</th><td><?= h($vehicle->registration_no) ?></td></tr>
      <tr><th>Type</th><td><?= h($vehicle->vehicle_type) ?></td></tr>
      <tr><th>Fuel</th><td><?= h($vehicle->fuel_type) ?></td></tr>
      <tr><th>Make/Model</th><td><?= h($vehicle->make_model) ?></td></tr>
      <tr><th>Seating</th><td><?= h($vehicle->seating_capacity) ?></td></tr>
      <tr><th>Status</th><td><?= h($vehicle->status) ?></td></tr>
    </table>
  </div>
  <div class="col-md-4">
    <?php if ($vehicle->photo_front): ?>
      <img src="<?= $this->Url->build('/img/' . $vehicle->photo_front) ?>" class="img-fluid mb-2" alt="Front">
    <?php endif; ?>
    <?php if ($vehicle->photo_back): ?>
      <img src="<?= $this->Url->build('/img/' . $vehicle->photo_back) ?>" class="img-fluid" alt="Back">
    <?php endif; ?>
  </div>
</div>

<?= $this->Html->link('Back', ['action'=>'index'], ['class'=>'btn btn-secondary']) ?>
