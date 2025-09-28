<div class="d-flex justify-content-between mb-3">
  <h3>Vehicles</h3>
  <?= $this->Html->link('New Vehicle', ['action'=>'add'], ['class'=>'btn btn-primary']) ?>
</div>

<table class="table table-bordered table-striped table-responsive-sm">
  <thead>
    <tr>
      <th>#</th>
      <th>Code</th>
      <th>Reg No</th>
      <th>Type</th>
      <th>Fuel</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($vehicles as $v): ?>
      <tr>
        <td><?= $v->id ?></td>
        <td><?= h($v->vehicle_code) ?></td>
        <td><?= h($v->registration_no) ?></td>
        <td><?= h($v->vehicle_type) ?></td>
        <td><?= h($v->fuel_type) ?></td>
        <td><?= h($v->status) ?></td>
        <td>
          <?= $this->Html->link('View', ['action'=>'view', $v->id], ['class'=>'btn btn-sm btn-info']) ?>
          <?= $this->Html->link('Edit', ['action'=>'edit', $v->id], ['class'=>'btn btn-sm btn-warning']) ?>
          <?= $this->Form->postLink('Delete', ['action'=>'delete', $v->id], ['confirm'=>'Are you sure?', 'class'=>'btn btn-sm btn-danger']) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="mt-3">
  <?= $this->element('pagination'); ?>
</div>
