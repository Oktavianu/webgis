<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class PetaController extends Controller
{
    public function index(){
        $lokasi = Lokasi::all();
        return view('peta', compact('lokasi'));
    }

    public function lokasi(){
        $results = Lokasi::all();
        return json_encode($results);
    }
}
