<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Status;
use App\School;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinanceController extends Controller
{
    public  function index()
    {
        return view('madaresona.finance.index');
    }
    //
    public function schoolsDatable(Request $request)
    {

        /* if ($request->ajax()) {
            $data = Finance::orderBy('end_date', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }*/

    }
}
