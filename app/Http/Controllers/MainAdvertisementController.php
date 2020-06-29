<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainAdvertisementController extends Controller
{
    public function index()
    {
        return view('madaresona.mainAdvertisement.index');
    }

}
