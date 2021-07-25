<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Registration;
use App\Models\SchoolClass;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RegistrationController extends Controller
{
    /**
     * RegistrationController constructor.
     */
    public function __construct()
    {
        $this->middleware('editor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('madaresona.registration.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('madaresona.registration.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'schools' => 'required',
            'class_id' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Registration::create([
            'schools' => implode(',', $request->schools),
            'class_id' => $request->class_id,
            'parent' => $request->parent,
            'child' => $request->student,
            'number' => $request->phone_number,
            'by_admin' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Registration $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Registration $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        $schoolsArray = explode(',', $registration->schools);
        return view('madaresona.registration.create', compact('registration', 'schoolsArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Registration $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        $validations = Validator::make($request->all(), [
            'schools' => 'required',
            'class_id' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $registration->update([
            'schools' => implode(',', $request->schools),
            'class_id' => $request->class_id,
            'parent' => $request->parent,
            'child' => $request->student,
            'number' => $request->phone_number,
        ]);

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Registration $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        $registration->delete();
    }

    public function registrationDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Registration::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('schools', function ($data) {
                    $schoolsArray = explode(',', $data->schools);
                    $schools = School::whereIn('id', $schoolsArray)->get('name_ar')->toArray();
                    $schoolsString = '';
                    foreach ($schools as $school) {
                        $schoolsString .= $school['name_ar'] . ',';
                    }
                    return $schoolsString;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d-m-Y ');
                })
                ->editColumn('by_admin', function ($data) {
                    return $data->user->name;
                })
                ->editColumn('class_id', function ($data) {
                    return $data->schoolClass->class_en;
                })
                ->make(true);
        }
    }

    public function note($id)
    {
        $note = Note::where('registration_id', $id)->get();
        return view('madaresona.registration.note', compact('id', 'note'));
    }

    public function storeNote(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'note_text' => 'required',
        ]);
        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Note::create([
            'note' => $request->note_text,
            'added_by' => auth()->user()->id,
            'registration_id' => $request->registration_id
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function destroyNote($id)
    {
        dd($id);
    }
}
