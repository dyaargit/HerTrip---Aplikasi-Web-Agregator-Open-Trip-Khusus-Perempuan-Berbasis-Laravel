<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('category_name')->get();

        $trips = Trip::with(['category', 'organizer'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('destination', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category_id'));
            })
            ->orderBy('date')
            ->get();

        return view('user.trips.index', compact('trips', 'categories'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['category', 'organizer']);

        $bookedQuantity = (int) $trip->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('quantity');

        $remainingQuota = max(0, (int) $trip->quota - $bookedQuantity);

        return view('user.trips.show', compact('trip', 'remainingQuota'));
    }
}