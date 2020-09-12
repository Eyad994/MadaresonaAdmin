<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RequestsController extends Controller
{
    public function index()
    {
        return view('madaresona.requests.index');
    }

    public function requestsDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Requests::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->editColumn('type', function ($data) {
                    if ($data->type == 2)
                        return 'School';
                    else if ($data->type == 1)
                        return 'Supplier';
                })
                ->make(true);
        }
    }

    public function destroy($id)
    {
        Requests::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
