<div class="container-fluid py-5">
  <div class="card shadow-lg rounded-4 border-0">

    <!-- Header -->
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
      <h4 class="mb-2 mb-md-0 fw-bold"><i class="fas fa-file-shield me-2"></i> Insurance Records</h4>
      <div>
        <?= $this->Html->link(
          '<i class="fas fa-plus"></i> Add Insurance',
          ['action' => 'add'],
          ['class' => 'btn btn-light btn-sm shadow-sm px-3', 'escape' => false]
        ) ?>
      </div>
    </div>

    <!-- Controls -->
    <div
      class="card-body border-bottom py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
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
      <input type="text" id="searchInput" class="form-control form-control-sm w-50" placeholder="Search insurance...">
    </div>

    <!-- Table -->
    <div class="table-responsive p-3">
      <table id="insuranceTable" class="table align-middle mb-0 table-striped table-hover rounded-3 shadow-sm">
        <thead class="bg-gradient-light text-uppercase text-muted small">
          <tr class="text-center">
            <th>#</th>
            <th>Vehicle</th>
            <th>Policy No</th>
            <th>Nature</th>
            <th>Insurer</th>
            <th>Start Date</th>
            <th>Expiry Date</th>
            <th>Premium</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($insurance as $i): ?>
            <tr class="text-center align-middle">
              <td class="fw-semibold"><?= h($i->insurance_id) ?></td>
              <td><?= h($i->vehicle->registration_no) ?></td>
              <td><?= h($i->policy_no) ?></td>
              <td><?= h($i->nature) ?></td>
              <td><?= h($i->insurer_name) ?></td>
              <td><?= h($i->start_date) ?></td>
              <td><?= h($i->expiry_date) ?></td>
              <td><?= h($i->premium_amount) ?></td>
              <td>
                <span
                  class="badge rounded-pill px-3 py-1 <?= $i->status == 'Active' ? 'bg-success text-white p-2' : 'bg-secondary text-white p-2' ?>">
                  <?= h($i->status) ?>
                </span>
              </td>
              <td>
                <div class="btn-group btn-group-sm" role="group">
                  <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $i->insurance_id], ['class' => 'btn btn-light border shadow-sm', 'escape' => false, 'title' => 'View', 'data-bs-toggle' => 'tooltip']) ?>

                  <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $i->insurance_id], ['class' => 'btn btn-light border text-warning shadow-sm', 'escape' => false, 'title' => 'Edit', 'data-bs-toggle' => 'tooltip']) ?>
                  <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $i->insurance_id], ['confirm' => 'Are you sure?', 'class' => 'btn btn-light border text-danger shadow-sm', 'escape' => false, 'title' => 'Delete', 'data-bs-toggle' => 'tooltip']) ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Footer / Pagination -->
    <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div class="small text-muted" id="entriesInfo">
        Showing 1 to 10 of <?= count($insurance) ?> records
      </div>
      <div class="d-flex gap-2">
        <button id="prevBtn" class="btn btn-primary btn-sm rounded-pill">Previous</button>
        <button id="nextBtn" class="btn btn-primary btn-sm rounded-pill">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- CSS -->
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

  [data-bs-toggle="tooltip"] {
    cursor: pointer;
  }
</style>

<!-- JS -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const rowsPerPage = document.getElementById('rowsPerPage');
    const table = document.getElementById('insuranceTable');
    const tbody = table.querySelector('tbody');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const entriesInfo = document.getElementById('entriesInfo');

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });

    let rows = Array.from(tbody.querySelectorAll('tr'));
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

      entriesInfo.textContent = `Showing ${start + 1} to ${Math.min(end, filteredRows.length)} of ${filteredRows.length} records`;

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