<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    /**
     * SaleController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('madaresona.sales.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $sale = Sale::orderBy('date', 'desc')->get();
            $data = $sale->unique('user_id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($data){
                    return $data->user->name;
                })
                ->editColumn('department_id', function ($data){
                    return $data->department->name;
                })
                ->editColumn('date', function ($data){
                    return $data->date->format('m-Y');
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
        $users = User::where('type', 1)->orWhere('type', 2)->orWhere('type', 3)->get();
        return view('madaresona.sales.create', compact('users'));
    }

    public function targets($userId)
    {
        $departmentId = Sale::where('user_id', $userId)->first()->value('department_id');
        $targets = Sale::where('user_id', $userId)->paginate(3);
        return view('madaresona.sales.targets', compact('userId', 'departmentId', 'targets'));
    }

    public function storeTarget(Request $request)
    {

        $validations = Validator::make($request->all(), [
            'date' => 'required',
            'target' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $dateMonthArray = explode('-', $request->date);
        $month = $dateMonthArray[0];
        $year = $dateMonthArray[1];

        $date = Carbon::createFromDate($year, $month, 1);

        Sale::create([
            'date' => $date,
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
            'target' => $request->target
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);

    }

    public function destroyTarget($id)
    {
        $sale = Sale::where('id', $id)->first();
        $sale->delete();
        return response()->json(['message' => 'Deleted successfully', 'status' => 200]);
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
            'user_id' => 'required|unique:sales',
            'department' => 'required',
            'date' => 'required',
            'target' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $dateMonthArray = explode('-', $request->date);
        $month = $dateMonthArray[0];
        $year = $dateMonthArray[1];

        $date = Carbon::createFromDate($year, $month, 1);

        Sale::create([
            'date' => $date,
            'user_id' => $request->user_id,
            'department_id' => $request->department,
            'target' => $request->target
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $users = User::where('type', 1)->orWhere('type', 2)->orWhere('type', 3)->get();
        return view('madaresona.sales.create', compact('users', 'sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $validations = Validator::make($request->all(), [
            'user_id' => 'required',
            'department' => 'required',
            'date' => 'required',
            'target' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $dateMonthArray = explode('-', $request->date);
        $month = $dateMonthArray[0];
        $year = $dateMonthArray[1];

        $date = Carbon::createFromDate($year, $month, 1);

        $sale->update([
            'date' => $date,
            'user_id' => $request->user_id,
            'department_id' => $request->department,
            'target' => $request->target
        ]);

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
