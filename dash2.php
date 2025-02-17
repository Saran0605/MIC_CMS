<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <style>
        #dashboard-cards{
            padding:20px;
        }
        .card-hover {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .stat-card {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .stat-card .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .stat-card h4 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .count {
            font-size: 1.0rem;
            font-weight: bold;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
</head>

<body>
    <!-- <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div> -->



    <div class="container-fluid mt-4">
      
        <div class="row" id="dashboard-cards">
            <!-- Cards will be dynamically inserted here -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        $(document).ready(function () {
            const departmentColors = {
                total: 'primary',
                aids: '#8b66e8',
                aiml: '#dc8f20',
                civil: '#657451',
                csbs: '#584759',
                cse: '#00cc99',
                eee: '#cc00ff',
                eev: '#4b3910',
                ece: '#669900',
                it: '#cc3300',
                mech: '#ff6699',
                mba: '#996633',
                mca: '#006666',
                sh: '#ff0066'
            };

            const departmentNames = {
                aids: 'Artificial Intelligence and Data Science',
                aiml: 'Artificial Intelligence and Machine Learning',
                civil: 'Civil Engineering',
                csbs: 'Computer Science and Business Systems',
                cse: 'Computer Science and Engineering',
                eee: 'Electrical and Electronics Engineering',
                eev: 'Electronics Engineering (VLSI Design)',
                ece: 'Electronics and Communication Engineering',
                it: 'Information Technology',
                mech: 'Mechanical Engineering',
                mba: 'Master of Business Administration',
                mca: 'Master of Computer Applications',
                sh: 'Freshman Engineering'
            };

            function createCard(title, count, color, icon = 'fa-users', delay = 0) {
                return `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card stat-card card-hover fade-in" 
                     style="animation-delay: ${delay}ms; background-color: ${color}; color: white;">
                    <div class="card-body text-center">
                        <div class="icon">
                            <i class="fas ${icon}"></i>
                        </div>
                        <h4 class="card-title">${title}</h4>
                        <div class="count">${count}</div>
                    </div>
                </div>
            </div>
        `;
            }

            function refreshDashboard() {
                $.ajax({
                    url: 'hradmin_back.php',
                    method: 'GET',
                    data: { action: 'get_dash_data' },
                    success: function (response) {
                        if (typeof response === 'string') {
                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                console.error('Error parsing JSON:', e);
                                alert('Error loading dashboard data. Please try again.');
                                return;
                            }
                        }

                        $('#faculty-name').text(response.name);
                        let dashboardHtml = '';
                        let delay = 0;

                        // Total Faculty Card
                        dashboardHtml += createCard(
                            'Total Faculty',
                            response.total_faculty,
                            '#0d6efd',
                            'fa-users',
                            delay
                        );
                        delay += 100;

                        // Department Cards
                        Object.entries(response.departments).forEach(([dept, count]) => {
                            if (departmentNames[dept]) {
                                dashboardHtml += createCard(
                                    departmentNames[dept],
                                    count,
                                    departmentColors[dept],
                                    'fa-graduation-cap',
                                    delay
                                );
                                delay += 100;
                            }
                        });

                        // Gender Statistics Card
                        const genderHtml = `Male: ${response.gender.male} | Female: ${response.gender.female} | Others: ${response.gender.others}`;
                        dashboardHtml += createCard(
                            'Gender Distribution',
                            genderHtml,
                            '#212529',
                            'fa-venus-mars',
                            delay
                        );

                        $('#dashboard-cards').html(dashboardHtml);
                        $('.loading-spinner').fadeOut();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching dashboard data:', error);
                        $('.loading-spinner').fadeOut();
                        alert('Error loading dashboard data. Please try again.');
                    }
                });
            }

            // Initial load
            refreshDashboard();

            // Refresh every 5 minutes
            setInterval(refreshDashboard, 300000);
        });
    </script>
</body>

</html>