<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('pages.import', compact('user'));
    }

    public function store(Request $request)
    {
        // TODO: Implement Excel/CSV import functionality
        return redirect()->route('library')->with('success', 'Archivo importado exitosamente');
    }
}
