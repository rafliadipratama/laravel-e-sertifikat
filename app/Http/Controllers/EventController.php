<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $events = Event::withCount('certificates')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('events.index', compact('events', 'search'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizer' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'signer_name' => 'required|string|max:255',
            'signer_position' => 'required|string|max:255',
            'certificate_prefix' => 'required|string|max:50',
        ]);

        $event = Event::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    public function show(Event $event, Request $request): View
    {
        $search = $request->query('search');

        $certificates = $event->certificates()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('recipient_name', 'like', "%{$search}%")
                      ->orWhere('certificate_number', 'like', "%{$search}%")
                      ->orWhere('recipient_email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('events.show', compact('event', 'certificates', 'search'));
    }

    public function edit(Event $event): View
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizer' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'signer_name' => 'required|string|max:255',
            'signer_position' => 'required|string|max:255',
            'certificate_prefix' => 'required|string|max:50',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Data acara berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Acara beserta seluruh sertifikat terkait berhasil dihapus.');
    }
}
