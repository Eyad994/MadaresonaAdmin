<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    public function index()
    {
        return view('madaresona.discountForms.index');
    }

    public function discountDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Discount::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->editColumn('class_id', function ($data){
                    return $data->level->class_en;
                })
                ->editColumn('city_id', function ($data){
                    return $data->city->city_name_ar;
                })
                ->editColumn('region_id', function ($data){
                    return $data->region->area_name_ar;
                })


                ->make(true);
        }
    }

    public function destroy($id)
    {
        Discount::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
