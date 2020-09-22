<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapExample;
use App\Models\School;
use App\Models\Supplier;
use App\Traits\SMS;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use SMS;

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
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'type' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $password = mt_rand(100000, 999999);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->email,
            'type' => $request->type,
            'active' => $request->active,
            'password' => Hash::make($password)
        ]);

        Mail::to($request->email)->send(new MailtrapExample($password, $request->name));

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }


    public function generatePassword($userid)
    {

        $user = User::where('id', $userid)->first();
        $password = mt_rand(100000, 999999);
        if ($user->type == 1 || $user->type == 3) {
            $phone = $user->phone;
        } elseif ($user->type == 4) {
            $supplier = Supplier::where('user_id', $userid)->first();
            if ($supplier->mobile == null) {
                $phone = $supplier->phone;
            } else {
                $phone = $supplier->mobile;
            }
        } elseif ($user->type == 5) {
            $school = School::where('user_id', $userid)->first();
            if ($school->phone == null) {
                $phone = $school->contact_person_phone;
            } else {
                $phone = $school->phone;
            }
        }
        $user->update([
            'password' => Hash::make($password),
        ]);

        if (!($phone == null)) {
            $phone = '962'.$phone;
            dd($password);
            $this->sms('تم تفعيل حسابك بنجاح كلمة السر الخاصة بك هي :', $phone , $password  );
        }
        Mail::to($user->email)->send(new MailtrapExample($password, $user->name));

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
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
            'phone' => 'required|unique:users,phone,'.$user->id,
            'active' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'active' => $request->active,
        ]);


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
