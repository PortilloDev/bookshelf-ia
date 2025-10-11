<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Mostrar la página de Política de Cookies
     */
    public function cookies()
    {
        return view('pages.legal.cookies');
    }

    /**
     * Mostrar la página de Aviso Legal
     */
    public function legal()
    {
        return view('pages.legal.legal');
    }

    /**
     * Mostrar la página de Política de Privacidad
     */
    public function privacy()
    {
        return view('pages.legal.privacy');
    }
}
