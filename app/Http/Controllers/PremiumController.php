<?php

namespace App\Http\Controllers;

use App\Models\Premium;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PremiumController extends Controller
{
    public function index($id)
    {
        return view('madaresona.schools.premium.index', compact('id'));
    }

    public function premiumDatatble(Request $request)
    {
        if ($request->ajax()) {
            $data = Premium::where('school_id', $request->school_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('class_name_en', function ($data){
                    return $data->schoolClass->class_en;
                })
                ->editColumn('curriculum', function ($data){
                    return $data->curriculum == 0 ? 'International Program' : 'Local Program';
                })
                ->make(true);
        }
    }

    public function create($id)
    {
        $classes = SchoolClass::all();
        return view('madaresona.schools.premium.create', compact('id', 'classes'));
    }

    public function edit($id)
    {
        $classes = SchoolClass::all();
        $cirruculum = [0 => 'International Program', 1 => 'Local Program' ];
        $premium = Premium::where('id', $id)->first();
        return view('madaresona.schools.premium.create', compact('premium','id', 'classes'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'school_class' => 'required',
            'curriculum' => 'required',
            'price' => 'required'
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Premium::create([
            'school_id' => $request->school_id,
            'class_id' => $request->school_class,
            'curriculum' => $request->curriculum,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function update(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'school_class' => 'required',
            'curriculum' => 'required',
            'price' => 'required'
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Premium::where('id', $request->school_id)->update([
            'class_id' => $request->school_class,
            'curriculum' => $request->curriculum,
            'price' => $request->price,
        ]);

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }
    public function destroy($id)
    {
        Premium::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
