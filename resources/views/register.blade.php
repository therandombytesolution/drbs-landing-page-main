<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - DRBS Internet</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/drbs-logo-small.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=20251019h">
    <link rel="stylesheet" href="{{ asset('css/crypto-theme.css') }}?v=20251019h">
    
    <!-- Mobile Navigation Fix -->
    <style>
        /* Force navbar container to use flexbox properly */
        .navbar > .container {
            display: flex !important;
            flex-wrap: nowrap !important;
            justify-content: space-between !important;
            align-items: center !important;
            position: relative !important;
        }
        
        @media (max-width: 991px) {
            .navbar {
                padding: 0.25rem 0 !important;
                min-height: 45px !important;
            }
            
            .navbar > .container {
                flex-wrap: nowrap !important;
            }
            
            .navbar-brand {
                font-size: 0.9rem !important;
                padding: 0.25rem 0 !important;
                flex-shrink: 1 !important;
                margin-right: auto !important;
            }
            
            .navbar-brand img {
                height: 28px !important;
                width: 28px !important;
            }
            
            .navbar-toggler {
                padding: 0.2rem 0.4rem !important;
                font-size: 0.9rem !important;
                border: 1px solid rgba(255,255,255,0.2) !important;
                margin-left: 0.5rem !important;
                flex-shrink: 0 !important;
            }
            
            .navbar-collapse {
                background: rgba(12, 12, 43, 0.98);
                margin-top: 0.5rem;
                padding: 1rem;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                flex-basis: 100% !important;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                z-index: 1000 !important;
            }
            
            .navbar-nav .nav-link {
                padding: 0.5rem 0 !important;
            }
            
            .navbar-nav .btn {
                margin-top: 0.5rem;
                margin-bottom: 0.25rem;
                width: 100%;
            }
        }
        
        /* Mobile Form Padding Fix - All Registration Steps */
        @media (max-width: 767px) {
            .registration-card .card-body {
                padding: 1.5rem !important;
            }
            
            .registration-card .card-body .text-center.mb-5 {
                margin-bottom: 2rem !important;
            }
            
            /* All form steps padding */
            .form-step {
                padding: 0 !important;
            }
            
            /* Adjust container padding */
            section.py-5 .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
        
        @media (max-width: 575px) {
            .registration-card .card-body {
                padding: 1rem !important;
            }
            
            /* Tighter spacing for very small screens */
            section.py-5 .container {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- Modern Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/drbs-logo-small.png') }}" alt="DRBS Logo" style="height: 40px; width: 40px; object-fit: contain;" class="me-2" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                <i class="bi bi-wifi me-2 fs-4" style="display: none;"></i>
                <span class="fw-bold">DRBS Internet</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link px-lg-3 px-2" href="/#plans">Plans</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 px-2" href="/#about">About</a></li>
                    <li class="nav-item"><a class="nav-link px-lg-3 px-2" href="/#contact">Contact</a></li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a class="btn btn-outline-light btn-sm rounded-pill px-4 w-100 w-lg-auto" href="/register">Get Started</a></li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a class="btn btn-primary btn-sm rounded-pill px-4 w-100 w-lg-auto" href="/support">Support</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Registration Header -->
    <section class="page-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="breadcrumb-nav mb-4">
                        <a href="/" class="text-white-50 text-decoration-none"><i class="bi bi-house-door me-2"></i>Home</a>
                        <span class="text-white-50 mx-2">/</span>
                        <span class="text-white">Registration</span>
                    </div>
                    <h1 class="display-4 fw-bold text-white mb-3">Start Your Free Trial</h1>
                    <p class="lead text-white-50 mb-0">Experience our service risk-free for 3 days. No credit card required.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Progress Steps -->
                    <div class="registration-steps mb-5">
                        <div class="step active">
                            <div class="step-number">1</div>
                            <div class="step-label">Personal Info</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-label">Location</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-label">Plan Selection</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-label">Confirmation</div>
                        </div>
                    </div>

                    <!-- Registration Form Card -->
                    <div class="card registration-card shadow-lg border-0">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <div class="registration-icon mb-3">
                                    <i class="bi bi-person-plus-fill text-primary fs-1"></i>
                                </div>
                                <h3 class="fw-bold mb-2">Create Your Account</h3>
                                <p class="text-muted">Fill in your details to get started</p>
                            </div>

                            <!-- Success/Error Messages -->
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Please correct the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form id="registrationForm" method="POST" action="{{ route('registration.submit') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Step 1: Personal Information -->
                                <div class="form-step active" id="step1">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-person-circle me-2"></i>Personal Information</h5>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" id="firstName" name="first_name" placeholder="John" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" id="lastName" name="last_name" placeholder="Doe" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-3">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control border-start-0" id="email" name="email" placeholder="john.doe@example.com" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-telephone"></i>
                                                </span>
                                                <input type="tel" class="form-control border-start-0" id="phone" name="phone" placeholder="+63 912 345 6789" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="alternatePhone" class="form-label">Alternate Phone Number <span class="text-muted">(Optional)</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control border-start-0" id="alternatePhone" name="alternate_phone" placeholder="+63 912 345 6789">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="button" class="btn btn-primary px-5 py-2" onclick="nextStep(1)">
                                            Next <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Location Information -->
                                <div class="form-step" id="step2">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-geo-alt-fill me-2"></i>Location Information</h5>

                                    <div class="mt-3">
                                        <label for="building" class="form-label">Condominium/Building <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-building"></i>
                                            </span>
                                            <select class="form-select border-start-0" id="building" name="building" required>
                                                <option value="">Select your building...</option>
                                                <option value="pcampa-tower-1">P.Campa Tower 1</option>
                                                <option value="pcampa-tower-2">P.Campa Tower 2</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row g-3 mt-3">
                                        <div class="col-md-6">
                                            <label for="floor" class="form-label">Floor <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="floor" name="floor" placeholder="e.g., 5th" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="unit" class="form-label">Unit Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="unit" name="unit" placeholder="e.g., 501" required>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="fullAddress" class="form-label">Complete Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="fullAddress" name="full_address" rows="3" placeholder="Enter your complete address including city, province, and postal code" required></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary px-5 py-2" onclick="prevStep(2)">
                                            <i class="bi bi-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="button" class="btn btn-primary px-5 py-2" onclick="nextStep(2)">
                                            Next <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 3: Plan Selection -->
                                <div class="form-step" id="step3">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-grid-3x3-gap me-2"></i>Choose Your Plan</h5>

                                    <div class="plan-selection">
                                        <div class="form-check plan-option">
                                            <input class="form-check-input" type="radio" name="plan" id="plan10" value="10mbps" required>
                                            <label class="form-check-label w-100" for="plan10">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="fw-bold mb-1">10 Mbps - Starter</h6>
                                                        <p class="text-muted small mb-2">Perfect for browsing and streaming</p>
                                                        <ul class="small mb-0">
                                                            <li>Unlimited data</li>
                                                            <li>3-day free trial</li>
                                                            <li>24/7 support</li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="h5 fw-bold text-primary mb-0">₱900</div>
                                                        <small class="text-muted">/month</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="form-check plan-option popular">
                                            <span class="popular-badge">Most Popular</span>
                                            <input class="form-check-input" type="radio" name="plan" id="plan25" value="25mbps" required>
                                            <label class="form-check-label w-100" for="plan25">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="fw-bold mb-1">25 Mbps - Standard</h6>
                                                        <p class="text-muted small mb-2">Great for work from home</p>
                                                        <ul class="small mb-0">
                                                            <li>Unlimited data</li>
                                                            <li>3-day free trial</li>
                                                            <li>Priority support</li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="h5 fw-bold text-primary mb-0">₱1,500</div>
                                                        <small class="text-muted">/month</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="form-check plan-option">
                                            <input class="form-check-input" type="radio" name="plan" id="plan50" value="50mbps" required>
                                            <label class="form-check-label w-100" for="plan50">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="fw-bold mb-1">50 Mbps - Premium</h6>
                                                        <p class="text-muted small mb-2">Ultimate speed for heavy users</p>
                                                        <ul class="small mb-0">
                                                            <li>Unlimited data</li>
                                                            <li>3-day free trial</li>
                                                            <li>VIP support</li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="h5 fw-bold text-primary mb-0">₱2,500</div>
                                                        <small class="text-muted">/month</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="alert alert-info d-flex align-items-start mt-4" role="alert">
                                        <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                                        <div>
                                            <strong>Installation Fee: ₱600</strong><br>
                                            <small>Charged only after your 3-day free trial ends. Cancel anytime during the trial with no charges.</small>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="preferredDate" class="form-label">Preferred Installation Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="preferredDate" name="preferred_date" required>
                                        <small class="text-muted">We'll contact you to confirm the exact installation schedule.</small>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary px-5 py-2" onclick="prevStep(3)">
                                            <i class="bi bi-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="button" class="btn btn-primary px-5 py-2" onclick="nextStep(3)">
                                            Next <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 4: Confirmation & Additional Info -->
                                <div class="form-step" id="step4">
                                    <h5 class="fw-bold mb-4"><i class="bi bi-check-circle me-2"></i>Confirmation & Additional Info</h5>

                                    <div class="mt-3">
                                        <label for="referralCode" class="form-label">Referral Code <span class="text-muted">(Optional)</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-gift"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="referralCode" name="referral_code" placeholder="Enter referral code if you have one">
                                        </div>
                                        <small class="text-muted">Get additional benefits with a referral code!</small>
                                    </div>

                                    <div class="mt-3">
                                        <label for="notes" class="form-label">Additional Notes <span class="text-muted">(Optional)</span></label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions or requests? (e.g., gate code, best time to contact)"></textarea>
                                    </div>

                                    <div class="mt-3">
                                        <label for="documents" class="form-label">Upload Documents <span class="text-muted">(Optional)</span></label>
                                        <input class="form-control" type="file" id="documents" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">You may upload valid ID, proof of address, or other relevant documents.</small>
                                    </div>

                                    <div class="card bg-light border-0 mt-4">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3">Terms & Conditions</h6>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required>
                                                <label class="form-check-label" for="agreeTerms">
                                                    I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a> <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="hidden" name="agree_marketing" value="0">
                                                <input class="form-check-input" type="checkbox" id="agreeMarketing" name="agree_marketing" value="1">
                                                <label class="form-check-label" for="agreeMarketing">
                                                    I agree to receive promotional emails and updates
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-success d-flex align-items-start mt-4" role="alert">
                                        <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                                        <div>
                                            <strong>What happens next?</strong><br>
                                            <small>Our team will contact you within 24 hours to confirm your installation schedule and answer any questions.</small>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary px-5 py-2" onclick="prevStep(4)">
                                            <i class="bi bi-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="submit" class="btn btn-success px-5 py-2">
                                            <i class="bi bi-check-circle me-2"></i> Submit Application
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Help Section -->
                    <div class="text-center mt-5">
                        <p class="text-muted">Need help? <a href="/support" class="text-decoration-none fw-medium">Contact our support team</a> or call us at <strong>+639534953231</strong></p>
                    </div>
                </div>

                <!-- Sidebar with Benefits -->
                <div class="col-lg-4">
                    <div class="sticky-sidebar">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-4">Why Choose DRBS?</h6>
                                <div class="benefit-item mb-3">
                                    <div class="d-flex">
                                        <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                                        <div>
                                            <h6 class="mb-1">3-Day Free Trial</h6>
                                            <small class="text-muted">Test our service risk-free</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="benefit-item mb-3">
                                    <div class="d-flex">
                                        <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                                        <div>
                                            <h6 class="mb-1">Fast Installation</h6>
                                            <small class="text-muted">Get connected in 24-48 hours</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="benefit-item mb-3">
                                    <div class="d-flex">
                                        <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                                        <div>
                                            <h6 class="mb-1">24/7 Support</h6>
                                            <small class="text-muted">We're always here to help</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="benefit-item">
                                    <div class="d-flex">
                                        <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                                        <div>
                                            <h6 class="mb-1">No Hidden Fees</h6>
                                            <small class="text-muted">Transparent pricing always</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-primary text-white">
                            <div class="card-body p-4 text-center">
                                <i class="bi bi-headset fs-1 mb-3"></i>
                                <h6 class="fw-bold mb-2">Need Assistance?</h6>
                                <p class="small mb-3">Our team is ready to help you with the registration process</p>
                                <a href="/support" class="btn btn-light btn-sm rounded-pill px-4">Contact Support</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-4 d-flex align-items-center">
                        <img src="{{ asset('images/drbs-logo-small.png') }}" alt="DRBS Logo" style="height: 40px; width: 40px; object-fit: contain;" class="me-2" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                        <i class="bi bi-wifi me-2 fs-4" style="display: none;"></i>
                        <span class="fw-bold fs-5">DRBS Internet</span>
                    </div>
                    <p class="text-muted mb-4">Connecting communities with fast, reliable, and affordable internet services designed for modern living.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/#plans">Plans</a></li>
                        <li><a href="/#about">About Us</a></li>
                        <li><a href="/#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-4">Services</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/register">Registration</a></li>
                        <li><a href="/support">Support</a></li>
                        <li><a href="/#plans">Internet Plans</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold mb-4">Contact Info</h6>
                    <ul class="list-unstyled footer-links">
                        <li><i class="bi bi-telephone me-2"></i>+639534953231</li>
                        <li><i class="bi bi-envelope me-2"></i>therandombytesolution@gmail.com</li>
                        <li><i class="bi bi-clock me-2"></i>24/7 Customer Support</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted">&copy; 2025 DRBS Internet. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-muted text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Form Step Navigation Script -->
    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.form-step').forEach(el => {
                el.classList.remove('active');
            });

            // Show current step
            document.getElementById('step' + step).classList.add('active');

            // Update progress steps
            document.querySelectorAll('.registration-steps .step').forEach((el, index) => {
                if (index < step) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            });

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function nextStep(step) {
            // Validate current step
            const currentStepEl = document.getElementById('step' + step);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let valid = true;

            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    valid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (valid && step < totalSteps) {
                currentStep = step + 1;
                showStep(currentStep);
            } else if (!valid) {
                alert('Please fill in all required fields correctly.');
            }
        }

        function prevStep(step) {
            if (step > 1) {
                currentStep = step - 1;
                showStep(currentStep);
            }
        }

        // Initialize
        showStep(currentStep);

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Form submission - validate before submitting
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            // Validate the current step before submitting
            if (currentStep !== totalSteps) {
                e.preventDefault();
                alert('Please complete all steps of the form.');
                return false;
            }
            // Let the form submit naturally to the server
        });

        // Set minimum date for installation date
        const today = new Date();
        today.setDate(today.getDate() + 2); // Minimum 2 days from now
        const minDate = today.toISOString().split('T')[0];
        document.getElementById('preferredDate').setAttribute('min', minDate);
    </script>
</body>
</html>
