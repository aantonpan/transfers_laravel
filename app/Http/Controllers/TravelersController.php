<?php
namespace App\Http\Controllers;

use App\Models\Traveler;
use Illuminate\Http\Request;

class TravelersController extends Controller
{
    public function index()
    {
        $travelers = Traveler::all();
        return view('travelers.index', compact('travelers'));
    }

    public function create()
    {
        return view('travelers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:travelers,email',
        ]);

        Traveler::create($request->all());
        return redirect()->route('travelers.index')->with('success', 'Traveler creado exitosamente.');
    }

    public function edit(Traveler $traveler)
    {
        return view('travelers.edit', compact('traveler'));
    }

    public function update(Request $request, Traveler $traveler)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:travelers,email,' . $traveler->id,
        ]);

        $traveler->update($request->all());
        return redirect()->route('travelers.index')->with('success', 'Traveler actualizado exitosamente.');
    }

    public function destroy(Traveler $traveler)
    {
        $traveler->delete();
        return redirect()->route('travelers.index')->with('success', 'Traveler eliminado exitosamente.');
    }
}
