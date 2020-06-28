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
                ->editColumn('type', function ($data) {
                    if ($data->type == 1)
                        return 'School';
                    else if ($data->type == 2)
                        return 'Supplier';
                })
                ->editColumn('added_by', function ($data){
                    return $data->user->name;
                })
                ->make(true);
        }

    }

    public function create()

    {   $typeArray = [ 1 => 'School', 2 => 'Supplier'];
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        return view('madaresona.advertisement.create', compact( 'trueFalseArray','typeArray'));
    }

    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'url' => 'required',
            'active' => 'required',
            'order' => 'required',
            'img' => 'required',
            'type' => 'required'

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
            'type' => $request->type,
            'added_by' => $userId,
        ]);

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }
    public function edit($id)
    {
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        $typeArray = [ 1 => 'School', 2 => 'Supplier'];
        $advertisement = Advertisement::where('id', $id)->first();
        return view('madaresona.advertisement.create', compact('advertisement','id', 'trueFalseArray','typeArray'));
    }

    public function update(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'url' => 'required',
            'active' => 'required',
            'order' => 'required',
            'type' => 'required'
        ]);
        if ($validations->fails()){
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }


        $advertisement = Advertisement::where('id', $request->advertisement_id)->first();
        $advertisement->update([
            'url' => $request->url,
            'active' => $request->active,
            'order' => $request->order,
            'type' => $request->type,
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
