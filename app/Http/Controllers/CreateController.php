<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saran;

class CreateController extends Controller
{
    public function storeSaran(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'saran' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipe' => 'required|string|in:sehat,hati-hati,danger',
        ]);

        try {
            $imageName = time().'.'.$request->gambar->extension();  
            $request->gambar->storeAs('public/images', $imageName);

            Saran::create([
                'name' => $request->name,
                'saran' => $request->saran,
                'gambar' => $imageName,
                'tipe' => $request->tipe,
            ]);

            return redirect()->route('dashboardAdmin')->with('success', 'Saran has been added');
        } catch (\Exception $e) {
            return redirect()->route('dashboardAdmin')->with('error', 'Error: '.$e->getMessage());
        }
    }
}
