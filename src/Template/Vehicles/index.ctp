<div class="container-fluid py-5">
  <div class="card shadow-lg rounded-4 border-0">

    <!-- Header -->
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
      <h4 class="mb-2 mb-md-0 fw-bold"><i class="fas fa-car me-2"></i> Vehicles</h4>
      <?= $this->Html->link(
        '<i class="fas fa-plus"></i> Add Vehicle',
        ['action' => 'add'],
        ['class' => 'btn btn-light btn-sm shadow-sm px-3', 'escape' => false]
      ) ?>
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
          entries</label>
      </div>
      <input type="text" id="searchInput" class="form-control form-control-sm w-50" placeholder="Search vehicles...">
    </div>

    <!-- Table -->
    <div class="table-responsive p-3">
      <table id="vehiclesTable" class="table align-middle mb-0 table-striped table-hover rounded-3 shadow-sm">
        <thead class="bg-gradient-light text-uppercase text-muted small">
          <tr class="text-center">
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
            <tr class="text-center align-middle">
              <td class="fw-semibold"><?= $v->id ?></td>
              <td><?= h($v->vehicle_code) ?></td>
              <td><?= h($v->registration_no) ?></td>
              <td><?= h($v->vehicle_type->type_name) ?></td>

              <td><?= h($v->fuel_type) ?></td>
              <td>
                <span
                  class="badge rounded-pill px-3 py-1 <?= $v->status == 'Active' ? 'bg-success text-white p-2' : 'bg-secondary text-white p-2' ?>"><?= h($v->status) ?></span>
              </td>
              <td>
                <div class="btn-group btn-group-sm" role="group">
                  <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $v->vehicle_code], ['class' => 'btn btn-light border shadow-sm', 'escape' => false, 'title' => 'View', 'data-bs-toggle' => 'tooltip']) ?>
                  <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $v->vehicle_code], ['class' => 'btn btn-light border text-warning shadow-sm', 'escape' => false, 'title' => 'Edit', 'data-bs-toggle' => 'tooltip']) ?>
                  <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $v->vehicle_code], ['confirm' => 'Are you sure?', 'class' => 'btn btn-light border text-danger shadow-sm', 'escape' => false, 'title' => 'Delete', 'data-bs-toggle' => 'tooltip']) ?>
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
        Showing 1 to 10 of <?= count($vehicles) ?> vehicles
      </div>
      <div class="d-flex gap-2">
        <button id="prevBtn" class="btn btn-primary btn-sm rounded-pill">Previous</button>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button id="nextBtn" class="btn btn-primary btn-sm rounded-pill">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- Custom Gradient Button CSS -->
<style>
  .btn-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%);
    border: none;
    color: white;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }

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
</style>

<!-- JS: Search + Pagination + Tooltip -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const rowsPerPage = document.getElementById('rowsPerPage');
    const table = document.getElementById('vehiclesTable');
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

      entriesInfo.textContent = `Showing ${start + 1} to ${Math.min(end, filteredRows.length)} of ${filteredRows.length} vehicles`;

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