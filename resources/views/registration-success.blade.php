<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - DRBS Internet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crypto-theme.css') }}">
    <style>
        body {
            font-family: 'Poppins', 'Inter', -apple-system, sans-serif !important;
        }
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0c0c2b;
            padding: 2rem 0;
        }
        .success-card {
            background: #1a1a3e;
            border: 1px solid rgba(213, 255, 64, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            width: 100%;
            margin: 0 1rem;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: rgba(213, 255, 64, 0.15);
            border: 3px solid #d5ff40;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -50px auto 0;
            box-shadow: 0 10px 30px rgba(213, 255, 64, 0.4);
        }
        .success-icon i {
            font-size: 3rem;
            color: #d5ff40;
            animation: checkmark 0.6s ease-in-out;
        }
        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .registration-number {
            background: linear-gradient(135deg, #d5ff40 0%, #b8e030 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 2px;
        }
        .info-item {
            padding: 1rem;
            background: rgba(213, 255, 64, 0.05);
            border: 1px solid rgba(213, 255, 64, 0.1);
            border-radius: 10px;
            margin-bottom: 0.75rem;
        }
        .info-label {
            font-weight: 600;
            color: #8a8a9e;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            color: #ffffff;
            font-size: 1rem;
            margin-top: 0.25rem;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff !important;
        }
        .text-muted {
            color: #c0c2bb !important;
        }
        .alert-success {
            background: rgba(213, 255, 64, 0.1);
            border: 1px solid rgba(213, 255, 64, 0.3);
            color: #ffffff;
        }
        .btn-primary {
            background: #d5ff40;
            border: none;
            color: #0c0c2b;
            font-weight: 700;
        }
        .btn-primary:hover {
            background: #e5ff70;
            color: #0c0c2b;
        }
        .btn-outline-primary {
            border: 2px solid #d5ff40;
            color: #d5ff40;
        }
        .btn-outline-primary:hover {
            background: #d5ff40;
            color: #0c0c2b;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <div class="p-5 text-center">
                <h1 class="fw-bold mb-3">Registration Successful!</h1>
                <p class="text-muted mb-4">Thank you for choosing DRBS Internet. Your application has been received.</p>

                <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                    <div class="text-start">
                        <strong>What's Next?</strong><br>
                        <small>Our team will contact you thru your email provided within 24 hours to confirm your installation schedule. Thank you and Welcome to DRBS.</small>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="info-label mb-2">Your Registration Number</p>
                    <div class="registration-number">{{ $registration->registration_number }}</div>
                    <small class="text-muted">Please save this number for tracking your application</small>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3 text-start">Registration Details</h5>

                <div class="text-start">
                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value">{{ $registration->first_name }} {{ $registration->last_name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $registration->email }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $registration->phone }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Location</div>
                        <div class="info-value">
                            {{ $registration->building }}, Floor {{ $registration->floor }}, Unit {{ $registration->unit }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Selected Plan</div>
                        <div class="info-value">
                            @if($registration->plan == '10mbps')
                                10 Mbps - Starter (₱900/month)
                            @elseif($registration->plan == '25mbps')
                                25 Mbps - Standard (₱1,500/month)
                            @elseif($registration->plan == '50mbps')
                                50 Mbps - Premium (₱2,500/month)
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Preferred Installation Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($registration->preferred_date)->format('F d, Y') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="badge bg-warning text-dark">{{ ucfirst($registration->status) }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Submitted On</div>
                        <div class="info-value">{{ $registration->created_at->format('F d, Y - g:i A') }}</div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-grid gap-2">
                    <a href="/" class="btn btn-primary btn-lg rounded-pill">
                        <i class="bi bi-house-door me-2"></i>Back to Home
                    </a>
                    <a href="/support" class="btn btn-outline-primary btn-lg rounded-pill">
                        <i class="bi bi-headset me-2"></i>Contact Support
                    </a>
                </div>

                <div class="mt-4 p-3 bg-light rounded">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-2"></i>
                        A confirmation email has been sent to <strong>{{ $registration->email }}</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prevent back button after successful registration
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>
