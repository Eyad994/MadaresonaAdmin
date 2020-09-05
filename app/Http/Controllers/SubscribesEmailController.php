<?php

namespace App\Http\Controllers;

use App\Models\SubscribesEmail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscribesEmailController extends Controller
{

    /**
     * SubscribesEmailController constructor.
     */
    public function __construct()
    {
        $this->middleware('editor');
    }

    public function index()
    {
        return view('madaresona.subscribesEmail.index');
    }

    public function subscribesEmailDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = SubscribesEmail::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->make(true);
        }
    }

    public function destroy($id)
    {
        SubscribesEmail::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
