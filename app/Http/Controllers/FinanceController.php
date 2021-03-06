<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Paymenet;
use App\Models\Status;
use App\Models\Supplier;
use App\Models\School;
use App\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FinanceController extends Controller
{

    /**
     * FinanceController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

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
                        return School::withTrashed()->where('user_id', $data->user_id)->value('name_en');
                    else if ($userType == 4)
                        return Supplier::withTrashed()->where('user_id', $data->user_id)->value('name_en');
                    else
                        return null;
                })
                ->editColumn('is_tax', function ($data) {
                    return $data->is_tax == 1 ? 'True' : 'false';
                })
                ->editColumn('end_date', function ($data) {
                    return $data->end_date;
                })->editColumn('uuid', function ($data) {
                    return $data->user->type == 5 ? $data->uuid : $data->uuids;
                })
                ->addColumn('school_supplier', function ($data) {
                    return $data->user->type == 5 ? 'School' : 'Supplier';
                })
                ->addColumn('total_amount', function ($data) {
                    $subscriptions = Finance::where('user_id', $data->user_id)->sum('balance');
                    $payments = Paymenet::where('user_id', $data->user_id)->sum('payed');
                    return $subscriptions - $payments;
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
        $finance = Finance::where('user_id', $id)->latest()->paginate(3);
        return view('madaresona.finance.subscription', compact('finance'));
    }

    public function store(Request $request)
    {
        $userType = User::where('id', $request->user_id)->value('type');

        $validations = Validator::make($request->all(), [
            'balance' => 'required|numeric',
            'type' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $config = [
            'table' => 'finances',
            'length' => 13,
            'field' => $userType == 5 ? 'uuid' : 'uuids',
            'prefix' => $userType == 5 ? 'MJ-M' . date('Y') . '-' : 'MJ-S' . date('Y') . '-'
        ];

        $uid = IdGenerator::generate($config);

        $startDate = Carbon::parse($request->start)->format('Y/m/d');
        $endDate = Carbon::parse($request->end)->format('Y/m/d');

        Finance::create([
            'user_id' => $request->user_id,
            'uuid' => $userType == 5 ? $uid : null,
            'uuids' => $userType == 4 ? $uid : null,
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

    public function payment($userId)
    {
        $payment = Paymenet::where('user_id', $userId)->get();
        return view('madaresona.finance.payment', compact('payment', 'userId'));
    }

    public function storePayment(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'payed' => 'required|numeric',
            'date' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $dateMonthArray = explode('-', $request->date);
        $day = $dateMonthArray[0];
        $month = $dateMonthArray[1];
        $year = $dateMonthArray[2];


        $date = Carbon::createFromDate($year, $month, $day);

        Paymenet::create([
            'user_id' => $request->user_id,
            'date' => $date,
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


    public function getSubscription($id)
    {
        $subscription = Finance::where('id', $id)->first();
        if ($subscription->uuid == '')
            $uuid = $subscription->uuids;
        else
            $uuid = $subscription->uuid;
        return $uuid;
    }

    public function editSubscription($id, $uid)
    {
        $subscription = Finance::where('id', $id)->first();
        $type = $subscription->user->type;

        if ($uid == '0')
        {
            if ($subscription->uuid == '')
            {
                $subscription->update([
                    'uuids' => null
                ]);
            } else {
                $subscription->update([
                    'uuid' => null
                ]);
            }
            return response()->json(['message' => 'Updated successfully', 'status' => 200]);
        }

        if ($type == 4) {
            $validation = Finance::where('uuids', $uid)->first();
            if (is_null($validation)) {
                $subscription->update(['uuids' => $uid]);
                return response()->json(['message' => 'Updated successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => 'Please choose another SN', 'status' => 422]);
            }
        } else if ($type == 5) {
            $validation = Finance::where('uuid', $uid)->first();
            if (is_null($validation)) {
                $subscription->update(['uuid' => $uid]);
                return response()->json(['message' => 'Updated successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => 'Please choose another SN', 'status' => 422]);
            }
        }


    }


}
