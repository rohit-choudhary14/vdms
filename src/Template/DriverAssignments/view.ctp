<div class="container-fluid py-4 mt-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-1"></i> Back',
            ['action' => 'index'],
            ['class' => 'btn btn-outline-dark', 'escape' => false]
        ) ?>
    </div>

    <!-- Assignment Details Card -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-dark text-white fw-bold rounded-top-4">
            <h4>Driver Assignment Details</h4>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <tbody>
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
                            <td><?= h($assignment->vehicle->vehicle_code) ?></td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td><?= h($assignment->start_date) ?></td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td><?= h($assignment->end_date) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional CSS for Clean Look -->
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .table th {
        width: 35%;
        font-weight: 600;
    }
</style>
