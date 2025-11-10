<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista de notificaciones.
     * Vista simple sin consultas a base de datos.
     */
    public function index()
    {
        return view('notificaciones.index');
    }
}