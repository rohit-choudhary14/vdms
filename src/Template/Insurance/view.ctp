<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $insurance
 * @var \Cake\Datasource\EntityInterface|null $vehicle
 * @var \Cake\Datasource\ResultSetInterface $history
 * @var int|null $daysLeft
 * @var bool $isExpired
 * @var string $renewalStatus
 * @var int $renewalAlertDays
 */
?>
<div class="container-fluid py-4 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-1"></i> Back',
            ['action' => 'index'],
            ['class' => 'btn btn-outline-dark', 'escape' => false]
        ) ?>
        <div>

            <!-- Renewal badge -->
            <?php
            $badgeClass = 'bg-success';
            $badgeText = 'Valid';
            if ($renewalStatus === 'warning') {
                $badgeClass = 'bg-warning text-dark';
                $badgeText = "Renewal soon ({$daysLeft}d)";
            }
            if ($renewalStatus === 'urgent') {
                $badgeClass = 'bg-danger';
                $badgeText = "Expiring in {$daysLeft}d";
            }
            if ($renewalStatus === 'expired') {
                $badgeClass = 'bg-secondary';
                $badgeText = "Expired";
            }
            ?>
            <span class="badge <?= $badgeClass ?> px-3 py-2 fw-bold">
                <?= h($badgeText) ?>
            </span>
        </div>
    </div>
    <!-- Redesigned Countdown Section -->
    <div class="countdown-container mt-4 p-3 rounded shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-clock me-2"></i> Renewal Countdown
            </h5>
            <span id="countdown-status-badge" class="badge px-3 py-2 fw-bold"></span>
        </div>

        <div id="renewal-countdown" class="countdown-display mt-3" data-expiry="<?= h($insurance->expiry_date) ?>">

            <div id="countdown-output" class="countdown-time">
                <?= $isExpired ? 'Expired' : ($daysLeft . ' day(s) left') ?>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Insurance Info -->
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-dark text-white fw-bold rounded-top-4">
                    <h3>Insurance Details (Policy: <?= h($insurance->policy_no) ?>)</h3>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th>Insurance ID</th>
                                    <td><?= h($insurance->id) ?></td>
                                </tr>
                                <tr>
                                    <th>Vehicle Code</th>
                                    <td><?= h($insurance->vehicle_code) ?></td>
                                </tr>
                                <tr>
                                    <th>Policy No</th>
                                    <td><?= h($insurance->policy_no) ?></td>
                                </tr>
                                <tr>
                                    <th>Nature</th>
                                    <td><?= h($insurance->nature) ?></td>
                                </tr>
                                <tr>
                                    <th>Insurer</th>
                                    <td><?= h($insurance->insurer_name) ?></td>
                                </tr>
                                <tr>
                                    <th>Insurer Contact</th>
                                    <td><?= h($insurance->insurer_contact) ?></td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td><?= h($insurance->start_date) ?></td>
                                </tr>
                                <tr>
                                    <th>Expiry Date</th>
                                    <td><?= h($insurance->expiry_date) ?></td>
                                </tr>
                                <tr>
                                    <th>Premium Amount</th>
                                    <td><?= h($insurance->premium_amount) ?></td>
                                </tr>
                                <tr>
                                    <th>Base Premium</th>
                                    <td><?= h($insurance->base_premium) ?></td>
                                </tr>
                                <tr>
                                    <th>GST</th>
                                    <td><?= h($insurance->gst_amount) ?></td>
                                </tr>
                                <tr>
                                    <th>NCB %</th>
                                    <td><?= h($insurance->ncb_percent) ?></td>
                                </tr>
                                <tr>
                                    <th>Policy Tenure</th>
                                    <td><?= h($insurance->policy_tenure) ?></td>
                                </tr>
                                <tr>
                                    <th>Addons</th>
                                    <td><?= h($insurance->addons) ?></td>
                                </tr>
                                <tr>
                                    <th>Next Due</th>
                                    <td><?= h($insurance->next_due) ?></td>
                                </tr>
                                <tr>
                                    <th>Renewal Alert (days)</th>
                                    <td><?= h($insurance->renewal_alert) ?></td>
                                </tr>
                                <tr>
                                    <th>Document</th>
                                    <td>
                                        <?php if (!empty($insurance->document)): ?>
                                            <a href="<?= $this->Url->build('/img/' . $insurance->document) ?>"
                                                target="_blank">
                                                <i class="fas fa-file-pdf"></i> View Document
                                            </a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?= h($insurance->status) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Live countdown -->
                    <div class="mt-3">
                        <strong>Renewal countdown:</strong>
                        <div id="renewal-countdown" data-expiry="<?= h($insurance->expiry_date) ?>">
                            <?php if ($insurance->expiry_date): ?>
                                <span
                                    id="countdown-output"><?= $isExpired ? 'Expired' : ($daysLeft . ' day(s) left') ?></span>
                            <?php else: ?>
                                <span id="countdown-output">N/A</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Vehicle / Photo -->
        <div class="col-lg-4">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-dark text-white fw-bold rounded-top-4 text-center">
                    <i class="fas fa-car me-2"></i> Vehicle Snapshot
                </div>
                <div class="card-body text-center">
                    <?php if (!empty($vehicle) && !empty($vehicle->photo_front)): ?>
                        <img src="<?= $this->Url->build('/img/' . $vehicle->photo_front) ?>"
                            class="img-fluid rounded shadow-sm border mb-3" alt="Front">
                    <?php else: ?>
                        <div class="border rounded p-4">
                            <i class="fas fa-car fa-3x text-muted"></i>
                            <div class="mt-2 text-muted">No photo available</div>
                        </div>
                    <?php endif; ?>

                    <div class="text-start mt-3">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>Make/Model</th>
                                <td><?= h(isset($vehicle->make_model) ? $vehicle->make_model : 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td><?= h(isset($insurance->vehicle_year) ? $insurance->vehicle_year : (isset($vehicle->year) ? $vehicle->year : 'N/A')) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Fuel</th>
                                <td><?= h(isset($insurance->fuel_type) ? $insurance->fuel_type : (isset($vehicle->fuel_type) ? $vehicle->fuel_type : 'N/A')) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Engine CC</th>
                                <td><?= h(isset($insurance->engine_cc) ? $insurance->engine_cc : 'N/A') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Previous Insurance History -->
    <div class="row g-4 mt-5">
        <div class="col-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-dark text-white fw-bold rounded-top-4">
                    <h4 class="mt-2">Previous Insurance History</h4>
                </div>

                <div class="card-body p-3">
                    <?php if (!$history->isEmpty()): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Policy No</th>
                                        <th>Insurer</th>
                                        <th>Start</th>
                                        <th>Expiry</th>
                                        <th>Premium</th>
                                        <th>Previous Expiry</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $h): ?>
                                        <tr>
                                            <td><?= h($h->policy_no) ?></td>
                                            <td><?= h($h->insurer_name) ?></td>
                                            <td><?= h($h->start_date) ?></td>
                                            <td><?= h($h->expiry_date) ?></td>
                                            <td><?= h($h->premium_amount) ?></td>
                                            <td><?= h($h->previous_policy_expiry) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary view-history-btn" data-json='<?= json_encode([
                                                    'id' => $h->id,
                                                    'policy_no' => $h->policy_no,
                                                    'insurer_name' => $h->insurer_name,
                                                    'insurer_contact' => $h->insurer_contact,
                                                    'insurer_address' => $h->insurer_address,
                                                    'start_date' => $h->start_date,
                                                    'expiry_date' => $h->expiry_date,
                                                    'premium_amount' => $h->premium_amount,
                                                    'addons' => $h->addons,
                                                    'document' => $h->document,
                                                    'status' => $h->status,
                                                    'previous_policy_expiry' => $h->previous_policy_expiry,
                                                ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="mb-0">No previous insurance records found for this vehicle.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simple modal (no bootstrap js) -->
<div id="history-modal" class="custom-modal" aria-hidden="true" style="display:none;">
    <div class="custom-modal-backdrop"></div>
    <div class="custom-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="history-modal-title">
        <div class="custom-modal-header">
            <h5 id="history-modal-title">Policy details</h5>
            <button type="button" class="custom-modal-close" aria-label="Close">&times;</button>
        </div>
        <div class="custom-modal-body" id="history-modal-body">
            <!-- Filled by JS -->
        </div>
        <div class="custom-modal-footer text-end p-2">
            <button class="btn btn-secondary btn-sm custom-modal-close">Close</button>
        </div>
    </div>
</div>

<!-- CSS (kept small, you can move to asset) -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .table th {
        width: 30%;
        color: #495057;
        font-weight: 600;
    }

    .table td {
        color: #343a40;
    }

    .custom-modal {
        position: fixed;
        inset: 0;
        z-index: 1100;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    }

    .custom-modal-dialog {
        position: relative;
        z-index: 2;
        width: 90%;
        max-width: 720px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #eee;
    }

    .custom-modal-body {
        padding: 1rem;
        max-height: 60vh;
        overflow: auto;
    }

    .custom-modal-close {
        background: none;
        border: 0;
        font-size: 1.4rem;
        line-height: 1;
        cursor: pointer;
    }

    /* Countdown Box Styling */
    .countdown-container {
        background: #ffffff;
        border-left: 6px solid #0d6efd;
        transition: 0.3s ease;
    }

    .countdown-container.warning {
        border-left-color: #ffc107;
    }

    .countdown-container.urgent {
        border-left-color: #dc3545;
    }

    .countdown-container.expired {
        border-left-color: #6c757d;
    }

    /* Countdown Display */
    .countdown-display {
        text-align: center;
        padding: 15px 10px;
    }

    .countdown-time {
        font-size: 1.8rem;
        font-weight: 600;
        letter-spacing: 1px;
        color: #212529;
        animation: fadeIn 0.4s ease-in-out;
    }

    /* Smooth fade animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- JS: countdown + modal behaviour -->
<script>
    (function () {

        const box = document.querySelector('.countdown-container');
        const badge = document.getElementById('countdown-status-badge');
        const countdownEl = document.getElementById('renewal-countdown');
        const output = document.getElementById('countdown-output');

        if (!countdownEl) return;

        const expiry = countdownEl.getAttribute('data-expiry');

        // Parse date safely
        function parseDate(d) {
            if (!d) return null;

            // YYYY-MM-DD
            if (/^\d{4}-\d{2}-\d{2}$/.test(d))
                return new Date(d + 'T23:59:59');

            // DD-MM-YYYY
            const parts = d.split("-");
            if (parts.length === 3)
                return new Date(`${parts[2]}-${parts[1]}-${parts[0]}T23:59:59`);

            return new Date(d);
        }

        const expiryDate = parseDate(expiry);
        if (!expiryDate) return;

        function updateCountdown() {
            const now = new Date();
            const diff = expiryDate - now;

            if (diff <= 0) {
                output.textContent = "Expired";
                setBadge("Expired", "expired", "bg-secondary");
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            output.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

            if (days <= 0) {
                setBadge("Urgent", "urgent", "bg-danger");
            } else if (days <= 7) {
                setBadge("Renew Soon", "warning", "bg-warning text-dark");
            } else {
                setBadge("Active", "", "bg-success");
            }
        }

        function setBadge(text, boxClass, badgeClass) {
            box.classList.remove("warning", "urgent", "expired");
            if (boxClass) box.classList.add(boxClass);
            badge.className = `badge px-3 py-2 fw-bold ${badgeClass}`;
            badge.textContent = text;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);



        // Modal logic (no bootstrap)
        const modal = document.getElementById('history-modal');
        const modalBody = document.getElementById('history-modal-body');
        const closeBtns = Array.from(document.querySelectorAll('.custom-modal-close'));
        function openModalWithData(obj) {
            modalBody.innerHTML = `
            <table class="table table-borderless">
                <tr><th>Policy ID</th><td>${escapeHtml(obj.id)}</td></tr>
                <tr><th>Policy No</th><td>${escapeHtml(obj.policy_no)}</td></tr>
                <tr><th>Insurer</th><td>${escapeHtml(obj.insurer_name)}</td></tr>
                <tr><th>Contact</th><td>${escapeHtml(obj.insurer_contact || 'N/A')}</td></tr>
                <tr><th>Address</th><td>${escapeHtml(obj.insurer_address || 'N/A')}</td></tr>
                <tr><th>Start Date</th><td>${escapeHtml(obj.start_date || 'N/A')}</td></tr>
                <tr><th>Expiry</th><td>${escapeHtml(obj.expiry_date || 'N/A')}</td></tr>
                <tr><th>Premium</th><td>${escapeHtml(obj.premium_amount || 'N/A')}</td></tr>
                <tr><th>Addons</th><td>${escapeHtml(obj.addons || 'N/A')}</td></tr>
                <tr><th>Previous Expiry</th><td>${escapeHtml(obj.previous_policy_expiry || 'N/A')}</td></tr>
                <tr><th>Document</th><td>${obj.document ? '<a href="<?= $this->Url->build('/img/') ?>' + escapeHtml(obj.document) + '" target="_blank">View</a>' : 'N/A'}</td></tr>
                <tr><th>Status</th><td>${escapeHtml(obj.status || 'N/A')}</td></tr>
            </table>
        `;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        document.querySelectorAll('.view-history-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const json = this.getAttribute('data-json') || '{}';
                try {
                    const obj = JSON.parse(json);
                    openModalWithData(obj);
                } catch (e) {
                    console.error('Invalid JSON for history row', e);
                }
            });
        });

        closeBtns.forEach(b => b.addEventListener('click', closeModal));
        // close when clicking backdrop
        modal.addEventListener('click', function (e) {
            if (e.target.classList.contains('custom-modal-backdrop')) closeModal();
        });

        // basic HTML escape
        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    })();
</script>