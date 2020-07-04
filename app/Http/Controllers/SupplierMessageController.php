<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierMessage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierMessageController extends Controller
{
    public function index($id)

    {
        $supplier_name = Supplier::where('id', $id)->value('name_en');
        return view('madaresona.supplier.messages.index' ,compact('supplier_name'));
    }

    public function messagesDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = SupplierMessage::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d m Y - g:i A');
                })
                ->editColumn('seen', function ($data) {
                    return $data->seen == 0 ? 'NO' : 'Yes';
                })
                ->make(true);

        }
    }

    public function edit($id)
    {
        $messages= SupplierMessage::where('id', $id)->first();
        return view('madaresona.supplier.messages.show', compact('messages'));
    }

    public function destroy($id)
    {
        SupplierMessage::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }
}
