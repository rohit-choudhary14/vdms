<div class="container-fluid py-5">
  <div class="card shadow-lg rounded-4 border-0">

    <!-- Header -->
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
      <h4 class="mb-2 mb-md-0 fw-bold"><i class="fas fa-link me-2"></i> Driver Assignments</h4>
      <div class="d-flex justify-content-end">
        <?= $this->Html->link(
          '<i class="fas fa-plus"></i> New Assignment',
          ['action' => 'add'],
          ['class' => 'btn btn-light btn-sm shadow-sm px-3', 'escape' => false]
        ) ?>
      </div>
    </div>

    <!-- Controls -->
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
      <input type="text" id="searchInput" class="form-control form-control-sm w-50" placeholder="Search assignments...">
    </div>

    <!-- Table -->
    <div class="table-responsive p-3">
      <table id="assignmentsTable" class="table align-middle mb-0 table-striped table-hover rounded-3 shadow-sm">
        <thead class="bg-gradient-light text-uppercase text-muted small">
          <tr class="text-center">
            <th>#</th>
            <th>Driver</th>
            <th>Vehicle</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($assignments)): ?>
            <?php foreach ($assignments as $a): ?>
              <tr class="text-center align-middle">
                <td class="fw-semibold"><?= h($a->id) ?></td>
                <td><?= h($a->driver->name) ?></td>
                <td><?= h($a->vehicle->vehicle_code) ?></td>
                <td><?= h(date('d-m-Y', strtotime($a->start_date))) ?></td>
                <td><?= h($a->end_date ? date('d-m-Y', strtotime($a->end_date)) : '-') ?></td>
                <td>
                  <?php if (empty($a->end_date)): ?>
                    <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                  <?php else: ?>
                    <span class="badge bg-secondary rounded-pill px-3 py-2">Completed</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $a->id], [
                          'class' => 'btn btn-light border shadow-sm',
                          'escape' => false,
                          'title' => 'View',
                          'data-bs-toggle' => 'tooltip'
                      ]) ?>
                    <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $a->id], [
                          'class' => 'btn btn-light border text-warning shadow-sm',
                          'escape' => false,
                          'title' => 'Edit',
                          'data-bs-toggle' => 'tooltip'
                      ]) ?>
                    <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $a->id], [
                          'confirm' => 'Are you sure?',
                          'class' => 'btn btn-light border text-danger shadow-sm',
                          'escape' => false,
                          'title' => 'Delete',
                          'data-bs-toggle' => 'tooltip'
                      ]) ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-4">No assignments found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Footer / Pagination -->
    <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div class="small text-muted" id="entriesInfo">
        Showing 1 to 10 of <?= count($assignments) ?> assignments
      </div>
      <div class="d-flex gap-2">
        <button id="prevBtn" class="btn btn-primary btn-sm rounded-pill">Previous</button>
        <button id="nextBtn" class="btn btn-primary btn-sm rounded-pill">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- CSS & JS -->
<style>
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, .03);
  }

  .table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.1);
    transition: background-color 0.3s;
  }

  .badge {
    font-weight: 500;
    font-size: 0.85rem;
  }

  thead {
    letter-spacing: 0.5px;
  }

  [data-bs-toggle="tooltip"] {
    cursor: pointer;
  }

  @media (max-width: 576px) {
    thead {
      font-size: 0.8rem;
    }
    tbody td {
      font-size: 0.8rem;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const rowsPerPage = document.getElementById('rowsPerPage');
    const table = document.getElementById('assignmentsTable');
    const tbody = table.querySelector('tbody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const entriesInfo = document.getElementById('entriesInfo');

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });

    let rows = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.classList.contains('text-muted'));
    let currentPage = 1;
    let perPage = parseInt(rowsPerPage.value);

    function updateTable() {
      const search = searchInput.value.toLowerCase();
      const filteredRows = rows.filter(r =>
        Array.from(r.cells).some(cell => cell.textContent.toLowerCase().includes(search))
      );

      const totalPages = Math.ceil(filteredRows.length / perPage);
      if (currentPage > totalPages) currentPage = totalPages || 1;

      const start = (currentPage - 1) * perPage;
      const end = start + perPage;

      rows.forEach(r => r.style.display = 'none');
      filteredRows.slice(start, end).forEach(r => r.style.display = '');

      entriesInfo.textContent = `Showing ${start + 1} to ${Math.min(end, filteredRows.length)} of ${filteredRows.length} assignments`;

      prevBtn.disabled = currentPage <= 1;
      nextBtn.disabled = currentPage >= totalPages;
    }

    searchInput.addEventListener('input', () => { currentPage = 1; updateTable(); });
    rowsPerPage.addEventListener('change', () => { perPage = parseInt(rowsPerPage.value); currentPage = 1; updateTable(); });
    prevBtn.addEventListener('click', () => { currentPage--; updateTable(); });
    nextBtn.addEventListener('click', () => { currentPage++; updateTable(); });

    updateTable();
  });
</script>
