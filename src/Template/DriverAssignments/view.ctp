<h3>Driver Assignment Details</h3>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?= h($assignment->id) ?></td>
    </tr>
    <tr>
        <th>Driver</th>
        <td><?= h($assignment->driver->name) ?></td>
    </tr>
    <tr>
        <th>Vehicle</th>
        <td><?= h($assignment->vehicle->id) ?></td>
    </tr>
    <tr>
        <th>Start Date</th>
        <td><?= h($assignment->start_date) ?></td>
    </tr>
    <tr>
        <th>End Date</th>
        <td><?= h($assignment->end_date) ?></td>
    </tr>
</table>

<?= $this->Html->link('Back', ['action'=>'index'], ['class'=>'btn btn-secondary']) ?>
