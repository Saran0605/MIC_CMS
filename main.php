<?php

include("config.php");
include("session.php");

//count total exp

$v=0;
$v2=0;
$de="Not availabe";
$year="";
$tf=0;
$tt=0;
                            
	$query = "select id, sum( datediff( ifnull(tod, now()) , fromd) +1 )AS value_sum from exp group by id having id='$s';";
	$query_run = mysqli_query($db, $query);
	if(mysqli_num_rows($query_run) > 0){
	$student = mysqli_fetch_assoc($query_run); 
	$sum=$student['value_sum'];
							
	$years = floor($sum / 365);
	$months = floor(($sum - ($years * 365))/30.5);
	$days = floor($sum - ($years * 365) - ($months * 30.5));
							
	$v= $years . " Years, " . $months . " Months, " . $days . " Days";

	}
//count mkce exp

	$query = "select id, sum(datediff(now() , doj) +1 )AS value_sum from faculty group by id having id='$s';";
	$query_run = mysqli_query($db, $query);
	if(mysqli_num_rows($query_run) > 0){
	$student = mysqli_fetch_assoc($query_run); 
	$sum=$student['value_sum'];							
	$years = floor($sum / 365);
	$months = floor(($sum - ($years * 365))/30.5);
	$days = floor($sum - ($years * 365) - ($months * 30.5));
							//echo "Days received: " . $sum . " days <br />";
	$v2= $years . " Years, " . $months . " Months, " . $days . " Days";
	}

//active days

	$query = "SELECT design,doj FROM faculty WHERE id='$s'";
    $query_run = mysqli_query($db, $query);
	if(mysqli_num_rows($query_run) > 0){
	$row = mysqli_fetch_assoc($query_run);
	$f=$row['doj'];
	
	if($f!="0000-00-00")
	{
    $year = date('Y', strtotime($f));
	$de=$row['design'];
	}
	else{
		$year = "";
		$de="Not availabe";
	}}
//total family members
	$query = "SELECT * FROM family where id='$s'";
    $query_run = mysqli_query($db, $query);

     if(mysqli_num_rows($query_run) > 0)
         {
			$tf=mysqli_num_rows($query_run)+1;
			}
			
			
//total Training
	$query = "SELECT * FROM training where id='$s'";
    $query_run = mysqli_query($db, $query);

     if(mysqli_num_rows($query_run) > 0)
         {
			$tt=mysqli_num_rows($query_run);
			}
	
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIC</title>
    <link rel="icon" type="image/png" sizes="32x32" href="image/icons/mkce_s.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-5/bootstrap-5.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
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

        td {
            text-align: left;
            font-size: 0.9em;
            vertical-align: middle;
            /* For vertical alignment */
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
            padding: 20px;
        }

        .card {
            min-height: 180px;
            /* Adjust the height as needed */
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

        .custom-gradient {
            background: linear-gradient(to bottom, rgb(255, 255, 255), #00f2fe);
            /* Vertical gradient */
            padding: 10px 15px;
            /* Adjust padding as needed */
            border-radius: 5px;
            /* Optional: Rounded corners */
        }

        .custom-table {
            border-radius: 10px;
        }

        .breadcrumb-area {
            background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin: 20px;
            padding: 15px 20px;
        }

        .breadcrumb {
            --bs-breadcrumb-padding-x: 0;
            --bs-breadcrumb-padding-y: 0;
            --bs-breadcrumb-margin-bottom: 1rem;
            --bs-breadcrumb-bg: ;
            --bs-breadcrumb-border-radius: ;
            --bs-breadcrumb-divider-color: var(--bs-secondary-color);
            --bs-breadcrumb-item-padding-x: 0.5rem;
            --bs-breadcrumb-item-active-color: var(--bs-secondary-color);
            display: flex;
            flex-wrap: wrap;
            padding: var(--bs-breadcrumb-padding-y) var(--bs-breadcrumb-padding-x);
            margin-bottom: var(--bs-breadcrumb-margin-bottom);
            font-size: var(--bs-breadcrumb-font-size);
            list-style: none;
            background-color: var(--bs-breadcrumb-bg);
            border-radius: var(--bs-breadcrumb-border-radius);
        }
    </style>

</head>

<body>
    <!-- Sidebar -->
    <?php include 'side.php'; ?>

    <!-- Main Content -->
    <div class="content">

        <div class="loader-container" id="loaderContainer">
            <div class="loader"></div>
        </div>

        <!-- Topbar -->
        <?php include 'ftopbar.php'; ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb-area custom-gradient">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">

                    <li class="breadcrumb-item active" aria-current="page">Dashboard (Welcome <?php echo $s; ?>)</li>
                </ol>
            </nav>
        </div>
        <!-- Content Area -->
        <div class="container-fluid">
            <div class="row">
                <!-- First Row: First Three Cards -->
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg">
                        <div class="card-body text-center bg-primary text-white">
                            <h1 class="font-light text-white"><i class="fa fa-user"></i></h1>
                            <h4><b>Total Experience</b></h4>
                            <h4><b><?php echo isset($v) ? $v : 'Data not available'; ?></b></h4>
                            
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg">
                        <div class="card-body text-center bg-success text-white">
                            <h1 class="font-light text-white"><i class="mdi mdi-calendar-check"></i></h1>
                            <h4><b>Active</b></h4>
                            <h4><b><?php echo isset($year) ? $year : 'N/A'; ?> - Current</b></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg">
                        <div class="card-body text-center bg-warning text-white">
                            <h1 class="font-light text-white">
                                <i class="mdi mdi-account-hard-hat"></i>
                            </h1>
                            <h4><b>Designation</b></h4>
                            <h4><b><?php echo isset($de) ? $de : 'Not Available'; ?></b></h4>
                        </div>
                    </div>
                </div>


                <!-- Second Row: Next Three Cards with Spacing -->
                <div class="row g-3 mt-4"> <!-- Added mt-4 for spacing -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-lg">
                            <div class="card-body text-center bg-danger text-white">
                                <h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
                                <h4><b>Total Experience in MKCE</b></h4>
                                <h4><b><?php echo isset($v2) ? $v2 : 'Not Available'; ?></b></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-lg">
                            <div class="card-body text-center bg-info text-white">
                                <h1 class="font-light text-white"><i class="mdi mdi-new-box"></i></h1>
                                <h4><b>Family Members</b></h4>
                                <h4><b><?php echo isset($tf) ? $tf : 'Not Available'; ?></b></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-lg">
                            <div class="card-body text-center bg-secondary text-white">
                                <h1 class="font-light text-white"><i class="mdi mdi-receipt"></i></h1>
                                <h4><b>Total Training</b></h4>
                                <h4><b><?php echo isset($tt) ? $tt : 'Not Available'; ?></b></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php

            //count basic		
            $query2 = "SELECT * FROM basic WHERE id='$s' AND photo=''";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $c = 25;
            } else {
                $c = 0.25;
            };


            $query2 = "SELECT * FROM academic WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $c1 = 0.25;
            } else {
                $c1 = 25;
            };


            $query2 = "SELECT * FROM family WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $c2 = 0.25;
            } else {
                $c2 = 25;
            };

            $query2 = "SELECT * FROM nominee WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $c3 = 0.25;
            } else {
                $c3 = 25;
            };
            $cf = $c1 + $c2 + $c3 + $c;


            //count academic			


            $query2 = "SELECT * FROM exp WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $d = 0.25;
            } else {
                $d = 25;
            };

            $query2 = "SELECT * FROM posting WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $d1 = 0.25;
            } else {
                $d1 = 25;
            };
            $query2 = "SELECT * FROM training WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $d2 = 0.25;
            } else {
                $d2 = 25;
            };

            $query2 = "SELECT * FROM research WHERE id='$s'";
            $query_run2 = mysqli_query($db, $query2);

            if (mysqli_num_rows($query_run2) == 0) {
                $d3 = 0.25;
            } else {
                $d3 = 25;
            };
            $cd = $d1 + $d2 + $d3 + $d;

            $querybc = "INSERT INTO faculty(bc,ac) VALUES('$cf','$cd')";
            $querybc = "UPDATE faculty SET bc='$cf',ac='$cd' WHERE id='$s'";
            $query_runbc = mysqli_query($db, $querybc);
            ?>
            <!-- ============================================================== -->
            <!-- Recent comment and chats -->
            <!-- ============================================================== -->

            <!-- Progress Box -->
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Progress Overview</h4>

                            <!-- Basic Profile Progress -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold">Basic Profile</span>
                                    <span class="badge bg-primary float-animation"><?php echo $cf; ?>%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar"
                                        style="width: <?php echo $cf; ?>%"
                                        aria-valuenow="<?php echo $cf; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Profile Progress -->
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold">Academic Profile</span>
                                    <span class="badge bg-primary float-animation"><?php echo $cd; ?>%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar"
                                        style="width: <?php echo $cd; ?>%"
                                        aria-valuenow="<?php echo $cd; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

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
            document.addEventListener('DOMContentLoaded', function() {
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
                window.onload = function() {
                    clearTimeout(loadingTimeout);

                    // Add a small delay to ensure smooth transition
                    setTimeout(hideLoader, 500);
                };

                // Error handling
                window.onerror = function(msg, url, lineNo, columnNo, error) {
                    clearTimeout(loadingTimeout);
                    showError();
                    return false;
                };
            });

            document.addEventListener("DOMContentLoaded", function() {
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

</body>

</html>