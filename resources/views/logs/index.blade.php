@extends('layouts.app')

@section('content')
@include('components.promotion-banner')

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Activity Logs</h1>
            <p class="text-muted">Real-time tracking of all system activities</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('logs.download') }}" class="btn btn-info btn-sm">📥 Download Logs</a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#clearLogsModal">🗑️ Clear Logs</button>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($message))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            @if (count($logs) > 0)
                <div class="activity-log">
                    @foreach ($logs as $log)
                        <div class="log-entry mb-3">
                            @php
                                $borderColors = [
                                    'created' => '#28a745',
                                    'updated' => '#ffc107',
                                    'deleted' => '#dc3545',
                                    'viewed' => '#17a2b8',
                                    'list' => '#007bff',
                                    'error' => '#dc3545',
                                    'warning' => '#ffc107',
                                ];
                                $borderColor = $borderColors[$log['type']] ?? '#6c757d';
                            @endphp
                            <div class="card" style="border-left: 5px solid {{ $borderColor }}">
                                <div class="card-body p-3">
                                    <div class="row align-items-start">
                                        <div class="col-md-2">
                                            <small class="text-muted d-block">
                                                <i class="far fa-calendar"></i>
                                                {{ \Carbon\Carbon::parse($log['timestamp'])->format('Y-m-d') }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="far fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($log['timestamp'])->format('H:i:s') }}
                                            </small>
                                        </div>

                                        <div class="col-md-3">
                                            @if ($log['type'] === 'created')
                                                <span class="badge bg-success">✓ CREATED</span>
                                            @elseif ($log['type'] === 'updated')
                                                <span class="badge bg-warning">✎ UPDATED</span>
                                            @elseif ($log['type'] === 'deleted')
                                                <span class="badge bg-danger">✕ DELETED</span>
                                            @elseif ($log['type'] === 'viewed')
                                                <span class="badge bg-info">👁 VIEWED</span>
                                            @elseif ($log['type'] === 'list')
                                                <span class="badge bg-primary">📋 LIST</span>
                                            @elseif ($log['type'] === 'warning')
                                                <span class="badge bg-warning">⚡ WARNING</span>
                                            @elseif ($log['type'] === 'error')
                                                <span class="badge bg-danger">⚠ ERROR</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $log['level'] }}</span>
                                            @endif
                                            
                                            <div class="mt-2">
                                                <strong>{{ $log['action'] }}</strong>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            @if (!empty($log['details']))
                                                <p class="mb-0" style="font-size: 0.95rem; line-height: 1.6; color: #333;">{{ $log['details'] }}</p>
                                            @else
                                                <p class="mb-0 text-muted"><small>No additional details</small></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card">
                    <div class="card-body p-5 text-center">
                        <i class="fas fa-info-circle fa-2x text-muted mb-3" style="display:block;"></i>
                        <p class="text-muted mb-0">No activity logs yet. Logs will appear here as you use the system.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Clear Logs Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clear All Activity Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><strong>⚠️ Warning:</strong> This action will permanently delete all activity logs. This cannot be undone.</p>
                <p>Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('logs.clear') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Clear All Logs</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .activity-log {
        margin-top: 20px;
    }

    .log-entry {
        animation: slideIn 0.3s ease-in;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

@endsection
