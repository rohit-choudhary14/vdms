<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <title>Vehicle & Driver Management System</title>
    <?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1') ?>
    <?= $this->Html->css([
        'bootstrap.min.css',
        'fontawesome/all.min.css',
        'select2.min.css',
        'select2-bootstrap-5-theme.min.css',
        'flatpickr.min.css'
    ]) ?>

    <?= $this->Html->script([
        'jquery-3.6.4.min.js',
        'bootstrap.bundle.min.js',
        'select2.min.js',
        'flatpickr.js'
    ]) ?>

    <style>
        
        .submenu a {
            padding-left: 45px !important;
            font-size: 0.9rem;
             text-decoration: none;
            color: black;
        }

        .form-error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Fixed Sidebar */
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            /* ensure navbar stays above sidebar */
        }

        #sidebar {
            position: fixed;
            top: 56px;
            /* height of navbar */
            left: 0;
            height: calc(100vh - 56px);
            width: 250px;
            overflow-y: auto;
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Page Content should have left padding equal to sidebar */
        #page-content {
            margin-left: 250px;
        }

        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                top: 56px;
                left: -250px;
                /* hidden by default */
                transition: left 0.3s;
            }

            #sidebar.active {
                left: 0;
            }

            #page-content {
                margin-left: 0;
            }
        }

        /* Scrollbar for sidebar */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
    </style>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-info fixed-top shadow-lg">
        <a class="navbar-brand" href="#"><i class="fas fa-car"></i> Vehicle & Driver System</a>
        <button class="navbar-toggler" type="button" id="sidebarCollapseBtn">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-user"></i>
                        <?php $user = $this->request->getSession()->read('Auth.User'); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Wrapper -->
    <?php if ($user): ?>
        <div class="d-flex">
            <!-- Sidebar -->

            <div id="sidebar" class="bg-light border-right shadow-lg">
                <div class="list-group list-group-flush">
                    <a href="/dashboard" class="list-group-item list-group-item-action"><i
                            class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="/vehicles" class="list-group-item list-group-item-action"><i class="fas fa-car"></i> Vehicle
                        Master</a>
                    <a href="/users" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> User
                        Master</a>
                    <a href="/drivers" class="list-group-item list-group-item-action"><i class="fas fa-id-card"></i> Driver
                        Master</a>

                    <li class="list-group-item p-0">
                        <a href="#" class="d-flex align-items-center justify-content-between px-3 py-2 list-group-item list-group-item-action"
                            onclick="toggleSubMenu(event, 'insuranceMenu')">
                            <span><i class="fas fa-shield-alt me-2"></i> Insurance</span>
                            <i class="fas fa-chevron-down small"></i>
                        </a>

                        <div id="insuranceMenu" class="submenu" style="display:none;">
                            <a href="/insurance" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-alt me-2"></i> Insurance Master
                            </a>
                            <a href="/insurance_companies" class="list-group-item list-group-item-action">
                                <i class="fas fa-building me-2"></i> Insurance Company Master
                            </a>
                        </div>
                    </li>



                    <a href="/maintenance" class="list-group-item list-group-item-action"><i class="fas fa-tools"></i>
                        Servicing & Maintenance</a>
                    <a href="/fuel" class="list-group-item list-group-item-action"><i class="fas fa-gas-pump"></i> Fuel &
                        Mileage</a>
                    <a href="/accidents" class="list-group-item list-group-item-action"><i
                            class="fas fa-exclamation-triangle"></i> Accident/Incident</a>
                    <a href="/complaints" class="list-group-item list-group-item-action"><i class="fas fa-comment-dots"></i>
                        Complaints</a>
                    <a href="/reports" class="list-group-item list-group-item-action"><i class="fas fa-chart-bar"></i>
                        Reports</a>
                    <a href="/rules" class="list-group-item list-group-item-action"><i class="fas fa-book"></i>
                        Rules/Guidelines</a>
                </div>
            </div>





        </div>
    <?php endif; ?>
    <!-- Main Content -->
    <div id="page-content" class="flex-fill p-4">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>

    <!-- JS -->


    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarCollapseBtn');
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });
    </script>
    <?= $this->fetch('script') ?>
</body>
<script>
    function toggleSubMenu(event, id) {
        event.preventDefault();
        const menu = document.getElementById(id);
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }
</script>

</html>