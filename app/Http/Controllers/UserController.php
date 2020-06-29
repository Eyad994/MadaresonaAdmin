<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapExample;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {

        return view('madaresona.user.index');

    }

    public function userDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('type', 'ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('type', function ($data) {
                    if ($data->type == 1)
                        return 'Admin';
                    else if ($data->type == 3)
                        return 'Editor';
                    else if ($data->type == 5)
                        return 'School';
                    else if ($data->type == 4)
                        return 'Supplier';
                })
                ->editColumn('active', function ($data) {
                    return $data->active == 0 ? 'InActive' : 'Active';
                })
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('madaresona.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'type' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $password = mt_rand(100000, 999999);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'active' => $request->active,
            'password' => Hash::make($password)
        ]);

         Mail::to($request->email)->send(new MailtrapExample($password, $request->name));

         return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User|User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('madaresona.user.create', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validations = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'active' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $oldEmail = $user->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'active' => $request->active,
        ]);

        $newEmail = $user->email;


        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
