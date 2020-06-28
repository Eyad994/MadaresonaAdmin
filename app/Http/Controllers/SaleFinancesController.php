<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\SaleFinance;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Yajra\DataTables\Facades\DataTables;

class SaleFinancesController extends Controller
{
    public function index($id)
    {
        $user_name = User::where('id', $id)->value('name');
        return view('madaresona.salesFinances.index', compact('user_name', 'id'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = SaleFinance::where('user_id', $request->user_id)->select(DB::raw('MONTH(date) As month, sum(amount) As sum_amount, YEAR(date) as year'))->groupBy(['month', 'year'])->get('year');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return $data->month . '-' . $data->year;
                })
                ->addColumn('target', function ($data){
                    return Sale::whereMonth('date', $data->month)->whereYear('date', $data->year)->value('target');
                })
                ->make(true);
        }
    }

    public function create($userId)
    {
       // $saleFinances = SaleFinance::where('user_id', $userId)->paginate(5);
        return view('madaresona.salesFinances.create', compact('userId'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'user_id' => 'required',
            'number' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $request->date = Carbon::parse($request->date)->timestamp;

        SaleFinance::create([
            "user_id" => $request->user_id,
            "number" => $request->number,
            "amount" => $request->amount,
            "date" => $request->date,
            'added_by' => auth()->user()->id
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    public function update(Request $request)
    {

    }

    public function edit($userId, $month, $year)
    {
        $saleFinances = SaleFinance::where('user_id', $userId)->whereMonth('date', $month)->whereYear('date', $year)->paginate(5);
        return view('madaresona.salesFinances.view', compact( 'saleFinances'));
    }

    public function destroy($id)
    {
        $salesFinance = SaleFinance::where('id', $id)->first();
        $salesFinance->delete();
    }
}
