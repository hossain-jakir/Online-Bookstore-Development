@extends('Backend.layouts.master')

@section('title', 'Transaction History')

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Shop</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Shop</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-history mr-2"></i> Transaction History</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="transactions-table" class="table table-bordered table-striped mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Gateway</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate this -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('page-script')
<script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let table = $('#transactions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backend.transaction.getTransactions') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type', name: 'type' },
                { data: 'gateway', name: 'gateway' },
                { data: 'amount', name: 'amount' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' }
            ],
            order: [[6, 'desc']],
            responsive: true,
            autoWidth: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'btn btn-light btn-sm'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    className: 'btn btn-light btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-light btn-sm'
                },
            ],
        });

        // Custom buttons
        $('#copyBtn').on('click', function () {
            table.button('.buttons-copy').trigger();
        });
        $('#csvBtn').on('click', function () {
            table.button('.buttons-csv').trigger();
        });
        $('#printBtn').on('click', function () {
            table.button('.buttons-print').trigger();
        });
    });
</script>
@endsection
