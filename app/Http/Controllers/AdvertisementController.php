<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdvertisementController extends Controller
{
    //
    public function index()
    {
        return view('madaresona.advertisement.index');
    }
    public function advertisementDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Advertisement::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('active', function ($data){
                    return $data->active == 0 ? 'InActive' : 'Active';
                })
                ->make(true);
        }
    }
}
