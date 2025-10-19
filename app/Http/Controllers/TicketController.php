<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'account_number' => 'nullable|string|max:50',
            'category' => 'required|string|in:no-connection,slow-connection,billing,installation,equipment,upgrade,cancellation,other',
            'priority' => 'required|string|in:low,medium,high',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB max per file
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the form for errors.');
        }

        try {
            // Handle file uploads
            $attachmentPaths = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('ticket-attachments', 'public');
                    $attachmentPaths[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];
                }
            }

            // Create the ticket
            $ticket = Ticket::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'account_number' => $request->account_number,
                'category' => $request->category,
                'priority' => $request->priority,
                'subject' => $request->subject,
                'description' => $request->description,
                'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
                'status' => 'open',
            ]);

            // TODO: Send email notification to admin
            // TODO: Send confirmation email to customer

            return back()->with('success', 'Your support ticket has been submitted successfully! Your ticket ID is: ' . $ticket->ticket_number . '. We will contact you shortly.');

        } catch (\Exception $e) {
            \Log::error('Ticket submission error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'An error occurred while submitting your ticket. Please try again or contact us directly.');
        }
    }

    /**
     * Track a ticket by ticket number or email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function track(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track_input' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Please enter a ticket ID or email address.');
        }

        $input = $request->track_input;

        // Check if input is email or ticket number
        $ticket = null;

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // Search by email - get the latest ticket
            $ticket = Ticket::where('email', $input)
                ->latest()
                ->first();
        } else {
            // Search by ticket number
            $ticket = Ticket::where('ticket_number', $input)->first();
        }

        if (!$ticket) {
            return back()
                ->withInput()
                ->with('error', 'No ticket found with the provided information. Please check and try again.');
        }

        // Return to support page with ticket data
        return back()->with('ticket', $ticket);
    }

    /**
     * Display the specified ticket (public view).
     *
     * @param  string  $ticketNumber
     * @return \Illuminate\View\View
     */
    public function show($ticketNumber)
    {
        $ticket = Ticket::where('ticket_number', $ticketNumber)->firstOrFail();

        return view('ticket-details', compact('ticket'));
    }

    /**
     * Get ticket statistics for admin dashboard.
     *
     * @return array
     */
    public static function getStatistics()
    {
        return [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'high_priority' => Ticket::where('priority', 'high')->whereIn('status', ['open', 'in_progress'])->count(),
            'today' => Ticket::whereDate('created_at', today())->count(),
            'this_week' => Ticket::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Ticket::whereMonth('created_at', now()->month)->count(),
        ];
    }
}
