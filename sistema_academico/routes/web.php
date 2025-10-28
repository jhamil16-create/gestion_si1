<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/usuarios', function () {
    return view('usuarios.index');
});

Route::get('/usuarios/create', function () {
    return view('usuarios.create');
});

Route::get('/docentes', function () {
    return view('docentes.index');
});

Route::get('/docentes/create', function () {
    return view('docentes.create');
});

Route::get('/materias', function () {
    return view('materias.index');
});

Route::get('/materias/create', function () {
    return view('materias.create');
});

Route::get('/asignaciones', function () {
    return view('asignaciones.index');
});

Route::get('/asignaciones/consulta', function () {
    return view('asignaciones.consulta');
});
