<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Paymenet;
use App\Models\Status;
use App\School;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FinanceController extends Controller
{
    public function index()
    {
        return view('madaresona.finance.index');
    }

    public function financeDatable(Request $request)
    {
        if ($request->ajax()) {
            $finance = Finance::with('user')->orderBy('end_date', 'desc')->get();
            $data = $finance->unique('user_id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_finance_id', function ($data) {
                    return $data->user_id;
                })
                ->editColumn('user_id', function ($data) {
                    $userType = $data->user->type;
                    if ($userType == 5)
                        return School::where('user_id', $data->user_id)->value('name_en');
                    else if ($userType == 4)
                        return 'Supplier Name';
                    else
                        return null;
                })
                ->editColumn('is_tax', function ($data) {
                    return $data->is_tax == 0 ? 'True' : 'false';
                })
                ->editColumn('end_date', function ($data) {
                    return $data->end_date;
                })
                ->addColumn('school_supplier', function ($data) {
                    return $data->user->type == 5 ? 'School' : 'Supplier';
                })
                ->addColumn('diff_days', function ($data) {
                    $date = Carbon::parse($data->end_date);
                    $now = Carbon::now();
                    if ($date > $now)
                        return $date->diffInDays($now);
                    else
                        return -$date->diffInDays($now);
                })
                ->make(true);
        }
    }

    public function subscription($id)
    {
        $finance = Finance::where('user_id', $id)->latest()->get();
        return view('madaresona.finance.subscription', compact('finance'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'balance' => 'required',
            'type' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $config = [
            'table' => 'finances',
            'length' => 13,
            'field' => 'uuid',
            'prefix' => 'MJ-M' . date('Y') . '-'
        ];

        $uid = IdGenerator::generate($config);

        $startDate = Carbon::parse($request->start)->format('Y/m/d');
        $endDate = Carbon::parse($request->end)->format('Y/m/d');

        Finance::create([
            'user_id' => $request->user_id,
            'uuid' => $uid,
            'balance' => $request->balance,
            'type' => $request->type,
            'is_tax' => $request->tax,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);

    }

    public function destroy($id)
    {
        $subscription = Finance::where('id', $id)->first();
        $subscription->delete();
    }

    public function payment($id)
    {
        $lastFinance = Finance::where('user_id', $id)->orderBy('end_date', 'desc')->get();
        $financeLastRow = $lastFinance->unique('user_id')[0];
        $financeId = $financeLastRow->id;

        $finance = Finance::where('user_id', $id)->get('id');
        $payment = Paymenet::whereIn('finance_id', $finance)->latest()->get();

        return view('madaresona.finance.payment', compact('payment', 'financeId'));
    }

    public function storePayment(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'payed' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        Paymenet::create([
            'finance_id' => $request->finance_id,
            'payed' => $request->payed,
            'added_by' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);

    }

    public function destroyPayment($id)
    {
        $payment = Paymenet::where('id', $id)->first();
        $payment->delete();
    }
}
