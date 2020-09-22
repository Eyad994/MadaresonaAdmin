<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $advertisement = Advertisement::where('type', 2)->first();
        return view('madaresona.mainAdvertisement.index',compact('advertisement'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'img' => 'required|mimes:jpeg,jpg,svg',
            'link' => 'required',
            'status' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }
        if (isset($request->img)) {
        $image = $request->file('img');
        $imageAdv = time() . '_mainAdv.' . $image->getClientOriginalExtension();}

        Advertisement::create(array(
            'img' => $imageAdv,
            'url' => $request->link,
            'active' => $request->status,
            'type' => 2,
            'added_by' => Auth::user()->id,

        ));

        $image->move(public_path('images'), $imageAdv);
        return response()->json(['message' => 'Added successfully', 'status' => 200]);



    }

}
