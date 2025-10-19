<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration #{{ $registration->registration_number }} - DRBS Admin</title>
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
                        <a href="{{ route('admin.registrations') }}" class="btn btn-outline-secondary btn-sm mb-2">
                            <i class="bi bi-arrow-left me-2"></i>Back to Registrations
                        </a>
                        <h2 class="mb-1">Registration #{{ $registration->registration_number }}</h2>
                        <p class="text-muted">Submitted {{ $registration->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Registration
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
                    <!-- Registration Details -->
                    <div class="col-md-8">
                        <!-- Personal Information -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Full Name</div>
                                        <div class="info-value">{{ $registration->full_name }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">
                                            <a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Phone</div>
                                        <div class="info-value">
                                            <a href="tel:{{ $registration->phone }}">{{ $registration->phone }}</a>
                                        </div>
                                    </div>
                                    @if($registration->alternate_phone)
                                    <div class="col-md-6">
                                        <div class="info-label">Alternate Phone</div>
                                        <div class="info-value">
                                            <a href="tel:{{ $registration->alternate_phone }}">{{ $registration->alternate_phone }}</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Location Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Building</div>
                                        <div class="info-value">{{ $registration->building }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Floor</div>
                                        <div class="info-value">{{ $registration->floor }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-label">Unit</div>
                                        <div class="info-value">{{ $registration->unit }}</div>
                                    </div>
                                </div>
                                @if($registration->tower)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="info-label">Tower</div>
                                        <div class="info-value">{{ $registration->tower }}</div>
                                    </div>
                                </div>
                                @endif
                                <div class="info-label">Full Address</div>
                                <div class="info-value">{{ $registration->full_address }}</div>
                            </div>
                        </div>

                        <!-- Plan & Additional Info -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Plan & Additional Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Selected Plan</div>
                                        <div class="info-value">
                                            <strong>{{ $registration->plan_name }}</strong><br>
                                            <span class="text-success">₱{{ number_format($registration->plan_price) }}/month</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Preferred Installation Date</div>
                                        <div class="info-value">{{ $registration->preferred_date->format('F d, Y') }}</div>
                                    </div>
                                </div>

                                @if($registration->referral_code)
                                <div class="info-label">Referral Code</div>
                                <div class="info-value">
                                    <span class="badge bg-info">{{ $registration->referral_code }}</span>
                                </div>
                                @endif

                                @if($registration->notes)
                                <div class="info-label">Customer Notes</div>
                                <div class="info-value">
                                    <p style="white-space: pre-wrap;">{{ $registration->notes }}</p>
                                </div>
                                @endif

                                @if($registration->documents && count($registration->documents) > 0)
                                <div class="info-label">Uploaded Documents</div>
                                <div class="info-value">
                                    @foreach($registration->documents as $document)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($document['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark me-2"></i>{{ $document['original_name'] }}
                                            <small>({{ number_format($document['size'] / 1024, 2) }} KB)</small>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Terms Accepted</div>
                                        <div class="info-value">
                                            @if($registration->agree_terms)
                                            <span class="badge bg-success">Yes</span>
                                            @else
                                            <span class="badge bg-danger">No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Marketing Consent</div>
                                        <div class="info-value">
                                            @if($registration->agree_marketing)
                                            <span class="badge bg-success">Yes</span>
                                            @else
                                            <span class="badge bg-secondary">No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Timeline -->
                    <div class="col-md-4">
                        <!-- Current Status -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Status Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-label">Current Status</div>
                                <div class="info-value">
                                    <span class="badge badge-custom bg-{{ $registration->status_color }}">
                                        {{ $registration->status_name }}
                                    </span>
                                </div>

                                <div class="info-label">Created At</div>
                                <div class="info-value">
                                    {{ $registration->created_at->format('M d, Y h:i A') }}
                                </div>

                                @if($registration->contacted_at)
                                <div class="info-label">Contacted At</div>
                                <div class="info-value">
                                    {{ $registration->contacted_at->format('M d, Y h:i A') }}
                                </div>
                                @endif

                                @if($registration->scheduled_at)
                                <div class="info-label">Scheduled At</div>
                                <div class="info-value">
                                    {{ $registration->scheduled_at->format('M d, Y h:i A') }}
                                </div>
                                @endif

                                @if($registration->installed_at)
                                <div class="info-label">Installed At</div>
                                <div class="info-value">
                                    {{ $registration->installed_at->format('M d, Y h:i A') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Update Status -->
                        <div class="card detail-card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Update Registration</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="contacted" {{ $registration->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="scheduled" {{ $registration->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="installed" {{ $registration->status == 'installed' ? 'selected' : '' }}>Installed</option>
                                            <option value="active" {{ $registration->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="cancelled" {{ $registration->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Scheduled Installation Date</label>
                                        <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ $registration->scheduled_at ? $registration->scheduled_at->format('Y-m-d\TH:i') : '' }}">
                                        <small class="text-muted">Only set when status is "Scheduled"</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Admin Notes</label>
                                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="Internal notes...">{{ $registration->admin_notes }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-save me-2"></i>Update Registration
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
