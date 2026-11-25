<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizers;
use Illuminate\Http\Request;

class OrganizersController extends Controller
{
    public function index()
    {
        $organizers = Organizers::latest()->get();

        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'verification_status' => ['required', 'in:pending,verified'],
        ]);

        Organizers::create($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer berhasil ditambahkan.');
    }

    public function edit(Organizers $organizer)
    {
        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, Organizers $organizer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'verification_status' => ['required', 'in:pending,verified'],
        ]);

        $organizer->update($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Data organizer berhasil diperbarui.');
    }

    public function destroy(Organizers $organizer)
    {
        $organizer->delete();

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Data organizer berhasil dihapus.');
    }
}