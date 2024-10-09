<?php

namespace App\Http\Controllers;

use App\Models\Encart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EncartController extends Controller
{
    // 1. Afficher la liste des encarts
    public function index()
    {
        $encarts = Encart::all();
        return view('encarts.index', compact('encarts'));
    }

    
}
