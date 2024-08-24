@extends('Backend/layouts/master')

@section('title', 'Role List')

@section('page-script')
    <script src="{{ asset('assets/backend/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/modal-add-role.js') }}"></script>

    <script>
        function editRole(id, name, permissions) {
            $('#addRoleForm').trigger('reset');
            $('#addRoleForm input[name="permissions[]"]').prop('checked', false);
            $('#addRoleForm').attr('action', '{{ route('backend.role.update', ':id') }}'.replace(':id', id));
            $('#addRoleForm input[name="name"]').val(name);
            $('#addRoleModal').modal('show');
            var permissions = JSON.parse(permissions);
            $.each(permissions, function(index, value) {
                $('#addRoleForm input[name="permissions[]"][value="' + value + '"]').prop('checked', true);
            });
        }

        function addRole() {
            $('#addRoleForm').trigger('reset');
            $('#addRoleForm input[name="permissions[]"]').prop('checked', false);
            $('#addRoleForm').attr('action', '{{ route('backend.role.store') }}');
            $('#addRoleForm input[name="name"]').val('');
            $('#addRoleModal').modal('show');
        }
    </script>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Role List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Role List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Error and Success Messages -->
        @if ($errors->any() || session('error'))
            @include('Backend._partials.errorMsg')
        @endif

        @if (session('success'))
            @include('Backend._partials.successMsg')
        @endif

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row g-4">
                    <!-- Iterate over roles -->
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['roles'] as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @forelse ($role->permissions as $permission)
                                            <span class="badge bg-primary">{{ $permission }}</span>
                                        @empty
                                            <span class="badge bg-secondary">No Permissions</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @if ($role->id != 1)
                                            @can('edit role')
                                                <a href="{{ route('backend.role.permissions', $role->id) }}">Edit Role</a>
                                            @endcan
                                            @can('delete role')
                                                <form action="{{ route('backend.role.delete', $role->hashId) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this role?');">Delete Role</button>
                                                </form>
                                            @endcan
                                        @else
                                            <small>Super Admin Role. Cannot be deleted or edited.</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No roles found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Add New Role Card -->
                    @can('backend.role.create')
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card h-100">
                                <div class="row h-100">
                                    <div class="col-sm-5">
                                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                            <img src="{{ asset('assets/backend/img/illustrations/sitting-girl-with-laptop-light.png') }}" class="img-fluid" alt="Add Role" width="120">
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="card-body text-sm-end text-center ps-sm-0">
                                            <button onclick="addRole()" class="btn btn-primary mb-3 text-nowrap">Add New Role</button>
                                            <p class="mb-0">Create a new role if it does not exist</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                </div>
            </div>
        </section>
    </div>

    <!-- Add Role Modal -->
    @include('Backend/_partials/modal-add-role')
@endsection
