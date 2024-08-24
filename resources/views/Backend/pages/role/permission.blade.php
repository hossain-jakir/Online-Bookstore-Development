@extends('Backend/layouts/master')

@section('title', 'Permission Management')

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
                        <h1 class="m-0">Permission Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Permission Management</li>
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
                <!-- Add Role Modal -->
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3 class="role-title">User Roles</h3>
                                    <p>Set role permissions</p>
                                </div>
                                <!-- Add role form -->
                                <form id="addRoleForm" class="row g-3" action="{{ route('backend.role.permissions.update', $data['role']->id) }}" method="POST">
                                    @csrf
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="modalRoleName">Role: <strong> {{$data['role']->name}} </strong></label>
                                    </div>
                                    @can('role assign')
                                        <div class="col-12">
                                            <h4>Permissions</h4>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll" />
                                                <label class="form-check-label" for="selectAll">Select All</label>
                                            </div>
                                            @foreach(App\Enums\Permissions::cases() as $key => $permission)
                                                <div class="d-flex">
                                                    <div class="form-check me-3 me-lg-5">
                                                        <input class="form-check-input"
                                                            type="checkbox"
                                                            name="permissions[]"
                                                            value="{{ $permission->value }}"
                                                            id="{{ $permission->value }}{{ $key }}"
                                                            @if(in_array($permission->value, $data['role']->permissions)) checked @endif />
                                                        <label class="form-check-label" for="{{ $permission->value }}{{ $key }}">
                                                            {{ $permission->value }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endcan
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                                <!--/ Add role form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Add Role Modal -->
            </div>
        </section>
    </div>
@endsection
