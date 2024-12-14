<?php
namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelsController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hotels,email',
        ]);

        Hotel::create($request->all());
        return redirect()->route('hotels.index')->with('success', 'Hotel creado exitosamente.');
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hotels,email,' . $hotel->id,
        ]);

        $hotel->update($request->all());
        return redirect()->route('hotels.index')->with('success', 'Hotel actualizado exitosamente.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel eliminado exitosamente.');
    }
}
