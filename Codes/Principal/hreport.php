<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #20bf55 0%, #01baef 100%);
            border: none;
        }

        .status-btn {
            border: none;

            color: white;
            font-weight: 500;
        } 

        .status-pending {
            background: #ffc107;
        }

        .status-forwarded {
            background: #007bff;
        }

        .status-approved {
            background: #28a745;
        }

        .status-rejected {
            background: #6c757d;
        }

        .nav-tabs .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            border: none;
        }

/* Tab style */

        #attendance-tab {
            background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
            color: #fff;
        }

        #attendance-tab:not(.active) {
            background: #fff;
            color: #FF6B6B;
        }

        #attendance-tab:hover:not(.active) {
            background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
            color: #fff;
        }



        #leave-tab {
            background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
            color: #fff;
        }

        #leave-tab:not(.active) {
            background: #fff;
            color: #4E65FF;
        }

        #leave-tab:hover:not(.active) {
            background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
            color: #fff;
        }

        /* icon style */

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

        /* Table style */

        .table {
            width: 100% !important;
        }

        .table thead tr {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        #attendanceTable2 th,
        #leaveTable2 th
        {
            background: none;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: white;
            text-align: center;
        }

        #attendanceTable2 td,
        #leaveTable2 td{
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance"
                    type="button" role="tab">
                    <i class="fas fa-calendar-check me-2 tab-icon"></i>Attendance Report
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="leave-tab" data-bs-toggle="tab" data-bs-target="#leave" type="button"
                    role="tab">
                    <i class="fas fa-calendar-times me-2 tab-icon"></i>Leave Report
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Attendance Report Tab -->
            <div class="tab-pane fade show active" id="attendance" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form id="attendanceForm2">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Month</label>
                                        <input type="number" name="month" min="1" max="12" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-calendar-check me-2"></i>Year</label>
                                        <input type="number" name="year" min="2023" max="2030" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-sync-alt me-2"></i>Generate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="attendanceReport" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <button id="downloadAttendance" class="btn btn-success">
                                    <i class="fas fa-download me-2"></i>Download Report
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="attendanceTable2" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Total Days</th>
                                            <th>Working Days</th>
                                            <th>Holidays</th>
                                            <th>Present</th>
                                            <th>LOP</th>
                                            <th>Salary Day</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Report Tab -->
            <div class="tab-pane fade" id="leave" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <form id="leaveForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Month</label>
                                        <input type="number" name="month" min="1" max="12" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-calendar-check me-2"></i>Year</label>
                                        <input type="number" name="year" min="2023" max="2030" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-list-alt me-2"></i>Leave Type</label>
                                        <select name="leaveType" class="form-control" required>
                                            <option value="CL">CL</option>
                                            <option value="COL Request">COL Request</option>
                                            <option value="OD">OD</option>
                                            <option value="Permission">Permission</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-sync-alt me-2"></i>Generate
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="leaveReport" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="leaveTable2" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Type</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Scripts -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            let attendanceTable2;
            let attendanceData = [];

            // Initialize current date values
            const currentDate = new Date();
            $('input[name="month"]').val(currentDate.getMonth() + 1);
            $('input[name="year"]').val(currentDate.getFullYear());

            // Attendance Report Handling
            $('#attendanceForm2').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: 'principal_leave_back.php',
                    method: 'POST',
                    data: {
                        action: 'get_sreport_details',
                        month: formData.get('month'),
                        year: formData.get('year')
                    },
                    success: function (response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.status === 200) {
                            attendanceData = response.data;
                            populateAttendanceTable(attendanceData);
                            $('#attendanceReport').fadeIn();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to fetch data',
                                icon: 'error',
                                confirmButtonColor: '#6B73FF'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to generate report',
                            icon: 'error',
                            confirmButtonColor: '#6B73FF'
                        });
                    }
                });
            });

            function populateAttendanceTable(data) {
                // Destroy existing DataTable if it exists
                if ($.fn.DataTable.isDataTable('#attendanceTable2')) {
                    $('#attendanceTable2').DataTable().destroy();
                }

                // Clear the table body
                $('#attendanceTable2 tbody').empty();

                // Add rows to the table
                data.forEach((item, index) => {
                    $('#attendanceTable2 tbody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.uid}</td>
                            <td>${item.facultyName}</td>
                            <td>${item.facultyRole}</td>
                            <td>${item.totalDays}</td>
                            <td>${item.totalWorkingDays}</td>
                            <td>${item.totalHolidays}</td>
                            <td>${item.totalPresentdays}</td>
                            <td>${item.totalLopdays}</td>
                            <td>${item.salaryDay}</td>
                        </tr>
                    `);
                });

                // Initialize DataTable
                attendanceTable2 = $('#attendanceTable2').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: "",
                        searchPlaceholder: "Search..."
                    }
                });
            }

            $('#downloadAttendance').on('click', function () {
                if (!attendanceData.length) {
                    Swal.fire({
                        title: 'No Data',
                        text: 'No data available to download',
                        icon: 'warning',
                        confirmButtonColor: '#6B73FF'
                    });
                    return;
                }

                const ws = XLSX.utils.json_to_sheet(
                    attendanceData.map(data => ({
                        'UID': data.uid,
                        'Name': data.facultyName,
                        'Role': data.facultyRole,
                        'Total Days': data.totalDays,
                        'Working Days': data.totalWorkingDays,
                        'Holidays': data.totalHolidays,
                        'Present': data.totalPresentdays,
                        'LOP': data.totalLopdays,
                        'Salary Day': data.salaryDay
                    }))
                );

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Attendance Report');
                XLSX.writeFile(wb, 'attendance_report.xlsx');
            });

            // Leave Report Handling
            let leaveTable2;

            function getStatusButton(status) {
                const statusMap = {
                    0: { text: 'Pending', class: 'status-pending' },
                    1: { text: 'Forwarded to HR', class: 'status-forwarded' },
                    2: { text: 'Approved', class: 'status-approved' },
                    default: { text: 'Rejected', class: 'status-rejected' }
                };
                const statusInfo = statusMap[parseInt(status)] || statusMap.default;
                return `<button class="status-btn btn-sm ${statusInfo.class}">${statusInfo.text}</button>`;
            }

            function getLeaveTableColumns(leaveType) {
                const columns = [
                    {
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    { data: 'uid' },
                    { data: 'name' }
                ];

                switch (leaveType) {
                    case 'CL':
                    case 'OD':
                        columns.push(
                            { data: 'fdate' },
                            { data: 'tdate' },
                            { data: leaveType === 'CL' ? 'ltype' : 'otype' },
                            { data: 'reason' }
                        );
                        break;
                    case 'COL Request':
                        columns.push(
                            { data: 'fdate', title: 'Date' },
                            { data: 'intime', title: 'In Time' },
                            { data: 'outtime', title: 'Out Time' },
                            { data: 'reason' }
                        );
                        break;
                    case 'Permission':
                        columns.push(
                            { data: 'fdate', title: 'Date' },
                            { data: 'ltype', title: 'Type' },
                            { data: null, defaultContent: '-' },  // Empty 'To' column
                            { data: 'reason' }
                        );
                        break;
                }

                columns.push({
                    data: 'status',
                    render: (data) => getStatusButton(data)
                });

                return columns;
            }

            function updateTableHeaders(leaveType) {
                const table = $('#leaveTable2');
                const thead = table.find('thead tr');
                thead.empty();

                // Common headers
                thead.append(`
                    <th>S.No</th>
                    <th>ID</th>
                    <th>Name</th>
                `);

                // Type-specific headers
                switch (leaveType) {
                    case 'CL':
                    case 'OD':
                        thead.append(`
                            <th>From</th>
                            <th>To</th>
                            <th>Type</th>
                            <th>Reason</th>
                        `);
                        break;
                    case 'COL Request':
                        thead.append(`
                            <th>Date</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Reason</th>
                        `);
                        break;
                    case 'Permission':
                        thead.append(`
                            <th>Date</th>
                            <th>Type</th>
                            <th>Reason</th>
                        `);
                        break;
                }

                // Status header (common for all)
                thead.append('<th>Status</th>');
            }

            $('#leaveForm').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const leaveType = formData.get('leaveType');

                $.ajax({
                    url: 'principal_leave_back.php',
                    method: 'POST',
                    data: {
                        action: 'get_lreport_details',
                        month: formData.get('month'),
                        year: formData.get('year'),
                        ltype: leaveType
                    },
                    success: function (response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.status === 200) {
                            // Update table headers based on leave type
                            updateTableHeaders(leaveType);

                            // Destroy existing DataTable if it exists
                            if ($.fn.DataTable.isDataTable('#leaveTable2')) {
                                $('#leaveTable2').DataTable().destroy();
                            }

                            // Clear the table body
                            $('#leaveTable2 tbody').empty();

                            // Initialize DataTable with the new data
                            leaveTable2 = $('#leaveTable2').DataTable({
                                data: response.data.data,
                                columns: getLeaveTableColumns(leaveType),
                                responsive: true,
                                pageLength: 10,
                                language: {
                                    search: "",
                                    searchPlaceholder: "Search..."
                                }
                            });

                            $('#leaveReport').show();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to fetch data',
                                icon: 'error',
                                confirmButtonColor: '#6B73FF'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to generate report',
                            icon: 'error',
                            confirmButtonColor: '#6B73FF'
                        });
                    }
                });
            });

            // Initialize date values for leave form
            $('form#leaveForm input[name="month"]').val(currentDate.getMonth() + 1);
            $('form#leaveForm input[name="year"]').val(currentDate.getFullYear());
        });
    </script>
</body>

</html>