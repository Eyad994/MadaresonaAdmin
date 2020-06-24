<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
                ->editColumn('added_by', function ($data){
                    return $data->user->name;
                })
                ->make(true);
        }

    }

    public function create()
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        return view('madaresona.advertisement.create', compact( 'trueFalseArray'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'url' => 'required',
            'active' => 'required',
            'order' => 'required',
            'img' => 'required',
        ]);

        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        $userId = Auth::user()->id;
        $imageAdvertisement='';
        if (isset($request->img)) {
            $image = $request->file('img');
            $imageAdvertisement = time() . '_advertisement.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/Advertisement'), $imageAdvertisement);
        }

        Advertisement::create([
            'url' => $request->url,
            'img' => $imageAdvertisement,
            'active' => $request->active,
            'order' => $request->order,
            'added_by' => $userId,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }
    public function edit($id)
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        $advertisement = Advertisement::where('id', $id)->first();
        return view('madaresona.advertisement.create', compact('advertisement','id', 'trueFalseArray'));
    }

    public function update(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'url' => 'required',
            'active' => 'required',
            'order' => 'required',
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }


        $advertisement = Advertisement::where('id', $request->advertisement_id)->first();
        $advertisement->update([
            'url' => $request->url,
            'active' => $request->active,
            'order' => $request->order,
        ]);

        if (isset($request->img) && $request->img != $advertisement->img) {
            $image = $request->file('img');
            $imageAdvertisement = time() . '_news.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/Advertisement'), $imageAdvertisement);
            $advertisement->update([
                'img' => $imageAdvertisement
            ]);
        }
        $advertisement->save();

        return response()->json(['message' => 'Updated successfully', 'status' => 200]);
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::where('id', $id)->first();
        $file = 'images/'.'Advertisement/'.$advertisement->img;
        File::delete($file);
        $advertisement->delete();
        return response()->json(['message' => 'Successfully deleted']);
    }

}
