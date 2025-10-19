<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get statistics
        $ticketStats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'high_priority' => Ticket::where('priority', 'high')->whereIn('status', ['open', 'in_progress'])->count(),
            'today' => Ticket::whereDate('created_at', today())->count(),
            'this_week' => Ticket::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        $registrationStats = [
            'total' => Registration::count(),
            'pending' => Registration::where('status', 'pending')->count(),
            'contacted' => Registration::where('status', 'contacted')->count(),
            'scheduled' => Registration::where('status', 'scheduled')->count(),
            'active' => Registration::where('status', 'active')->count(),
            'today' => Registration::whereDate('created_at', today())->count(),
            'this_week' => Registration::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        // Get recent tickets and registrations
        $recentTickets = Ticket::latest()->take(5)->get();
        $recentRegistrations = Registration::latest()->take(5)->get();

        return view('admin.dashboard', compact('ticketStats', 'registrationStats', 'recentTickets', 'recentRegistrations'));
    }

    /**
     * Display all tickets.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function tickets(Request $request)
    {
        $query = Ticket::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $tickets = $query->latest()->paginate(20);

        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Display a specific ticket.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function ticketShow($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Update ticket status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ticketUpdate(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'admin_notes' => 'nullable|string',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $ticket->status = $request->status;
        $ticket->admin_notes = $request->admin_notes;
        $ticket->assigned_to = $request->assigned_to;

        if ($request->status === 'resolved' && !$ticket->resolved_at) {
            $ticket->resolved_at = now();
        }

        $ticket->save();

        return back()->with('success', 'Ticket updated successfully!');
    }

    /**
     * Delete a ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ticketDestroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Delete attachments if any
        if ($ticket->attachments) {
            foreach ($ticket->attachments as $attachment) {
                if (isset($attachment['path'])) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }
        }

        $ticket->delete();

        return redirect()->route('admin.tickets')->with('success', 'Ticket deleted successfully!');
    }

    /**
     * Display all registrations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function registrations(Request $request)
    {
        $query = Registration::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->has('plan') && $request->plan != '') {
            $query->where('plan', $request->plan);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(20);

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Display a specific registration.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function registrationShow($id)
    {
        $registration = Registration::findOrFail($id);

        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update registration status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrationUpdate(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,contacted,scheduled,installed,active,cancelled',
            'admin_notes' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $registration->status = $request->status;
        $registration->admin_notes = $request->admin_notes;

        if ($request->status === 'contacted' && !$registration->contacted_at) {
            $registration->contacted_at = now();
        }

        if ($request->status === 'scheduled' && $request->scheduled_at) {
            $registration->scheduled_at = $request->scheduled_at;
        }

        if ($request->status === 'installed' && !$registration->installed_at) {
            $registration->installed_at = now();
        }

        $registration->save();

        return back()->with('success', 'Registration updated successfully!');
    }

    /**
     * Delete a registration.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrationDestroy($id)
    {
        $registration = Registration::findOrFail($id);

        // Delete documents if any
        if ($registration->documents) {
            foreach ($registration->documents as $document) {
                if (isset($document['path'])) {
                    Storage::disk('public')->delete($document['path']);
                }
            }
        }

        $registration->delete();

        return redirect()->route('admin.registrations')->with('success', 'Registration deleted successfully!');
    }

    /**
     * Export tickets to CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTickets(Request $request)
    {
        $query = Ticket::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->get();

        $filename = 'tickets_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');

            // Add header row
            fputcsv($file, ['Ticket Number', 'Name', 'Email', 'Phone', 'Category', 'Priority', 'Subject', 'Status', 'Created At']);

            // Add data rows
            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->ticket_number,
                    $ticket->name,
                    $ticket->email,
                    $ticket->phone,
                    $ticket->category_name,
                    $ticket->priority,
                    $ticket->subject,
                    $ticket->status,
                    $ticket->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export registrations to CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportRegistrations(Request $request)
    {
        $query = Registration::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->get();

        $filename = 'registrations_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');

            // Add header row
            fputcsv($file, ['Registration Number', 'Full Name', 'Email', 'Phone', 'Building', 'Unit', 'Plan', 'Status', 'Preferred Date', 'Created At']);

            // Add data rows
            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->registration_number,
                    $registration->full_name,
                    $registration->email,
                    $registration->phone,
                    $registration->building,
                    $registration->floor . '-' . $registration->unit,
                    $registration->plan_name,
                    $registration->status,
                    $registration->preferred_date->format('Y-m-d'),
                    $registration->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
