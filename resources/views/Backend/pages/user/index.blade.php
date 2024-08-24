@extends('Backend/layouts/master')

@section('title', 'User List')

@section('page-script')
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#datatables-users").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#datatables-users_wrapper .col-md-6:eq(0)');
        });

        function roleUpdate(id, role) {

            // rander option for select id chooseRole
            var options = '';
            options += '<option selected disabled>Choose Role</option>';
            options += '<option value="">N/A</option>';
            @foreach ($data['roles'] as $role )
                if(role == '{{$role->name}}'){
                    options += '<option value="{{$role->hashId}}" selected>{{$role->name}}</option>';
                }else{
                    options += '<option value="{{$role->hashId}}">{{$role->name}}</option>';
                }
            @endforeach

            $('#chooseRole').html(options);

            $('#upgradeRoleModalUserId').val(id);
            $('#upgradeRoleModal').modal('show');
        }

        // when click on upgradeRoleBtn
        $('#upgradeRoleBtn').click(function() {
            var userId = $('#upgradeRoleModalUserId').val();
            var roleId = $('#chooseRole').val();

            if (userId == '' ) {
                Toast.fire({
                    icon: 'error',
                    title: 'Please select a user'
                });
                return false;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('backend.role.update.user') }}",
                type: "POST",
                data: {
                    "userId": userId,
                    "roleId": roleId,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#upgradeRoleModal').modal('hide');

                        toastr.success(response.message);

                        // reload page
                        setTimeout(function() {
                            location.reload();
                        }, 800);

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    toastr.error(response.message);
                }
            });
        });

    </script>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">User List</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        @if ($errors->any() || session('error'))
            @include('Backend._partials.errorMsg')
        @endif

        @if (session('success'))
            @include('Backend._partials.successMsg')
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatables-users" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['users'] as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="user-block">
                                                        <img class="img-circle" src="{{ $user['image'] }}"
                                                            alt="User Image">
                                                        <span class="username">
                                                            <a href="{{ route('backend.user.details',$user['id']) }}">{{ $user['full_name'] }}</a>
                                                        </span>
                                                    </div>

                                                </td>
                                                <td>{{ $user['email'] }}</td>
                                                <td>
                                                    @if ($user['status'] == 'active')
                                                        <span class="badge badge-success">{{ $user['status'] }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $user['status'] }}</span>
                                                    @endif
                                                <td>
                                                    <a href="{{ route('backend.user.details', $user['id']) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    @if ($user['role'] == null)
                                                        <span class="badge badge-danger">No Role</span>
                                                        <span class='badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2' id='roleEditSpan' style='cursor: pointer;' onclick='roleUpdate("{{ $user['hashId'] }}","{{ $user['role'] }}")'>
                                                            <i class='fas fa-plus'></i>
                                                            Add
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">{{ $user['role'] }}</span>
                                                        @if ($user['role'] != 'super-admin')
                                                            <span class='badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2' id='roleEditSpan' onclick='roleUpdate("{{ $user['hashId'] }}","{{ $user['role'] }}")' style='cursor: pointer;'>
                                                                <i class='fas fa-edit'></i>
                                                                Edit
                                                            </span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen modal-dialog-right">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailModalLabel">User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="userDetailsContent">
                        <!-- User details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-dialog-right {
            position: absolute;
            right: 0;
            margin: 0;
            min-width: 400px;
            height: 100%;
            max-width: 100%; /* Ensure the modal is fully wide if needed */
        }

        /* Ensures the modal content takes full height */
        .modal-fullscreen .modal-content {
            height: 100%;
        }
        /*
        * Ensure the modal header and footer don't scroll
        */

        /* Make the modal body scrollable */
        .modal-body {
            overflow-y: auto;
            max-height: calc(100vh - 100px); /* Adjust for modal header and footer */
        }
    </style>


    @include('Backend.pages.user.role_update')

@endsection
