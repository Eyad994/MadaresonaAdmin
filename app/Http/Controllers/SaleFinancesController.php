<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleFinance;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Yajra\DataTables\Facades\DataTables;

class SaleFinancesController extends Controller
{
    public function index($id)
    {
        $user_name= User::where('id', $id)->value('name');
        return view('madaresona.salesFinances.index',compact('user_name','id'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $sale = SaleFinance::where('user_id',$request->user_id)->orderBy('date', 'desc')->get();
            $data = $sale->unique('date');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($data){
                    return $data->date->format('m-Y');
                })
                ->make(true);
        }
    }

}
