<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC Principal</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../../images/icon/mkce_s.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- external css -->
    <link rel="stylesheet" href="../../css/modal.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 60px;
            --footer-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --dark-bg: #1a1c23;
            --light-bg: #f8f9fc;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* General Styles with Enhanced Typography */
        body {
            min-height: 100vh;
            margin: 0;
            background: var(--light-bg);
            overflow-x: hidden;
            padding-bottom: var(--footer-height);
            position: relative;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Content Area Styles */
        .content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* Content Navigation */
        .content-nav {
            background: linear-gradient(45deg, #4e73df, #1cc88a);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .content-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            overflow-x: auto;
        }

        .content-nav li a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .content-nav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar.collapsed+.content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .breadcrumb-area {
            background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin: 20px;
            padding: 15px 20px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: #224abe;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .topbar {
                left: 0 !important;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .mobile-overlay.show {
                display: block;
            }

            .content {
                margin-left: 0 !important;
            }

            .brand-logo {
                display: block;
            }

            .user-profile {
                margin-left: 0;
            }

            .sidebar .logo {
                justify-content: center;
            }

            .sidebar .menu-item span,
            .sidebar .has-submenu::after {
                display: block !important;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            .footer {
                left: 0 !important;
            }

            .content-nav ul {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .content-nav ul::-webkit-scrollbar {
                height: 4px;
            }

            .content-nav ul::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
            }
        }

        .container-fluid {
            padding: 10px;
        }


        /* loader */
        .loader-container {
            position: fixed;
            left: var(--sidebar-width);
            right: 0;
            top: var(--topbar-height);
            bottom: var(--footer-height);
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            /* Changed from 'none' to show by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: left 0.3s ease;
        }

        .sidebar.collapsed+.content .loader-container {
            left: var(--sidebar-collapsed-width);
        }

        @media (max-width: 768px) {
            .loader-container {
                left: 0;
            }
        }

        /* Hide loader when done */
        .loader-container.hide {
            display: none;
        }

        /* Loader Animation */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid var(--primary-color);
            border-right: 5px solid var(--success-color);
            border-bottom: 5px solid var(--primary-color);
            border-left: 5px solid var(--success-color);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Hide content initially */
        .content-wrapper {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Show content when loaded */
        .content-wrapper.show {
            opacity: 1;
        }


        /* leave approval content page style starts */

        .custom-tabs {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }

        .nav-tabs {
            border: none;
            gap: 10px;
            padding: 6px;
            background: #f8f9fd;
            border-radius: 12px;
        }

        .nav-link {
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            z-index: 1;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            z-index: -1;
            transform: translateY(100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover::before {
            transform: translateY(0);
        }

        .nav-link.active {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* CL Tab Styling */
        #CL-tab {
            background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
            color: #fff;
        }

        #CL-tab:not(.active) {
            background: #fff;
            color: #FF6B6B;
        }

        #CL-tab:hover:not(.active) {
            background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
            color: #fff;
        }

        /* OD Tab Styling */
        #OD-tab {
            background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
            color: #fff;
        }

        #OD-tab:not(.active) {
            background: #fff;
            color: #4E65FF;
        }

        #OD-tab:hover:not(.active) {
            background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
            color: #fff;
        }


        /* Permission Tab Styling */
        #Per-tab {
            background-image: linear-gradient(to top, rgb(36, 66, 9) 0%, #00e3ae 100%);
            color: #fff;
        }

        #Per-tab:not(.active) {
            background: #fff;
            color: #1F7B17;
        }

        #Per-tab:hover:not(.active) {
            background-image: linear-gradient(to top, rgb(36, 66, 9) 0%, #00e3ae 100%);
            color: #fff;
        }


        /* COL Tab Styling */
        #COL-tab {
            background-image: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
            color: #fff;
        }

        #COL-tab:not(.active) {
            background: #fff;
            color: #771DFB;
        }

        #COL-tab:hover:not(.active) {
            background-image: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
            color: #fff;
        }


        /* ODR Tab Styling */
        #ODR-tab {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.15) 0%, rgba(0, 0, 0, 0.15) 100%), radial-gradient(at top center, rgba(255, 255, 255, 0.40) 0%, rgba(0, 0, 0, 0.40) 120%) #989898;
            background-blend-mode: multiply, multiply;

            color: #fff;
        }

        #ODR-tab:not(.active) {
            background: #fff;
            color: rgb(26, 25, 27);
        }

        #ODR-tab:hover:not(.active) {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.15) 0%, rgba(0, 0, 0, 0.15) 100%), radial-gradient(at top center, rgba(255, 255, 255, 0.40) 0%, rgba(0, 0, 0, 0.40) 120%) #989898;
            background-blend-mode: multiply, multiply;
            color: #fff;
        }



        .tab-icon {
            margin-right: 8px;
            font-size: 1.1em;
            transition: transform 0.3s ease;
        }

        .nav-link:hover .tab-icon {
            transform: rotate(15deg) scale(1.1);
        }

        .nav-link.active .tab-icon {
            animation: bounce 0.5s ease infinite alternate;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-2px);
            }
        }

        .tab-content {
            padding: 20px;
            margin-top: 15px;
            background: #fff;
            border-radius: 12px;
            min-height: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .tab-pane {
            opacity: 0;
            transform: translateY(15px);
            transition: all 0.4s ease-out;
        }

        .tab-pane.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Glowing effect on active tab */
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            height: 3px;
            background: inherit;
            border-radius: 6px;
            filter: blur(2px);
            animation: glow 1.5s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                opacity: 0.6;
                width: 40%;
            }

            to {
                opacity: 1;
                width: 55%;
            }
        }


        .table {
            width: 100% !important;
        }

        .table thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        #ColTable th,
        #leaveTable th,
        #odTable th,
        #PerTable th,
        #odrTable th,
        #leaveBalanceTable th {
            background: none;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: white;
            text-align: center;
        }

        #ColTable td,
        #leaveTable td,
        #odTable td,
        #PerTable td,
        #odrTable td,
        #leaveBalanceTable td {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'topbar.php'; ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Leave Approval</li>
                </ol>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="container-fluid">

            <div class="custom-tabs">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="CL-tab" data-bs-toggle="tab" data-bs-target="#CL"
                            type="button" role="tab">
                            <i class="fas fa-bus tab-icon"></i>Leave Approval </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="OD-tab" data-bs-toggle="tab" data-bs-target="#OD" type="button"
                            role="tab">
                            <i class="fas fa-edit tab-icon"></i>OD Approval </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Per-tab" data-bs-toggle="tab" data-bs-target="#Per" type="button"
                            role="tab">
                            <i class="fas fa-edit tab-icon"></i>Permission
                            Approval </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="COL-tab" data-bs-toggle="tab" data-bs-target="#COL" type="button"
                            role="tab">
                            <i class="fas fa-edit tab-icon"></i>COL Approval </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ODR-tab" data-bs-toggle="tab" data-bs-target="#ODR" type="button"
                            role="tab">
                            <i class="fas fa-edit tab-icon"></i>OD Request
                            Approval </button>
                    </li>

                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- CL content starts -->
                    <div class="tab-pane fade show active" id="CL" role="tabpanel">
                        <div class="container-fluid my-5" id="LeaveTab">
                            <table class="table table-striped table-bordered" id="leaveTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Total Days</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>


                    <!-- OD content starts -->
                    <div class="tab-pane fade" id="OD" role="tabpanel">
                        <div class="container-fluid my-5" id="ODTab">
                            <table class="table table-striped table-bordered" id="odTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>OD Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Total Days</th>
                                        <th>Reason</th>
                                        <th>Proof</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>


                    <!-- PER content starts -->
                    <div class="tab-pane fade" id="Per" role="tabpanel">
                        <div class="container-fluid my-5" id="PerTab">
                            <table class="table table-striped table-bordered" id="PerTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Permission Type</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>


                    <!-- COL content starts -->
                    <div class="tab-pane fade" id="COL" role="tabpanel">
                        <div class="container-fluid my-5" id="ColTab">
                            <table class="table table-striped table-bordered" id="ColTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Intime</th>
                                        <th>Outtime</th>
                                        <th>Days</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>


                    <!-- ODR content starts -->
                    <div class="tab-pane fade" id="ODR" role="tabpanel">
                        <div class="container-fluid my-5" id="ODRTab">
                            <table class="table table-striped table-bordered" id="odrTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Total Days</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <div class="table-containe py-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(135deg, #4CAF50, #2196F3);color:white;">
                        <h5 class="mb-0">Leave Balances</h5>
                    </div>
                    <div class="card-body">
                        <table id="leaveBalanceTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>CL</th>
                                    <th>COL</th>
                                    <th>ODB</th>
                                    <th>ODR</th>
                                    <th>ODP</th>
                                    <th>ODO</th>
                                    <th>VL</th>
                                    <th>ML</th>
                                    <th>MAL</th>
                                    <th>MTL</th>
                                    <th>PTL</th>
                                    <th>SL</th>
                                    <th>SPL</th>
                                    <th>PER</th>
                                    <th>PER 2</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <!-- Footer -->
        <?php include 'footer.php'; ?>
    </div>

    <script>

        const loaderContainer = document.getElementById('loaderContainer');

        function showLoader() {
            loaderContainer.classList.add('show');
        }

        function hideLoader() {
            loaderContainer.classList.remove('show');
        }

        //    automatic loader
        document.addEventListener('DOMContentLoaded', function () {
            const loaderContainer = document.getElementById('loaderContainer');
            const contentWrapper = document.getElementById('contentWrapper');
            let loadingTimeout;

            function hideLoader() {
                loaderContainer.classList.add('hide');
                contentWrapper.classList.add('show');
            }

            function showError() {
                console.error('Page load took too long or encountered an error');
                // You can add custom error handling here
            }

            // Set a maximum loading time (10 seconds)
            loadingTimeout = setTimeout(showError, 10000);

            // Hide loader when everything is loaded
            window.onload = function () {
                clearTimeout(loadingTimeout);

                // Add a small delay to ensure smooth transition
                setTimeout(hideLoader, 500);
            };

            // Error handling
            window.onerror = function (msg, url, lineNo, columnNo, error) {
                clearTimeout(loadingTimeout);
                showError();
                return false;
            };
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Cache DOM elements
            const elements = {
                hamburger: document.getElementById('hamburger'),
                sidebar: document.getElementById('sidebar'),
                mobileOverlay: document.getElementById('mobileOverlay'),
                menuItems: document.querySelectorAll('.menu-item'),
                submenuItems: document.querySelectorAll('.submenu-item') // Add submenu items to cache
            };

            // Set active menu item based on current path
            function setActiveMenuItem() {
                const currentPath = window.location.pathname.split('/').pop();

                // Clear all active states first
                elements.menuItems.forEach(item => item.classList.remove('active'));
                elements.submenuItems.forEach(item => item.classList.remove('active'));

                // Check main menu items
                elements.menuItems.forEach(item => {
                    const itemPath = item.getAttribute('href')?.replace('/', '');
                    if (itemPath === currentPath) {
                        item.classList.add('active');
                        // If this item has a parent submenu, activate it too
                        const parentSubmenu = item.closest('.submenu');
                        const parentMenuItem = parentSubmenu?.previousElementSibling;
                        if (parentSubmenu && parentMenuItem) {
                            parentSubmenu.classList.add('active');
                            parentMenuItem.classList.add('active');
                        }
                    }
                });

                // Check submenu items
                elements.submenuItems.forEach(item => {
                    const itemPath = item.getAttribute('href')?.replace('/', '');
                    if (itemPath === currentPath) {
                        item.classList.add('active');
                        // Activate parent submenu and its trigger
                        const parentSubmenu = item.closest('.submenu');
                        const parentMenuItem = parentSubmenu?.previousElementSibling;
                        if (parentSubmenu && parentMenuItem) {
                            parentSubmenu.classList.add('active');
                            parentMenuItem.classList.add('active');
                        }
                    }
                });
            }

            // Handle mobile sidebar toggle
            function handleSidebarToggle() {
                if (window.innerWidth <= 768) {
                    elements.sidebar.classList.toggle('mobile-show');
                    elements.mobileOverlay.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                } else {
                    elements.sidebar.classList.toggle('collapsed');
                }
            }

            // Handle window resize
            function handleResize() {
                if (window.innerWidth <= 768) {
                    elements.sidebar.classList.remove('collapsed');
                    elements.sidebar.classList.remove('mobile-show');
                    elements.mobileOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                } else {
                    elements.sidebar.style.transform = '';
                    elements.mobileOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            }

            // Toggle User Menu
            const userMenu = document.getElementById('userMenu');
            const dropdownMenu = userMenu.querySelector('.dropdown-menu');
            userMenu.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                dropdownMenu.classList.remove('show');
            });

            // Enhanced Toggle Submenu with active state handling
            const menuItems = document.querySelectorAll('.has-submenu');
            menuItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent default if it's a link
                    const submenu = item.nextElementSibling;

                    // Toggle active state for the clicked menu item and its submenu
                    item.classList.toggle('active');
                    submenu.classList.toggle('active');

                    // Handle submenu item clicks
                    const submenuItems = submenu.querySelectorAll('.submenu-item');
                    submenuItems.forEach(submenuItem => {
                        submenuItem.addEventListener('click', (e) => {
                            // Remove active class from all submenu items
                            submenuItems.forEach(si => si.classList.remove('active'));
                            // Add active class to clicked submenu item
                            submenuItem.classList.add('active');
                            e.stopPropagation(); // Prevent event from bubbling up
                        });
                    });
                });
            });

            // Initialize event listeners
            function initializeEventListeners() {
                // Sidebar toggle for mobile and desktop
                if (elements.hamburger && elements.mobileOverlay) {
                    elements.hamburger.addEventListener('click', handleSidebarToggle);
                    elements.mobileOverlay.addEventListener('click', handleSidebarToggle);
                }
                // Window resize handler
                window.addEventListener('resize', handleResize);
            }

            // Initialize everything
            setActiveMenuItem();
            initializeEventListeners();
        });
    </script>

    <script>

        // Leave approve

        $(document).ready(function () {

            $('#leaveBalanceTable').DataTable({
                ajax: {
                    url: 'principal_leave_back.php',
                    type: 'POST',
                    data: { action: 'get_leave_balance_details' }
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'cl' },
                    { data: 'col' },
                    { data: 'odb' },
                    { data: 'odr' },
                    { data: 'odp' },
                    { data: 'odo' },
                    { data: 'vl' },
                    { data: 'ml' },
                    { data: 'mal' },
                    { data: 'mtl' },
                    { data: 'ptl' },
                    { data: 'sl' },
                    { data: 'spl' },
                    { data: 'pm' },
                    { data: 'tenpm' }
                ]
            });








            $('#leaveTable').DataTable({
                ajax: {
                    url: 'principal_leave_back.php',
                    type: 'POST',
                    data: { action: 'get_CL_leave_details' }
                },
                language: {
                    emptyTable: "No Leave data found",
                    loadingRecords: "No Leave data found",
                    zeroRecords: "No Leave data found"
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'uid' },
                    { data: 'name' },
                    { data: 'ltype' },
                    { data: 'fdate' },
                    { data: 'tdate' },
                    { data: 'tdays' },
                    { data: 'reason' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Store all necessary data as data attributes
                            return `
                <button class="btn btn-success approve-btn" 
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                     data-ltype="${row.ltype}"
                    data-fdate="${row.fdate}"
                    data-tdate="${row.tdate}"
                    data-fshift="${row.fshift}"
                    data-tshift="${row.tshift}"
                     style="background: transparent; border: none; padding: 5px;">
                    <img src="../../images/icon/accept.png" alt="View" style="width: 24px; height: 24px;">
                </button>
                <button class="btn btn-danger reject-btn"
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                    data-ltype="${row.ltype}"
                    data-fdate="${row.fdate}"
                    data-tdate="${row.tdate}"
                    data-fshift="${row.fshift}"
                    data-tshift="${row.tshift}"
                    data-tdays="${row.tdays}"
                     style="background: transparent; border: none; padding: 5px;">
                  <img src="../../images/icon/reject.png" alt="Reject" style="width: 24px; height: 24px;">
                </button>
            `;
                        }
                    }
                ]
            });

            // Approve button click event
            $('#leaveTable').on('click', '.approve-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid'),
                    ltype: button.data('ltype'),
                    fdate: button.data('fdate'),
                    tdate: button.data('tdate'),
                    fshift: button.data('fshift'),
                    tshift: button.data('tshift')
                };
                approveLeave(leaveData);
            });

            // Reject button click event
            $('#leaveTable').on('click', '.reject-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid'),
                    ltype: button.data('ltype'),
                    fdate: button.data('fdate'),
                    tdate: button.data('tdate'),
                    fshift: button.data('fshift'),
                    tshift: button.data('tshift'),
                    tdays: button.data('tdays')
                };
                rejectLeave(leaveData);
            });
        });

        function approveLeave(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'approve_leave',
                    id: leaveData.id,
                    uid: leaveData.uid,
                    ltype: leaveData.ltype,
                    fdate: leaveData.fdate,
                    tdate: leaveData.tdate,
                    fshift: leaveData.fshift,
                    tshift: leaveData.tshift
                },
                success: function (response) {
                    $('#leaveTable').DataTable().clear().draw();
                    $('#leaveTable').DataTable().ajax.reload().draw();
                    showNotification('Leave approved successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.success('Leave approved successfully');
                },
                error: function (xhr, status, error) {
                    console.error('Error approving leave:', error);
                    showNotification('Error approving leave. Please try again', 'error');
                    //alert('Error approving leave. Please try again.');
                }
            });
        }

        function rejectLeave(leaveData) {
            $.ajax({
                url: 'principal_leave_back',
                type: 'POST',
                data: {
                    action: 'reject_leave',
                    id: leaveData.id,
                    uid: leaveData.uid,
                    ltype: leaveData.ltype,
                    fdate: leaveData.fdate,
                    tdate: leaveData.tdate,
                    fshift: leaveData.fshift,
                    tshift: leaveData.tshift,
                    tdays: leaveData.tdays
                },
                success: function (response) {
                    $('#leaveTable').DataTable().clear().draw();
                    $('#leaveTable').DataTable().ajax.reload().draw();
                    showNotification('Leave rejected successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.error('Leave rejected successfully');
                },
                error: function (xhr, status, error) {
                    //console.error('Error rejecting leave:', error);
                    showNotification('Error rejecting leave. Please try again.', 'error');
                    //alert('Error rejecting leave. Please try again.');
                }
            });
        }

        // OD approve

        $(document).ready(function () {
            $('#odTable').DataTable({
                ajax: {
                    url: 'principal_leave_back.php',
                    type: 'POST',
                    data: { action: 'get_OD_details' }
                },
                language: {
                    emptyTable: "No OD data found",
                    loadingRecords: "No OD data found",
                    zeroRecords: "No OD data found"
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'uid' },
                    { data: 'name' },
                    { data: 'otype' },
                    { data: 'fdate' },
                    { data: 'tdate' },
                    { data: 'tdays' },
                    { data: 'reason' },
                    {
                        // View column with updated file path
                        data: 'file',
                        render: function (data, type, row) {
                            if (data) {
                                return `<div style="display: flex; justify-content: center;">
                                    <button class="btn btn-primary btn-sm view2_file_btn" 
                                            data-file="../../Files/uploads/OD/${data}" 
                                            style="background: transparent; border: none;">
                                        <img src="../../images/icon/eye.png" alt="View" style="width: 24px; height: 24px;">
                                    </button>
                                </div>`;
                            }
                            return 'No file';
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Store all necessary data as data attributes
                            return `
                <button class="btn btn-success approveOD-btn" 
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                    data-otype="${row.otype}"
                    data-fdate="${row.fdate}"
                    data-tdate="${row.tdate}"
                    data-fshift="${row.fshift}"
                    data-tshift="${row.tshift}"
                     style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/accept.png" alt="View" style="width: 24px; height: 24px;">
                </button>
                <button class="btn btn-danger rejectOD-btn"
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                    data-otype="${row.otype}"
                    data-fdate="${row.fdate}"
                    data-tdate="${row.tdate}"
                    data-fshift="${row.fshift}"
                    data-tshift="${row.tshift}"
                    data-tdays="${row.tdays}"
                    style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/reject.png" alt="Reject" style="width: 24px; height: 24px;">
                </button>
            `;
                        }
                    }
                ]
            });

            $(document).on('click', '.view2_file_btn', function () {
              
                const fileUrl = $(this).data('file');
                const fileExt = fileUrl.split('.').pop().toLowerCase();
                const fileContent = $('#fileContent');

                // Clear previous content
                fileContent.empty();

                // Check file type and display accordingly
                if (fileExt === 'pdf') {
                    fileContent.html(`<embed src="${fileUrl}" type="application/pdf" width="100%" height="600px">`);
                } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                    fileContent.html(`<img src="${fileUrl}" class="img-fluid" alt="Document">`);
                } else {
                    fileContent.html('<p class="text-danger">Unsupported file type</p>');
                }

                // Show the modal
                $('#fileViewModal_new').modal('show');
            });

            // Approve button click event
            $('#odTable').on('click', '.approveOD-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid'),
                    otype: button.data('otype'),
                    fdate: button.data('fdate'),
                    tdate: button.data('tdate'),
                    fshift: button.data('fshift'),
                    tshift: button.data('tshift')
                };
                approveOD(leaveData);
            });

            // Reject button click event
            $('#odTable').on('click', '.rejectOD-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid'),
                    otype: button.data('otype'),
                    fdate: button.data('fdate'),
                    tdate: button.data('tdate'),
                    fshift: button.data('fshift'),
                    tshift: button.data('tshift'),
                    tdays: button.data('tdays')
                };
                rejectOD(leaveData);
            });
        });

        function approveOD(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'approve_OD',
                    id: leaveData.id,
                    uid: leaveData.uid,
                    otype: leaveData.otype,
                    fdate: leaveData.fdate,
                    tdate: leaveData.tdate,
                    fshift: leaveData.fshift,
                    tshift: leaveData.tshift
                },
                success: function (response) {
                    $('#odTable').DataTable().clear().draw();
                    $('#odTable').DataTable().ajax.reload().draw();
                    showNotification('OD approved successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.success('OD approved successfully');
                },
                error: function (xhr, status, error) {
                    //console.error('Error approving OD:', error);
                    showNotification('Error approving OD. Please try again.', 'error');
                    //alert('Error approving OD. Please try again.');
                }
            });
        }

        function rejectOD(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'reject_OD',
                    id: leaveData.id,
                    uid: leaveData.uid,
                    otype: leaveData.otype,
                    fdate: leaveData.fdate,
                    tdate: leaveData.tdate,
                    fshift: leaveData.fshift,
                    tshift: leaveData.tshift,
                    tdays: leaveData.tdays
                },
                success: function (response) {
                    $('#odTable').DataTable().clear().draw();
                    $('#odTable').DataTable().ajax.reload().draw();
                    showNotification('OD rejected successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.error('OD rejected successfully');
                },
                error: function (xhr, status, error) {
                    // console.error('Error rejecting OD:', error);
                    showNotification('Error rejecting OD. Please try again.', 'error');
                    //alert('Error rejecting OD. Please try again.');
                }
            });
        }


        // Permissions approve

        $(document).ready(function () {
            $('#PerTable').DataTable({
                ajax: {
                    url: 'principal_leave_back.php',
                    type: 'POST',
                    data: { action: 'get_PER_details' }
                },
                language: {
                    emptyTable: "No Permission data found",
                    loadingRecords: "No Permission data found",
                    zeroRecords: "No Permission data found"
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'uid' },
                    { data: 'name' },
                    { data: 'ltype' },
                    { data: 'fdate' },
                    { data: 'reason' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Store all necessary data as data attributes
                            return `
                <button class="btn btn-success approvePer-btn" 
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                    data-ltype="${row.ltype}"
                    data-fdate="${row.fdate}"
                   style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/accept.png" alt="View" style="width: 24px; height: 24px;">
                </button>
                <button class="btn btn-danger rejectPer-btn"
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                    data-ltype="${row.ltype}"
                    data-fdate="${row.fdate}"
                style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/reject.png" alt="Reject" style="width: 24px; height: 24px;">
                </button>
            `;
                        }
                    }
                ]
            });

            // Approve button click event
            $('#PerTable').on('click', '.approvePer-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid'),
                    ltype: button.data('ltype'),
                    fdate: button.data('fdate')
                };
                approvePER(leaveData);
            });

            // Reject button click event
            $('#PerTable').on('click', '.rejectPer-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid'),
                    ltype: button.data('ltype'),
                    fdate: button.data('fdate')
                };
                rejectPER(leaveData);
            });
        });

        function approvePER(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'approve_PER',
                    id: leaveData.id,
                    uid: leaveData.uid,
                    ltype: leaveData.ltype,
                    fdate: leaveData.fdate
                },
                success: function (response) {
                    $('#PerTable').DataTable().clear().draw();
                    $('#PerTable').DataTable().ajax.reload().draw();
                    showNotification('Permission approved successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.success('Permission approved successfully');
                },
                error: function (xhr, status, error) {
                    //console.error('Error approving Permission:', error);
                    showNotification('Error approving Permission. Please try again.', 'error');
                    // alert('Error approving Permission. Please try again.');
                }
            });
        }

        function rejectPER(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'reject_PER',
                    id: leaveData.id,
                    uid: leaveData.uid,
                    ltype: leaveData.ltype,
                    fdate: leaveData.fdate
                },
                success: function (response) {
                    $('#PerTable').DataTable().clear().draw();
                    $('#PerTable').DataTable().ajax.reload().draw();
                    showNotification('Permission rejected successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.error('Permission rejected successfully');
                },
                error: function (xhr, status, error) {
                    // console.error('Error rejecting Permission:', error);
                    showNotification('Error rejecting Permission. Please try again.', 'error');
                    // alert('Error rejecting Permission. Please try again.');
                }
            });
        }


        // COL approve

        $(document).ready(function () {
            $('#ColTable').DataTable({
                ajax: {
                    url: 'principal_leave_back.php',
                    type: 'POST',
                    data: { action: 'get_Col_details' }
                },
                language: {
                    emptyTable: "No COL data found",
                    loadingRecords: "No COL data found",
                    zeroRecords: "No COL data found"
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'uid' },
                    { data: 'name' },
                    { data: 'fdate' },
                    { data: 'reason' },
                    { data: 'intime' },
                    { data: 'outtime' },
                    { data: 'days' },

                    {
                        data: null,
                        render: function (data, type, row) {
                            // Store all necessary data as data attributes
                            return `
                <button class="btn btn-success approveCOL-btn" 
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                 style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/accept.png" alt="View" style="width: 24px; height: 24px;">
                </button>
                <button class="btn btn-danger rejectCOL-btn"
                    data-id="${row.id}"
                    data-uid="${row.uid}"
                   style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/reject.png" alt="Reject" style="width: 24px; height: 24px;">
                </button>
            `;
                        }
                    }
                ]
            });

            // Approve button click event
            $('#ColTable').on('click', '.approveCOL-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid')
                };
                approveCOL(leaveData);
            });

            // Reject button click event
            $('#ColTable').on('click', '.rejectCOL-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid')
                };
                rejectCOL(leaveData);
            });
        });

        function approveCOL(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'approve_COL',
                    id: leaveData.id,
                    uid: leaveData.uid
                },
                success: function (response) {
                    $('#ColTable').DataTable().clear().draw();
                    $('#ColTable').DataTable().ajax.reload().draw();
                    showNotification('COL Request approved successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.success('COL Request approved successfully');
                },
                error: function (xhr, status, error) {
                    // console.error('Error approving COL:', error);
                    showNotification('Error approving COL. Please try again', 'error');
                    // alert('Error approving COL. Please try again.');
                }
            });
        }

        function rejectCOL(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'reject_COL',
                    id: leaveData.id,
                    uid: leaveData.uid
                },
                success: function (response) {
                    $('#ColTable').DataTable().clear().draw();
                    $('#ColTable').DataTable().ajax.reload().draw();
                    showNotification('COL Request rejected successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.error('COL Request rejected successfully');
                },
                error: function (xhr, status, error) {
                    // console.error('Error rejecting COL:', error);
                    showNotification('Error rejecting COL. Please try again.', 'error');
                    // alert('Error rejecting COL. Please try again.');
                }
            });
        }


        // ODR approve

        $(document).ready(function () {
            $('#odrTable').DataTable({
                ajax: {
                    url: 'principal_leave_back.php',
                    type: 'POST',
                    data: { action: 'get_ODR_details' }
                },
                language: {
                    emptyTable: "No ODR data found",
                    loadingRecords: "No ODR data found",
                    zeroRecords: "No ODR data found"
                },
                columns: [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'uid' },
                    { data: 'name' },
                    { data: 'fdate' },
                    { data: 'tdate' },
                    { data: 'tdays' },
                    { data: 'reason' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Store all necessary data as data attributes
                            return `
                    <button class="btn btn-primary btn-sm view2_file_btn" data-file="../../../Files/uploads/ODR/${row.file}"  style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/eye.png" alt="View" style="width: 24px; height: 24px;">
                    </button>

                    <button class="btn approveODR-btn" 
                        data-id="${row.id}"
                        data-uid="${row.uid}"
                        style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/accept.png" alt="View" style="width: 24px; height: 24px;">
                    </button>
                    <button class="btn rejectODR-btn" 
                            data-id="${row.id}" 
                            data-uid="${row.uid}"
                            style="background: transparent; border: none; padding: 5px;">
                        <img src="../../images/icon/reject.png" alt="Reject" style="width: 24px; height: 24px;">
                    </button>
                `;
                        }
                    }
                ]
            });
            // Approve button click event
            $('#odrTable').on('click', '.approveODR-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid')
                };
                approveODR(leaveData);
            });

            // Reject button click event
            $('#odrTable').on('click', '.rejectODR-btn', function () {
                var button = $(this);
                var leaveData = {
                    id: button.data('id'),
                    uid: button.data('uid')
                };
                rejectODR(leaveData);
            });
        });


        function approveODR(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'approve_ODR',
                    id: leaveData.id,
                    uid: leaveData.uid
                },
                success: function (response) {
                    $('#odrTable').DataTable().clear().draw();
                    $('#odrTable').DataTable().ajax.reload().draw();
                    showNotification('ODR Request approved successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.success('ODR Request approved successfully');
                },
                error: function (xhr, status, error) {
                    // console.error('Error approving ODR:', error);
                    showNotification('Error approving ODR. Please try again.', 'error');
                    // alert('Error approving ODR. Please try again.');
                }
            });
        }

        function rejectODR(leaveData) {
            $.ajax({
                url: 'principal_leave_back.php',
                type: 'POST',
                data: {
                    action: 'reject_ODR',
                    id: leaveData.id,
                    uid: leaveData.uid
                },
                success: function (response) {
                    $('#odrTable').DataTable().clear().draw();
                    $('#odrTable').DataTable().ajax.reload().draw();
                    showNotification('ODR Request rejected successfully', 'success');
                    // alertify.set('notifier', 'position', 'top-right');
                    // alertify.error('ODR Request rejected successfully');
                },
                error: function (xhr, status, error) {
                    //console.error('Error rejecting ODR:', error);
                    showNotification('Error rejecting ODR. Please try again.', 'error');
                    //alert('Error rejecting ODR. Please try again.');
                }
            });
        }


        function showNotification(message, type) {
            Swal.fire({
                icon: type === 'success' ? 'success' : 'error',
                title: type === 'success' ? 'Success' : 'Error',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }



        function viewFile(filePath) {
            document.getElementById('fileViewer').src = filePath;
            $('#fileModal').modal('show');
        }
    </script>

    <!-- leave file view modal -->
    <div class="modal fade" id="fileViewModal_new" data-bs-backdrop="false" tabindex="-1"
        aria-labelledby="fileViewModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="max-width: 90%; width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileViewModalLabel">File View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="fileContent" class="text-center">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>