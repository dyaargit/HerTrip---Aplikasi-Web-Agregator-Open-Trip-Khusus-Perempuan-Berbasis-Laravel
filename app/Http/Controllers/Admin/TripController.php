<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Organizers;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['category', 'organizer'])->latest()->get();
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        $organizers = Organizers::orderBy('name')->get();

        return view('admin.trips.create', compact('categories', 'organizers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'organizer_id' => ['required', 'exists:organizers,id'],
            'title' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
        ]);

        Trip::create($validated);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Paket trip berhasil ditambahkan.');
    }

    public function edit(Trip $trip)
    {
        $categories = Category::orderBy('category_name')->get();
        $organizers = Organizers::orderBy('name')->get();

        return view('admin.trips.edit', compact('trip', 'categories', 'organizers'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'organizer_id' => ['required', 'exists:organizers,id'],
            'title' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
        ]);

        $trip->update($validated);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Paket trip berhasil diperbarui.');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'Paket trip berhasil dihapus.');
    }
}