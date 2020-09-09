<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\School;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activeSchools = School::where('active', 1)->count();
        $onHoldSchools = School::where('status', 1)->count();
        $inCallingSchools = School::where('status', 2)->count();
        $completedSchools = School::where('status', 3)->count();
        $activeSupplier = Supplier::where('active', 1)->count();
        $inActiveSupplier = School::where('active', 0)->count();
        return view('madaresona.home', compact('activeSchools', 'onHoldSchools', 'inCallingSchools', 'completedSchools', 'activeSupplier', 'inActiveSupplier'));
    }

    public function  resetPassword()
    {
        return view('madaresona.resetPassword');
    }

    public  function  updatePassword(Request $request)
    {

        $validations = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Update Password successfully', 'status' => 200]);
    }
}
