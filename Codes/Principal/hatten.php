<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            --secondary-gradient: linear-gradient(135deg, #FF6B6B 0%, #FF000D 100%);
        }


        .container {
            max-width: 1400px;
            padding: 2rem;
        }


        .form-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6B73FF;
            box-shadow: 0 0 0 0.2rem rgba(107, 115, 255, 0.25);
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-generate {
            background: var(--primary-gradient);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(107, 115, 255, 0.3);
        }

        .btn-export {
            background: #28a745;
            color: white;
            border: none;
            margin-left: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 115, 255, 0.4);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* .nav-tabs {
            border: none;
            margin-bottom: 1.5rem;
            gap: 1rem;
            display: flex;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 115, 255, 0.3);
        } */

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 500;
        }

        .status-cell {
            padding: 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            min-width: 45px;
        }

        .status-H {
            background-color: #90caf9;
            color: #1565c0;
        }

        .status-MP {
            background-color: #a5d6a7;
            color: #2e7d32;
        }

        .status-AB {
            background-color: #ef9a9a;
            color: #c62828;
        }

        .status-P {
            background-color: #81c784;
            color: #2e7d32;
        }

        .status-S {
            background-color: #fff59d;
            color: #f57f17;
        }

        .status-L {
            background-color: #ce93d8;
            color: #6a1b9a;
        }

        .time-info {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            opacity: 0.8;
        }

        .work-hours {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            color: #2196f3;
            font-weight: 500;
        }

        .individual-view {
            max-height: 70vh;
            overflow-y: auto;
        }

        .individual-day {
            background: #fff;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #6B73FF;
        }

        .day-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .individual-status {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: 500;
        }

        #individualSearch {
            margin-bottom: 1rem;
        }

        .export-toolbar {
            margin-bottom: 1rem;
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>

<body>
<div class="container-fluid">
        <div class="form-container">
            <form id="attendanceForm" class="report-form">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="month" class="form-label">Month</label>
                            <input type="number" id="month" name="month" min="1" max="12" class="form-control"
                                placeholder="Enter month (1-12)" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" id="year" name="year" min="2023" max="2030" class="form-control"
                                placeholder="Enter year" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt me-2"></i>Generate Report
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="tableContainer" class="card" style="display: none;">
            <div class="card-body">
                <!-- Updated Nav Tabs for Bootstrap 5 -->
                <ul class="nav nav-tabs mb-3" id="attendanceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="status-tab" data-bs-toggle="tab" data-bs-target="#status" 
                            type="button" role="tab" aria-controls="status" aria-selected="true">
                            <i class="fas fa-list-alt me-2"></i>Status
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="detailed-tab" data-bs-toggle="tab" data-bs-target="#detailed" 
                            type="button" role="tab" aria-controls="detailed" aria-selected="false">
                            <i class="fas fa-clock me-2"></i>Status with IN/OUT
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" 
                            type="button" role="tab" aria-controls="individual" aria-selected="false">
                            <i class="fas fa-user me-2"></i>Individual View
                        </button>
                    </li>
                </ul>

                <div class="export-toolbar py-4">
                    <button class="btn btn-success" id="exportBtn">
                        <i class="fas fa-file-excel me-2"></i>Export to Excel
                    </button>
                </div>

                <!-- Updated Tab Content for Bootstrap 5 -->
                <div class="tab-content" id="attendanceTabContent">
                    <div class="tab-pane fade show active" id="status" role="tabpanel" aria-labelledby="status-tab">
                        <div id="attendanceTableWrapper">
                            <table id="attendanceTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
                        <div id="detailedTableWrapper">
                            <table id="detailedTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                        <div class="form-group">
                            <input type="text" id="individualSearch" class="form-control" placeholder="Enter Staff UID">
                        </div>
                        <div id="individualData" class="individual-view">
                            <!-- Individual data will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       $(document).ready(function () {
    let statusTable, detailedTable;
    let currentMonth, currentYear;
    let currentView = 'status';
    let attendanceData = [];

    function calculateWorkHours(inTime, outTime) {
        if (!inTime || !outTime) return null;

        const [inHour, inMin] = inTime.split(':').map(Number);
        const [outHour, outMin] = outTime.split(':').map(Number);

        let hours = outHour - inHour;
        let minutes = outMin - inMin;

        if (minutes < 0) {
            hours--;
            minutes += 60;
        }

        return hours + (minutes / 60);
    }

    function formatWorkHours(hours) {
        if (hours === null) return '';
        const wholeHours = Math.floor(hours);
        const minutes = Math.round((hours - wholeHours) * 60);
        return `${wholeHours}h ${minutes}m`;
    }

    function formatTime(timeStr) {
        if (!timeStr) return '';
        return timeStr.split(':').slice(0, 2).join(':');
    }

    function renderCell(attendance, viewType) {
        if (!attendance) return '';

        const status = attendance.status;
        const inTime = formatTime(attendance.in_time);
        const outTime = formatTime(attendance.out_time);
        const workHours = calculateWorkHours(attendance.in_time, attendance.out_time);

        return `
            <div class="status-cell status-${status}">
                ${status}
                ${viewType === 'detailed' && (inTime || outTime) ?
                `<div class="time-info">
                        ${inTime ? `<i class="fas fa-sign-in-alt me-1"></i>${inTime}` : ''}
                        ${outTime ? `<br><i class="fas fa-sign-out-alt me-1"></i>${outTime}` : ''}
                        ${workHours ? `<div class="work-hours"><i class="fas fa-business-time me-1"></i>${formatWorkHours(workHours)}</div>` : ''}
                    </div>` :
                ''}
            </div>
        `;
    }

    function renderIndividualView(uid) {
        const employee = attendanceData.find(emp => emp.uid === uid);
        if (!employee) {
            $('#individualData').html('<div class="alert alert-warning">No data found for this UID</div>');
            return;
        }

        let html = `<h4 class="mb-4">${employee.name} (${employee.uid})</h4>`;

        employee.attendance.forEach((day, index) => {
            if (day) {
                const inTime = formatTime(day.in_time);
                const outTime = formatTime(day.out_time);
                const workHours = calculateWorkHours(day.in_time, day.out_time);

                html += `
                    <div class="individual-day mb-3 p-3 border rounded">
                        <div class="day-header d-flex justify-content-between align-items-center mb-2">
                            <strong>Day ${index + 1}</strong>
                            <span class="individual-status status-${day.status}">${day.status}</span>
                        </div>
                        <div class="time-info">
                            ${inTime ? `<div><i class="fas fa-sign-in-alt me-2 text-primary"></i>In: ${inTime}</div>` : ''}
                            ${outTime ? `<div><i class="fas fa-sign-out-alt me-2 text-danger"></i>Out: ${outTime}</div>` : ''}
                            ${workHours ? `<div class="work-hours"><i class="fas fa-business-time me-2"></i>Working Hours: ${formatWorkHours(workHours)}</div>` : ''}
                        </div>
                    </div>
                `;
            }
        });

        $('#individualData').html(html);
    }

    function initializeTable(viewType, data, month, year) {
        const daysInMonth = new Date(year, month, 0).getDate();
        attendanceData = data;

        const columns = [
            { data: 'uid', width: '100px' },
            { data: 'name', width: '180px' }
        ];

        for (let i = 1; i <= daysInMonth; i++) {
            columns.push({
                data: null,
                width: viewType === 'detailed' ? '200px' : '160px',
                render: function (row) {
                    return renderCell(row.attendance[i - 1], viewType);
                }
            });
        }

        const tableId = viewType === 'detailed' ? '#detailedTable' : '#attendanceTable';
        if (viewType === 'status' && statusTable) {
            statusTable.destroy();
            $('#attendanceTable thead tr th:gt(1)').remove();
        } else if (viewType === 'detailed' && detailedTable) {
            detailedTable.destroy();
            $('#detailedTable thead tr th:gt(1)').remove();
        }

        const headerRow = $(`${tableId} thead tr`);
        for (let i = 1; i <= daysInMonth; i++) {
            headerRow.append(`<th>${i}</th>`);
        }

        const tableConfig = {
            data: data,
            columns: columns,
            scrollX: true,
            scrollY: '160vh',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 25,
            fixedColumns: {
                leftColumns: 2
            },
            dom: '<"top"f>rt<"bottom"ip>',
            language: {
                search: '<i class="fas fa-search"></i> Search:',
                emptyTable: '<div class="text-center py-4"><i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i><br>No attendance data available</div>'
            }
        };

        if (viewType === 'detailed') {
            detailedTable = $(tableId).DataTable(tableConfig);
        } else {
            statusTable = $(tableId).DataTable(tableConfig);
        }
    }

    function exportToExcel() {
        if (!attendanceData || attendanceData.length === 0) {
            alert('No data available to export');
            return;
        }

        const wb = XLSX.utils.book_new();

        // Convert main table data
        const mainTableData = attendanceData.map(row => {
            const rowData = {
                UID: row.uid,
                Name: row.name
            };

            row.attendance.forEach((day, index) => {
                if (day) {
                    rowData[`Day ${index + 1}`] = `${day.status}${day.in_time ? ' (In: ' + formatTime(day.in_time) + ')' : ''}${day.out_time ? ' (Out: ' + formatTime(day.out_time) + ')' : ''}`;
                } else {
                    rowData[`Day ${index + 1}`] = '';
                }
            });

            return rowData;
        });

        const ws = XLSX.utils.json_to_sheet(mainTableData);
        XLSX.utils.book_append_sheet(wb, ws, "Attendance Overview");

        // Add individual sheets for each employee
        attendanceData.forEach(employee => {
            const individualData = employee.attendance.map((day, index) => {
                if (day) {
                    const workHours = calculateWorkHours(day.in_time, day.out_time);
                    return {
                        Date: `Day ${index + 1}`,
                        Status: day.status,
                        'In Time': formatTime(day.in_time) || '-',
                        'Out Time': formatTime(day.out_time) || '-',
                        'Working Hours': workHours ? formatWorkHours(workHours) : '-'
                    };
                }
                return null;
            }).filter(Boolean);

            const ws = XLSX.utils.json_to_sheet(individualData);
            XLSX.utils.book_append_sheet(wb, ws, `${employee.uid}_${employee.name.substring(0, 10)}`);
        });

        const filename = `Attendance_Report_${currentMonth}_${currentYear}.xlsx`;
        XLSX.writeFile(wb, filename);
    }

    // Event Listeners
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(button => {
        button.addEventListener('click', function (event) {
            const targetView = this.getAttribute('data-bs-target').replace('#', '');
            currentView = targetView;

            if (currentView === 'individual') {
                $('#attendanceTableWrapper, #detailedTableWrapper').hide();
                $('#individualView').show();
            } else {
                $('#individualView').hide();
                if (currentView === 'status') {
                    $('#attendanceTableWrapper').show();
                    $('#detailedTableWrapper').hide();
                    if (attendanceData.length > 0) {
                        initializeTable('status', attendanceData, currentMonth, currentYear);
                    }
                } else if (currentView === 'detailed') {
                    $('#detailedTableWrapper').show();
                    $('#attendanceTableWrapper').hide();
                    if (attendanceData.length > 0) {
                        initializeTable('detailed', attendanceData, currentMonth, currentYear);
                    }
                }
            }
        });
    });

    $('#individualSearch').on('input', function () {
        const uid = $(this).val().trim();
        if (uid) {
            renderIndividualView(uid);
        } else {
            $('#individualData').html('<div class="alert alert-info">Enter a Staff UID to view their attendance details</div>');
        }
    });

    $('#exportBtn').on('click', exportToExcel);

    $('#attendanceForm').on('submit', function (e) {
        e.preventDefault();

        currentMonth = parseInt($('input[name="month"]').val());
        currentYear = parseInt($('input[name="year"]').val());

        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Generating...').prop('disabled', true);

        $.ajax({
            url: 'principal_leave_back.php',
            method: 'POST',
            data: {
                action: 'get_areport_details',
                month: currentMonth,
                year: currentYear
            },
            success: function (response) {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                if (response.status === 200 && Array.isArray(response.data)) {
                    $('#tableContainer').fadeIn();
                    initializeTable(currentView, response.data, currentMonth, currentYear);
                } else {
                    console.error('Invalid response format:', response);
                    alert('Error: Invalid data format received from server');
                }
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
                alert('Error fetching attendance data. Please try again.');
            },
            complete: function () {
                submitBtn.html('<i class="fas fa-sync-alt me-2"></i>Generate Report').prop('disabled', false);
            }
        });
    });
});
    </script>
</body>

</html>