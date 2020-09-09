<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransportationController extends Controller
{
    public function index($id)
    {
        $school_name= School::where('id', $id)->value('name_en');
        return view('madaresona.schools.transportation.index', compact('id','school_name'));
    }

    public function transportationDatatble(Request $request)
    {
        if ($request->ajax()) {
            $data = Transportation::where('school_id', $request->school_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

    }

    public function create($id)
    {
        return view('madaresona.schools.transportation.create', compact('id'));
    }

    public function edit($id)
    {
        $transportation = Transportation::where('id', $id)->first();
        return view('madaresona.schools.transportation.create', compact('transportation','id'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'region_ar' => 'required',
            'region_en' => 'required'
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Transportation::create([
            'school_id' => $request->school_id,
            'region_ar' => $request->region_ar,
            'region_en' => $request->region_en,
            'one_way' => $request->one_way,
            'two_way' => $request->two_way,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function update(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'region_ar' => 'required',
            'region_en' => 'required'
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Transportation::where('id', $request->school_id)->update([
            'region_ar' => $request->region_ar,
            'region_en' => $request->region_en,
            'one_way' => $request->one_way,
            'two_way' => $request->two_way,
        ]);

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }
    public function destroy($id)
    {
        Transportation::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }


}
