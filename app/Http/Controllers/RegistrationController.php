<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /**
     * Store a newly created registration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            // Personal Information
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:registrations,email",
            "phone" => "required|string|max:20",
            "alternate_phone" => "nullable|string|max:20",

            // Location Information
            "building" => "required|string|max:255",
            "floor" => "required|string|max:50",
            "unit" => "required|string|max:50",
            "tower" => "nullable|string|max:50",
            "full_address" => "required|string",

            // Plan Selection
            "plan" => "required|string|in:10mbps,25mbps,50mbps",
            "preferred_date" => "required|date|after:today",

            // Additional Information
            "referral_code" => "nullable|string|max:50",
            "notes" => "nullable|string|max:1000",
            "documents.*" => "nullable|file|mimes:jpg,jpeg,png,pdf|max:5120", // 5MB max per file

            // Terms & Conditions
            "agree_terms" => "required|accepted",
            "agree_marketing" => "sometimes|boolean",
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with("error", "Please check the form for errors.");
        }

        try {
            // Handle document uploads
            $documentPaths = [];
            if ($request->hasFile("documents")) {
                foreach ($request->file("documents") as $file) {
                    $path = $file->store("registration-documents", "public");
                    $documentPaths[] = [
                        "original_name" => $file->getClientOriginalName(),
                        "path" => $path,
                        "size" => $file->getSize(),
                        "mime_type" => $file->getMimeType(),
                    ];
                }
            }

            // Create the registration
            $registration = Registration::create([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "phone" => $request->phone,
                "alternate_phone" => $request->alternate_phone,
                "building" => $request->building,
                "floor" => $request->floor,
                "unit" => $request->unit,
                "tower" => $request->tower,
                "full_address" => $request->full_address,
                "plan" => $request->plan,
                "preferred_date" => $request->preferred_date,
                "referral_code" => $request->referral_code,
                "notes" => $request->notes,
                "documents" => !empty($documentPaths) ? $documentPaths : null,
                "agree_terms" => $request->has("agree_terms"),
                "agree_marketing" => $request->has("agree_marketing")
                    ? true
                    : false,
                "status" => "pending",
            ]);

            // TODO: Send email notification to admin
            // TODO: Send confirmation email to customer

            return redirect()
                ->route("registration.success", [
                    "registration" => $registration->registration_number,
                ])
                ->with(
                    "success",
                    "Your registration has been submitted successfully! Your registration number is: " .
                        $registration->registration_number .
                        ". We will contact you within 24 hours.",
                );
        } catch (\Exception $e) {
            \Log::error("Registration submission error: " . $e->getMessage());
            return back()
                ->withInput()
                ->with(
                    "error",
                    "An error occurred while submitting your registration. Please try again or contact us directly.",
                );
        }
    }

    /**
     * Show registration success page.
     *
     * @param  string  $registrationNumber
     * @return \Illuminate\View\View
     */
    public function success($registrationNumber)
    {
        $registration = Registration::where(
            "registration_number",
            $registrationNumber,
        )->firstOrFail();

        return view("registration-success", compact("registration"));
    }

    /**
     * Track a registration by registration number or email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function track(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "track_input" => "required|string",
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with(
                    "error",
                    "Please enter a registration number or email address.",
                );
        }

        $input = $request->track_input;

        // Check if input is email or registration number
        $registration = null;

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // Search by email
            $registration = Registration::where("email", $input)
                ->latest()
                ->first();
        } else {
            // Search by registration number
            $registration = Registration::where(
                "registration_number",
                $input,
            )->first();
        }

        if (!$registration) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "No registration found with the provided information. Please check and try again.",
                );
        }

        return redirect()->route("registration.show", [
            "registration" => $registration->registration_number,
        ]);
    }

    /**
     * Display the specified registration (public view).
     *
     * @param  string  $registrationNumber
     * @return \Illuminate\View\View
     */
    public function show($registrationNumber)
    {
        $registration = Registration::where(
            "registration_number",
            $registrationNumber,
        )->firstOrFail();

        return view("registration-details", compact("registration"));
    }

    /**
     * Get registration statistics for admin dashboard.
     *
     * @return array
     */
    public static function getStatistics()
    {
        return [
            "total" => Registration::count(),
            "pending" => Registration::where("status", "pending")->count(),
            "contacted" => Registration::where("status", "contacted")->count(),
            "scheduled" => Registration::where("status", "scheduled")->count(),
            "installed" => Registration::where("status", "installed")->count(),
            "active" => Registration::where("status", "active")->count(),
            "cancelled" => Registration::where("status", "cancelled")->count(),
            "today" => Registration::whereDate("created_at", today())->count(),
            "this_week" => Registration::whereBetween("created_at", [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
            "this_month" => Registration::whereMonth(
                "created_at",
                now()->month,
            )->count(),
            "plan_10mbps" => Registration::where("plan", "10mbps")->count(),
            "plan_25mbps" => Registration::where("plan", "25mbps")->count(),
            "plan_50mbps" => Registration::where("plan", "50mbps")->count(),
        ];
    }
}
