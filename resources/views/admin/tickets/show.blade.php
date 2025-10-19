<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket #{{ $ticket->ticket_number }} - DRBS Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/drbs-logo-small.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .detail-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="mb-4 d-flex align-items-center">
                        <img src="{{ asset('images/drbs-logo-small.png') }}" alt="DRBS Logo" style="height: 32px; width: 32px; object-fit: contain;" class="me-2" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                        <i class="bi bi-wifi me-2" style="display: none;"></i>
                        <span>DRBS Admin</span>
                    </h4>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a class="nav-link active" href="{{ route('admin.tickets') }}">
                            <i class="bi bi-ticket-perforated me-2"></i>Tickets
                        </a>
                        <a class="nav-link" href="{{ route('admin.registrations') }}">
                            <i class="bi bi-person-plus me-2"></i>Registrations
                        </a>
                        <hr class="text-white-50">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="bi bi-house me-2"></i>View Website
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="{{ route('admin.tickets') }}" class="btn btn-outline-secondary btn-sm mb-2">
                            <i class="bi bi-arrow-left me-2"></i>Back to Tickets
                        </a>
                        <h2 class="mb-1">Ticket #{{ $ticket->ticket_number }}</h2>
                        <p class="text-muted">Submitted {{ $ticket->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Ticket
                            </button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="row">
                    <!-- Ticket Details -->
                    <div class="col-md-8">
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Ticket Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-label">Subject</div>
                                <div class="info-value">{{ $ticket->subject }}</div>

                                <div class="info-label">Category</div>
                                <div class="info-value">
                                    <span class="badge bg-secondary badge-custom">{{ $ticket->category_name }}</span>
                                </div>

                                <div class="info-label">Description</div>
                                <div class="info-value">
                                    <p style="white-space: pre-wrap;">{{ $ticket->description }}</p>
                                </div>

                                @if($ticket->attachments && count($ticket->attachments) > 0)
                                <div class="info-label">Attachments</div>
                                <div class="info-value">
                                    @foreach($ticket->attachments as $attachment)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-paperclip me-2"></i>{{ $attachment['original_name'] }}
                                            <small>({{ number_format($attachment['size'] / 1024, 2) }} KB)</small>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info & Status -->
                    <div class="col-md-4">
                        <!-- Customer Information -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-label">Name</div>
                                <div class="info-value">{{ $ticket->name }}</div>

                                <div class="info-label">Email</div>
                                <div class="info-value">
                                    <a href="mailto:{{ $ticket->email }}">{{ $ticket->email }}</a>
                                </div>

                                <div class="info-label">Phone</div>
                                <div class="info-value">
                                    <a href="tel:{{ $ticket->phone }}">{{ $ticket->phone }}</a>
                                </div>

                                @if($ticket->account_number)
                                <div class="info-label">Account Number</div>
                                <div class="info-value">{{ $ticket->account_number }}</div>
                                @endif

                                <div class="info-label">Priority</div>
                                <div class="info-value">
                                    <span class="badge badge-custom bg-{{ $ticket->priority_color }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>

                                <div class="info-label">Current Status</div>
                                <div class="info-value">
                                    <span class="badge badge-custom bg-{{ $ticket->status_color }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </div>

                                <div class="info-label">Created At</div>
                                <div class="info-value">
                                    {{ $ticket->created_at->format('M d, Y h:i A') }}
                                </div>

                                @if($ticket->resolved_at)
                                <div class="info-label">Resolved At</div>
                                <div class="info-value">
                                    {{ $ticket->resolved_at->format('M d, Y h:i A') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Update Status -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Update Ticket</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Assigned To</label>
                                        <input type="text" name="assigned_to" class="form-control" value="{{ $ticket->assigned_to }}" placeholder="Team member name">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Admin Notes</label>
                                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="Internal notes...">{{ $ticket->admin_notes }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-save me-2"></i>Update Ticket
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
