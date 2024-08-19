@extends('Backend/layouts/master')

@section('title', 'Dashboard')

@section('page-script')
    <script src="{{ asset('assets/backend/js/pages/dashboard.js')}}"></script>
    <script>
        $(function () {
            'use strict'

            // Area Chart
            var revenueChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
            var revenueChartData = {
                labels: @json($orderDates),
                datasets: [
                    {
                        label: 'Order Amounts',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($orderAmountsByDate)
                    }
                ]
            };

            var revenueChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            };

            new Chart(revenueChartCanvas, {
                type: 'line',
                data: revenueChartData,
                options: revenueChartOptions
            });

            // Donut Chart
            var salesChartCanvas = document.getElementById('sales-chart-canvas').getContext('2d');
            var salesChartData = {
                labels: @json($salesLabels),
                datasets: [
                    {
                        data: @json($salesAmounts),
                        backgroundColor: ['#f56954', '#00a65a', '#f39c12']
                    }
                ]
            };

            var salesChartOptions = {
                legend: {
                    display: false
                },
                maintainAspectRatio: false,
                responsive: true
            };

            new Chart(salesChartCanvas, {
                type: 'doughnut',
                data: salesChartData,
                options: salesChartOptions
            });
        });
    </script>
    <script>
        $(function () {
            'use strict'

            // Sales Graph Chart
            var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');

            var salesGraphChartData = {
                labels: @json($orderMonths), // Use monthly data here
                datasets: [
                    {
                        label: 'Sales Amount',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: '#efefef',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: @json($orderAmounts) // Use amounts data here
                    }
                ]
            };

            var salesGraphChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: '#efefef'
                        },
                        gridLines: {
                            display: false,
                            color: '#efefef',
                            drawBorder: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 5000,
                            fontColor: '#efefef'
                        },
                        gridLines: {
                            display: true,
                            color: '#efefef',
                            drawBorder: false
                        }
                    }]
                }
            };

            new Chart(salesGraphChartCanvas, {
                type: 'line',
                data: salesGraphChartData,
                options: salesGraphChartOptions
            });

            // Sales by Gateway Chart
            var salesPieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d');

            var salesPieData = {
                labels: @json($salesLabels),
                datasets: [
                    {
                        data: @json($salesAmounts),
                        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
                        borderColor: '#ffffff',
                        borderWidth: 1
                    }
                ]
            };

            var salesPieOptions = {
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                responsive: true
            };

            new Chart(salesPieChartCanvas, {
                type: 'doughnut',
                data: salesPieData,
                options: salesPieOptions
            });
        });
    </script>
    <script>
        function updateStats() {
            var period = document.getElementById('timePeriod').value;
            $.ajax({
                url: "{{ route('backend.home.getStats') }}",
                type: "GET",
                data: { period: period },
                success: function (data) {
                    $('#stats-boxes').html(data);
                }
            });
        }
    </script>
    <script>
        function addTask() {
            const taskData = {
                task: document.getElementById('taskName').value,
                due_date: document.getElementById('dueDate').value,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "{{ route('backend.home.addToDo') }}",
                method: 'POST',
                data: taskData,
                success: function (response) {
                    // Function to format the date
                    function formatDate(dateString) {
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        return new Date(dateString).toLocaleDateString(undefined, options);
                    }

                    // Determine the appropriate badge color and text based on due date
                    let badgeClass = response.due_date ? 'danger' : 'secondary';
                    let dueDateText = response.due_date ? formatDate(response.due_date) : 'No deadline';

                    // Append the new task to the to-do list
                    $('#todo-list').append(`
                        <li data-id="${response.id}">
                            <span class="handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" id="todoCheck${response.id}" onchange="toggleStatus(${response.id})">
                                <label for="todoCheck${response.id}"></label>
                            </div>
                            <span class="text">${response.task}</span>
                            <small class="badge badge-${badgeClass}">
                                <i class="far fa-clock"></i>
                                ${dueDateText}
                            </small>
                            <div class="tools">
                                <i class="fas fa-edit" onclick="editTask(${response.id})"></i>
                                <i class="fas fa-trash-o" onclick="deleteTask(${response.id})"></i>
                            </div>
                        </li>
                    `);

                    // Hide the modal after adding the task
                    $('#addTaskModal').modal('hide');

                    // Optionally, reset the form fields in the modal
                    $('#addTaskForm')[0].reset();
                },
                error: function (error) {
                    console.error('Error adding task:', error);
                    // Handle error (e.g., show error message to the user)
                }
            });

        }

        function toggleStatus(id) {
            const status = $(`#todoCheck${id}`).is(':checked') ? 'completed' : 'pending';
            $url = `{{ route('backend.home.updateToDo.status', ':toDo') }}`;
            $.ajax({
                url: $url.replace(':toDo', id),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function () {
                    // Update the task status if needed
                }
            });
        }

        function deleteTask(id) {

            // confirm alert
            if (!confirm('Are you sure you want to delete this task?')) {
                return;
            }

            $url = `{{ route('backend.home.deleteToDo', ':toDo') }}`;
            $.ajax({
                url: $url.replace(':toDo', id),
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    $(`li[data-id='${id}']`).remove();
                }
            });
        }

        function editTask(id) {
            // You can open a modal or another interface to edit the task
            // Use similar AJAX logic as above to update the task
        }
    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Dropdown Menu to Select Time Period -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select id="timePeriod" class="form-control" onchange="updateStats()">
                                <option value="day">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Small boxes (Stat box) -->
                <div id="stats-boxes">
                    @include('Backend.pages.home.partials.stats', ['array' => $array])
                </div>
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">
                        <!-- Custom tabs (Charts with tabs) -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Sales
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    <!-- Area Chart -->
                                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                        <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                    </div>
                                    <!-- Donut Chart -->
                                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                        <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->


                        <!-- TO DO List -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    To Do List
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul id="todo-list" class="todo-list" data-widget="todo-list">
                                    @foreach ($toDos as $toDo)
                                        <li data-id="{{ $toDo->id }}">
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                            <!-- checkbox -->
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" id="todoCheck{{ $toDo->id }}" {{ $toDo->status === 'completed' ? 'checked' : '' }} onchange="toggleStatus({{ $toDo->id }})">
                                                <label for="todoCheck{{ $toDo->id }}"></label>
                                            </div>
                                            <!-- todo text -->
                                            <span class="text">{{ $toDo->task }}</span>
                                            <!-- Emphasis label -->
                                            <small class="badge badge-{{ $toDo->due_date ? 'danger' : 'secondary' }}">
                                                <i class="far fa-clock"></i>
                                                {{ $toDo->due_date ? $toDo->due_date->diffForHumans() : 'No deadline' }}
                                            </small>
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <i class="fas fa-trash-o" onclick="deleteTask({{ $toDo->id }})">
                                                    Delete
                                                </i>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTaskModal"><i class="fas fa-plus"></i> Add item</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">
                        <!-- solid sales graph -->
                        <div class="card bg-gradient-info">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-th mr-1"></i>
                                    Sales Graph
                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="line-chart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <input type="text" class="knob" data-readonly="true" value="{{ $array['newOrders'] }}"
                                            data-width="60" data-height="60" data-fgColor="#39CCCC">
                                        <div class="text-white">New Orders</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-6 text-center">
                                        <input type="text" class="knob" data-readonly="true" value="{{ $array['totalSales'] }}"
                                            data-width="60" data-height="60" data-fgColor="#39CCCC">
                                        <div class="text-white">Total Sales</div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->

                        <!-- Calendar -->
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">

                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i>
                                    Calendar
                                </h3>
                                <!-- tools card -->
                                <div class="card-tools">
                                    <!-- button with a dropdown -->
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body pt-0">
                                <!--The calendar -->
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>

        <!-- Add Task Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTaskForm">
                            <div class="mb-3">
                                <label for="taskName" class="form-label">Task Name</label>
                                <input type="text" class="form-control" id="taskName" name="task">
                            </div>
                            <div class="mb-3">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="datetime-local" class="form-control" id="dueDate" name="due_date">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addTask()">Add Task</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection
