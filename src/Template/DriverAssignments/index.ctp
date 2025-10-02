<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Driver Assignments</h3>
       
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($assignments)): ?>
                    <?php foreach ($assignments as $a): ?>
                    <tr>
                        <td><?= h($a->id) ?></td>
                        <td><?= h($a->driver->name) ?></td>
                        <td><?= h($a->vehicle->vehicle_code) ?></td>
                        <td><?= h($a->start_date) ?></td>
                        <td><?= h($a->end_date ?: '-') ?></td>
                        <td class="text-center">
                            <?= $this->Html->link('View', ['action'=>'view', $a->id], ['class'=>'btn btn-info btn-sm me-1']) ?>
                            <?= $this->Html->link('Edit', ['action'=>'edit', $a->id], ['class'=>'btn btn-primary btn-sm me-1']) ?>
                            <?= $this->Form->postLink('Delete', ['action'=>'delete', $a->id], [
                                    'confirm'=>'Are you sure?',
                                    'class'=>'btn btn-danger btn-sm'
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No assignments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?= $this->Paginator->numbers(['class'=>'pagination']) ?>
    </div>
</div>

<style>
    /* Optional: make buttons a bit tighter */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        table thead {
            font-size: 0.85rem;
        }
        table tbody td {
            font-size: 0.8rem;
        }
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }
</style>
