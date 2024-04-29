<?php
// <!-- CompComponentController.php -->

namespace App\Http\Controllers;

// CompComponentController.php

use Illuminate\Http\Request;
use App\Models\CompComponent;
use Illuminate\Support\Facades\Storage;

class CompComponentController extends Controller
{
    public function showList()
    {
        $compComponents = CompComponent::all();
        return view('computerComponent.comp-component', compact('compComponents'));
    }

    public function create()
    {
        return view('computerComponent.add-compComp');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'picture' => 'nullable|image',
            'name' => 'string',
            'vendor' => 'string',
            'description' => 'string',
            'quantity' => 'integer',
            'category' => 'string',
            'price' => 'numeric',
        ]);

        if ($request->hasFile('picture')) {
            $validatedData['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        CompComponent::create($validatedData);

        return redirect()->route('showCompComponents');
    }

    public function edit(CompComponent $compComponent)
    {
        return view('computerComponent.edit-compComp', compact('compComponent'));
    }

    public function update(Request $request, CompComponent $compComponent)
    {
        $validatedData = $request->validate([
            'picture' => 'nullable|image',
            'name' => 'string',
            'vendor' => 'string',
            'description' => 'string',
            'quantity' => 'integer',
            'category' => 'string',
            'price' => 'numeric',
        ]);

        if ($request->hasFile('picture')) {
            if ($compComponent->picture) {
                Storage::disk('public')->delete($compComponent->picture);
            }
            $validatedData['picture'] = $request->file('picture')->store('pictures', 'public');
        } else {
            $validatedData['picture'] = $compComponent->picture;
        }

        $compComponent->update($validatedData);

        return redirect()->route('showCompComponents');
    }

    public function destroy(CompComponent $compComponent)
    {
        if ($compComponent->picture) {
            Storage::disk('public')->delete($compComponent->picture);
        }

        $compComponent->delete();

        return redirect()->route('showCompComponents')->with('success', 'Component deleted successfully.');
    }
}
