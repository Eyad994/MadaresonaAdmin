<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainAdvertisementController extends Controller
{

    /**
     * MainAdvertisementController constructor.
     */
    public function __construct()
    {
        $this->middleware('editor');
    }

    public function index()
    {
        return view('madaresona.mainAdvertisement.index');
    }

}
