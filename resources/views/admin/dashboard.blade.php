<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - DRBS Internet</title>
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
        .stat-card {
            border-radius: 15px;
            border: none;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .table-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('admin.tickets') }}">
                            <i class="bi bi-ticket-perforated me-2"></i>Tickets
                            @if($ticketStats['open'] > 0)
                            <span class="badge bg-danger float-end">{{ $ticketStats['open'] }}</span>
                            @endif
                        </a>
                        <a class="nav-link" href="{{ route('admin.registrations') }}">
                            <i class="bi bi-person-plus me-2"></i>Registrations
                            @if($registrationStats['pending'] > 0)
                            <span class="badge bg-warning float-end">{{ $registrationStats['pending'] }}</span>
                            @endif
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
                        <h2 class="mb-1">Dashboard</h2>
                        <p class="text-muted mb-0">Welcome to DRBS Internet Admin Panel</p>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">{{ now()->format('l, F j, Y') }}</small>
                        <small class="text-muted">{{ now()->format('g:i A') }}</small>
                    </div>
                </div>

                <!-- Ticket Statistics -->
                <h5 class="mb-3">Support Tickets Overview</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-primary-subtle text-primary me-3">
                                    <i class="bi bi-ticket"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Total Tickets</h6>
                                    <h3 class="mb-0">{{ $ticketStats['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-warning-subtle text-warning me-3">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Open</h6>
                                    <h3 class="mb-0">{{ $ticketStats['open'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-info-subtle text-info me-3">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">In Progress</h6>
                                    <h3 class="mb-0">{{ $ticketStats['in_progress'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-success-subtle text-success me-3">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Resolved</h6>
                                    <h3 class="mb-0">{{ $ticketStats['resolved'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Statistics -->
                <h5 class="mb-3">Registration Overview</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-primary-subtle text-primary me-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Total Registrations</h6>
                                    <h3 class="mb-0">{{ $registrationStats['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-warning-subtle text-warning me-3">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Pending</h6>
                                    <h3 class="mb-0">{{ $registrationStats['pending'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-info-subtle text-info me-3">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Scheduled</h6>
                                    <h3 class="mb-0">{{ $registrationStats['scheduled'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon bg-success-subtle text-success me-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small">Active</h6>
                                    <h3 class="mb-0">{{ $registrationStats['active'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row g-4">
                    <!-- Recent Tickets -->
                    <div class="col-md-6">
                        <div class="card table-card">
                            <div class="card-header bg-white border-0 pt-4 px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Tickets</h5>
                                    <a href="{{ route('admin.tickets') }}" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0">Ticket #</th>
                                                <th class="border-0">Name</th>
                                                <th class="border-0">Priority</th>
                                                <th class="border-0">Status</th>
                                                <th class="border-0">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentTickets as $ticket)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-decoration-none">
                                                        {{ $ticket->ticket_number }}
                                                    </a>
                                                </td>
                                                <td>{{ Str::limit($ticket->name, 20) }}</td>
                                                <td>
                                                    <span class="badge badge-custom bg-{{ $ticket->priority_color }}">
                                                        {{ ucfirst($ticket->priority) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-custom bg-{{ $ticket->status_color }}">
                                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    No tickets yet
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Registrations -->
                    <div class="col-md-6">
                        <div class="card table-card">
                            <div class="card-header bg-white border-0 pt-4 px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Registrations</h5>
                                    <a href="{{ route('admin.registrations') }}" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0">Reg #</th>
                                                <th class="border-0">Name</th>
                                                <th class="border-0">Plan</th>
                                                <th class="border-0">Status</th>
                                                <th class="border-0">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentRegistrations as $registration)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.registrations.show', $registration->id) }}" class="text-decoration-none">
                                                        {{ $registration->registration_number }}
                                                    </a>
                                                </td>
                                                <td>{{ Str::limit($registration->full_name, 20) }}</td>
                                                <td>
                                                    <span class="badge badge-custom bg-info">
                                                        {{ $registration->plan_name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-custom bg-{{ $registration->status_color }}">
                                                        {{ ucfirst($registration->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $registration->created_at->diffForHumans() }}</small>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    No registrations yet
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Summary -->
                <div class="row g-4 mt-3">
                    <div class="col-md-4">
                        <div class="card stat-card border-start border-primary border-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Today</h6>
                                        <h4 class="mb-0">{{ $ticketStats['today'] + $registrationStats['today'] }}</h4>
                                        <small class="text-muted">New submissions</small>
                                    </div>
                                    <i class="bi bi-calendar-day text-primary fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card border-start border-success border-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">This Week</h6>
                                        <h4 class="mb-0">{{ $ticketStats['this_week'] + $registrationStats['this_week'] }}</h4>
                                        <small class="text-muted">New submissions</small>
                                    </div>
                                    <i class="bi bi-calendar-week text-success fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card border-start border-danger border-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">High Priority</h6>
                                        <h4 class="mb-0">{{ $ticketStats['high_priority'] }}</h4>
                                        <small class="text-muted">Urgent tickets</small>
                                    </div>
                                    <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
                                </div>
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
