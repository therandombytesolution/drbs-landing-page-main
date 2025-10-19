<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrations - DRBS Admin</title>
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
        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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
                        <a class="nav-link" href="{{ route('admin.tickets') }}">
                            <i class="bi bi-ticket-perforated me-2"></i>Tickets
                        </a>
                        <a class="nav-link active" href="{{ route('admin.registrations') }}">
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
                        <h2 class="mb-1">Service Registrations</h2>
                        <p class="text-muted">Manage customer registration requests</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.registrations.export') }}" class="btn btn-success">
                            <i class="bi bi-download me-2"></i>Export CSV
                        </a>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Filters -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('admin.registrations') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Registration #, name, email, phone..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="installed" {{ request('status') == 'installed' ? 'selected' : '' }}>Installed</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Plan</label>
                            <select name="plan" class="form-select">
                                <option value="">All Plans</option>
                                <option value="10mbps" {{ request('plan') == '10mbps' ? 'selected' : '' }}>10 Mbps</option>
                                <option value="25mbps" {{ request('plan') == '25mbps' ? 'selected' : '' }}>25 Mbps</option>
                                <option value="50mbps" {{ request('plan') == '50mbps' ? 'selected' : '' }}>50 Mbps</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Registrations Table -->
                <div class="card table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Registration #</th>
                                        <th>Customer</th>
                                        <th>Location</th>
                                        <th>Plan</th>
                                        <th>Preferred Date</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registrations as $registration)
                                    <tr>
                                        <td>
                                            <strong>{{ $registration->registration_number }}</strong>
                                        </td>
                                        <td>
                                            <div>{{ $registration->full_name }}</div>
                                            <small class="text-muted">{{ $registration->email }}</small><br>
                                            <small class="text-muted">{{ $registration->phone }}</small>
                                        </td>
                                        <td>
                                            <div>{{ $registration->building }}</div>
                                            <small class="text-muted">Floor {{ $registration->floor }}, Unit {{ $registration->unit }}</small>
                                        </td>
                                        <td>
                                            <div><strong>{{ $registration->plan_name }}</strong></div>
                                            <small class="text-muted">₱{{ number_format($registration->plan_price) }}/mo</small>
                                        </td>
                                        <td>
                                            <small>{{ $registration->preferred_date->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-custom bg-{{ $registration->status_color }}">
                                                {{ $registration->status_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $registration->created_at->format('M d, Y') }}</small><br>
                                            <small class="text-muted">{{ $registration->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.registrations.show', $registration->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="bi bi-inbox display-4 text-muted"></i>
                                            <p class="text-muted mt-2">No registrations found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $registrations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
