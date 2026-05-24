@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Maintenance Mode Management</h2>
            <p class="text-muted">Manage system maintenance records and status</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Create Maintenance Record
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th>Start Date</th>
                    <th width="200px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $maintenance)
                    <tr>
                        <td>{{ $maintenance->id }}</td>
                        <td>{{ $maintenance->title }}</td>
                        <td>
                            <span class="badge bg-{{ $maintenance->status === 'ongoing' ? 'danger' : ($maintenance->status === 'scheduled' ? 'warning' : 'success') }}">
                                {{ ucfirst($maintenance->status) }}
                            </span>
                        </td>
                        <td>
                            @if($maintenance->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $maintenance->scheduled_start?->format('M j, Y g:i A') ?? '-' }}</td>
                        <td>
                            @if($maintenance->is_active)
                                <form action="{{ route('maintenance.deactivate', $maintenance->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Deactivate</button>
                                </form>
                            @else
                                <form action="{{ route('maintenance.activate', $maintenance->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                </form>
                            @endif
                            <form action="{{ route('maintenance.destroy', $maintenance->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No maintenance records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($maintenances->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $maintenances->links() }}
        </div>
    @endif
</div>
@endsection
