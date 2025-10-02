<div class="container-fluid py-5">
  <div class="card shadow-lg rounded-4 border-0">

    <!-- Header -->
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
      <h4 class="mb-2 mb-md-0 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Accident / Incident Records</h4>
      <div>
        <?= $this->Html->link('<i class="fas fa-plus"></i> Add New Accident', 
          ['action'=>'add'], 
          ['class'=>'btn btn-light btn-sm shadow-sm px-3', 'escape'=>false]) ?>
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
          </select> entries
        </label>
      </div>
      <input type="text" id="searchInput" class="form-control form-control-sm w-50" placeholder="Search accidents...">
    </div>

    <!-- Table -->
    <div class="table-responsive p-3">
      <table id="accidentsTable" class="table align-middle mb-0 table-striped table-hover rounded-3 shadow-sm">
        <thead class="bg-gradient-light text-uppercase text-muted small text-center">
          <tr>
            <th>#</th>
            <th>Vehicle</th>
            <th>Driver</th>
            <th>Date & Time</th>
            <th>Location</th>
            <th>Nature</th>
            <th>Insurance Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php foreach ($accidents as $accident): ?>
            <tr>
              <td class="fw-semibold"><?= h($accident->accident_id) ?></td>
              <td><span class="badge bg-info"><?= h(!empty($accident->vehicle->registration_no) ? $accident->vehicle->registration_no : $accident->vehicle_id) ?></span></td>
              <td><span class="badge bg-secondary"><?= h(!empty($accident->driver->name) ? $accident->driver->name : $accident->driver_id) ?></span></td>
              <td><?= h($accident->date_time->format('d M Y H:i')) ?></td>
              <td><?= h($accident->location) ?></td>
              <td><?= h($accident->nature_of_accident) ?></td>
              <td>
                <span class="badge rounded-pill px-3 py-1 <?= $accident->insurance_claim_status == 'Claimed' ? 'bg-success text-white p-2' : 'bg-secondary text-white p-2' ?>">
                  <?= h($accident->insurance_claim_status) ?>
                </span>
              </td>
              <td>
                <div class="btn-group btn-group-sm">
                  <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action'=>'view',$accident->accident_id], ['class'=>'btn btn-light border shadow-sm', 'escape'=>false, 'title'=>'View', 'data-bs-toggle'=>'tooltip']) ?>
                  <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action'=>'edit',$accident->accident_id], ['class'=>'btn btn-light border text-warning shadow-sm', 'escape'=>false, 'title'=>'Edit', 'data-bs-toggle'=>'tooltip']) ?>
                  <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action'=>'delete',$accident->accident_id], ['confirm'=>'Are you sure?', 'class'=>'btn btn-light border text-danger shadow-sm', 'escape'=>false, 'title'=>'Delete', 'data-bs-toggle'=>'tooltip']) ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Footer / Pagination -->
    <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div class="small text-muted" id="entriesInfo">Showing 1 to 10 of <?= count($accidents) ?> records</div>
      <div class="d-flex gap-2">
        <button id="prevBtn" class="btn btn-primary btn-sm rounded-pill">Previous</button>
        <button id="nextBtn" class="btn btn-primary btn-sm rounded-pill">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- JS (search + pagination like other tables) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const rowsPerPage = document.getElementById('rowsPerPage');
  const table = document.getElementById('accidentsTable');
  const tbody = table.querySelector('tbody');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const entriesInfo = document.getElementById('entriesInfo');

  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

  let rows = Array.from(tbody.querySelectorAll('tr'));
  let currentPage = 1;
  let perPage = parseInt(rowsPerPage.value);

  function updateTable() {
    const search = searchInput.value.toLowerCase();
    const filteredRows = rows.filter(r => 
      Array.from(r.cells).some(cell => cell.textContent.toLowerCase().includes(search))
    );

    const totalPages = Math.ceil(filteredRows.length / perPage);
    if(currentPage > totalPages) currentPage = totalPages || 1;

    const start = (currentPage-1)*perPage;
    const end = start + perPage;

    rows.forEach(r => r.style.display='none');
    filteredRows.slice(start,end).forEach(r => r.style.display='');

    entriesInfo.textContent = `Showing ${start+1} to ${Math.min(end, filteredRows.length)} of ${filteredRows.length} records`;
    prevBtn.disabled = currentPage <= 1;
    nextBtn.disabled = currentPage >= totalPages;
  }

  searchInput.addEventListener('input', ()=>{ currentPage=1; updateTable(); });
  rowsPerPage.addEventListener('change', ()=>{ perPage=parseInt(rowsPerPage.value); currentPage=1; updateTable(); });
  prevBtn.addEventListener('click', ()=>{ currentPage--; updateTable(); });
  nextBtn.addEventListener('click', ()=>{ currentPage++; updateTable(); });

  updateTable();
});
</script>
