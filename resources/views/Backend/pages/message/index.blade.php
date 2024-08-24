@extends('Backend.layouts.master')

@section('title', 'Message List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Message List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Message List</li>
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
                <div class="col-md-12">
                    <!-- Orders table -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Message List</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Response</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data['messages'] as $message)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->phone }}</td>
                                            <td>
                                                {{ $message->message }}
                                                <br>
                                                <small>{{ $message->created_at->format('d M, Y h:i A') }}</small>
                                            </td>
                                            <td>
                                                @if ($message->response)
                                                    <span class="badge badge-success">Replied</span>
                                                    <br>
                                                    {{ $message->response }}
                                                @else
                                                    <span class="badge badge-danger">Not Replied</span>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#replyModal{{ $message->id }}">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('backend.message.destroy', $message->id) }}" method="POST" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No messages found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $data['messages']->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

{{-- reply modal --}}
@foreach ($data['messages'] as $message)
    <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="replyModal{{ $message->id }}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('backend.message.reply', $message->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModal{{ $message->id }}Label">Reply to {{ $message->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="white-space: pre-line;">
                        <p>{{ $message->message }}</p>
                        <div class="form-group row">
                            <label for="response" class="col-sm-2 col-form-label">Response</label>
                            <div class="col-sm-10">
                                <textarea name="response" id="response" class="form-control" rows="5" required>{{ $message->response }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Reply</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

