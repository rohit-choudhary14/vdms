<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InsuranceCompany[]|\Cake\Collection\CollectionInterface $insuranceCompanies
 */
?>

<div class="container-fluid py-5">
    <div class="card shadow-lg rounded-4 border-0">

        <!-- Header -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-2 mb-md-0 fw-bold">
                <i class="fas fa-building-shield me-2"></i>Insurance Companies
            </h4>
            <div>
                <?= $this->Html->link(
                    '<i class="fas fa-plus"></i> Add Company',
                    ['action' => 'add'],
                    ['class' => 'btn btn-light btn-sm shadow-sm px-3', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Search & Controls -->
        <div class="card-body border-bottom py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <label class="small mb-0">Show
                    <select id="rowsPerPage" class="form-select form-select-sm d-inline-block w-auto ms-1">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    entries
                </label>
            </div>
            <input type="text" id="searchInput" class="form-control form-control-sm w-50" placeholder="Search company...">
        </div>

        <!-- Table View -->
        <div class="table-responsive p-3">
            <table id="companyTable" class="table align-middle mb-0 table-striped table-hover rounded-3 shadow-sm">
                <thead class="bg-gradient-light text-uppercase text-muted small text-center">
                    <tr>
                        <th><?= $this->Paginator->sort('id', '#') ?></th>
                        <th><?= $this->Paginator->sort('name', 'Company Name') ?></th>
                        <th><?= $this->Paginator->sort('contact_number', 'Phone') ?></th>
                        <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                        <th><?= $this->Paginator->sort('website', 'Website') ?></th>
                        <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    <?php foreach ($insuranceCompanies as $company): ?>
                        <tr>
                            <td class="fw-semibold"><?= $this->Number->format($company->id) ?></td>
                            <td><?= h($company->name) ?></td>
                            <td><?= h($company->contact_number) ?></td>
                            <td><?= h($company->email) ?></td>
                            <td><?= h($company->website) ?></td>
                            <td>
                                <span class="badge rounded-pill px-3 py-1 <?= $company->status == 'Active' ? 'bg-success' : 'bg-secondary' ?> text-white">
                                    <?= h($company->status) ?>
                                </span>
                            </td>
                            <td><?= $company->created->format('d-m-Y') ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $company->id], ['class' => 'btn btn-light border text-primary shadow-sm', 'escape' => false, 'title' => 'View']) ?>
                                    <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $company->id], ['class' => 'btn btn-light border text-warning shadow-sm', 'escape' => false, 'title' => 'Edit']) ?>
                                    <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $company->id], ['confirm' => 'Are you sure?', 'class' => 'btn btn-light border text-danger shadow-sm', 'escape' => false, 'title' => 'Delete']) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                <?= $this->Paginator->counter(['format' => 'Showing {{start}} to {{end}} of {{count}} records']) ?>
            </div>
            <ul class="pagination pagination-sm mb-0">
                <?= $this->Paginator->first('<< First') ?>
                <?= $this->Paginator->prev('< Prev') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Next >') ?>
                <?= $this->Paginator->last('Last >>') ?>
            </ul>
        </div>

    </div>
</div>

<!-- Table Enhancements JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const rowsPerPage = document.getElementById('rowsPerPage');
        const table = document.getElementById('companyTable');
        const tbody = table.querySelector('tbody');

        let rows = Array.from(tbody.querySelectorAll('tr'));
        let currentPage = 1;
        let perPage = parseInt(rowsPerPage.value);

        function updateTable() {
            const search = searchInput.value.toLowerCase();
            const filtered = rows.filter(r =>
                Array.from(r.cells).some(c => c.textContent.toLowerCase().includes(search))
            );

            const totalPages = Math.ceil(filtered.length / perPage);
            if (currentPage > totalPages) currentPage = 1;

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;

            rows.forEach(r => r.style.display = 'none');
            filtered.slice(start, end).forEach(r => r.style.display = '');
        }

        searchInput.addEventListener('input', () => updateTable());
        rowsPerPage.addEventListener('change', () => {
            perPage = parseInt(rowsPerPage.value);
            updateTable();
        });

        updateTable();
    });
</script>

<style>
    table thead th a {
        text-decoration: none !important;
        color: #000 !important;
        font-weight: 600;
    }
    table thead th a:hover {
        color: #007bff !important;
    }
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
        white-space: nowrap !important;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, .03);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, .07) !important;
        transition: 0.3s;
    }
</style>