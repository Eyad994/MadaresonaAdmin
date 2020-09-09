<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapExample;
use App\Models\City;
use App\Models\Finance;
use App\Models\Region;
use App\Models\Supplier;
use App\Models\SupplierMessage;
use App\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * SupplierController constructor.
     */
    public function __construct()
    {
        $this->middleware('editor');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /* return Mail::to('omer@arakjo.com')->send(new MailtrapExample('123213213'));*/
        return view('madaresona.supplier.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('special', function ($data) {
                    return $data->special == 0 ? 'General' : 'Special';
                })
                ->editColumn('active', function ($data) {
                    return $data->active == 0 ? 'InActive' : 'Active';
                })
                ->addColumn('message_count', function ($data){
                    $supplierMessage = SupplierMessage::where('user_id', $data->user_id)->where('seen', 0)->count();
                    return $supplierMessage;
                })
                ->addColumn('sn', function ($data) {
                    $finance = Finance::where('user_id', $data->user_id)->orderBy('end_date', 'desc')->first();
                    return $finance->uuids;
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
        $cities = City::all();
        $regions = Region::all();
        $lastSupplierOrder = Supplier::orderBy('id', 'desc')->value('supplier_order');
        return view('madaresona.supplier.addSupplier', compact('cities', 'regions', 'lastSupplierOrder'));
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
            'name_ar' => 'required',
            'name_en' => 'required|unique:suppliers',
            'email' => 'required|email|unique:users',
            'start' => 'date|required',
            'end' => 'date|required',
            'phone' => 'required|numeric',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if (isset($request->logo)) {
            $image = $request->file('logo');
            $logo = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/' . $request->name_en), $logo);
        }

        $supplier = Supplier::create([
            'supplier_order' => $request->supplier_order,
            'supplier_type' => implode(',', $request->type),
            'supplier_logo' => $logo,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'email' => $request->email_supplier,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'fax' => $request->fax,
            'website' => $request->website,
            'location' => $request->location,
            'supplier_details_ar' => $request->supplier_details_ar,
            'supplier_details_en' => $request->supplier_details_en,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'instagram_link' => $request->instagram_link,
            'linkedin_link' => $request->linkedin_link,
            'googleplus_link' => $request->googleplus_link,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'active' => $request->active,
            'special' => $request->special,
        ]);

        if ($supplier){

            $config = [
                'table' => 'finances',
                'length' => 13,
                'field' => 'uuids',
                'prefix' => 'MJ-S' . date('Y').'-'
            ];

            $uid = IdGenerator::generate($config);

            $password = mt_rand(100000, 999999);

            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'type' => 4
            ]);

            $supplier->update(['user_id' => $user->id]);

            $startDate = Carbon::parse($request->start)->format('Y/m/d');
            $endDate = Carbon::parse($request->end)->format('Y/m/d');

            Finance::create([
                'user_id' => $supplier->user_id,
                'uuids' => $uid,
                'balance' => $request->subscribe_price,
                'type' => $request->subscribe_type,
                'is_tax' => $request->tax,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            /* Mail::to('newuser@example.com')->send(new MailtrapExample($password));*/
        }

        return response()->json(['message' => 'Added successfully', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $supplierTypesExploded = explode(',', $supplier->supplier_type);
        $trueFalseArray = [0 => 'false', 1 => 'true'];
        $cities = City::all();
        $regions = Region::all();
        $lastSupplierOrder = Supplier::orderBy('id', 'desc')->value('supplier_order');
        if (request()->ajax())
        {
            return view('madaresona.supplier.addSupplier', compact('cities', 'regions', 'lastSupplierOrder', 'supplier', 'trueFalseArray'
                , 'supplierTypesExploded'));
        }

        return view('madaresona.supplier.editSupplier', compact('cities', 'regions', 'lastSupplierOrder', 'supplier', 'trueFalseArray'
            , 'supplierTypesExploded'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {

        if (request()->ajax())
        {
            $validations = Validator::make($request->all(), [
                'name_ar' => 'required', // name_en,' . $request->id
                'name_en' => 'required|unique:suppliers,name_en,'. $supplier->id,
                'phone' => 'required|numeric',
            ]);

            if ($validations->fails()) {
                return response()->json(['errors' => $validations->errors(), 'status' => 422]);
            }

            if (isset($request->logo) && $request->logo != $supplier->supplier_logo)
            {
                $image = $request->file('logo');
                $logo = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/' . $request->name_en), $logo);
                $supplier->update([
                    'supplier_logo' => $logo
                ]);
            }

            $supplier->update([
                'supplier_order' => $request->supplier_order,
                'supplier_type' => implode(',', $request->type),
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'email' => $request->email_supplier,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'website' => $request->website,
                'location' => $request->location,
                'supplier_details_ar' => $request->supplier_details_ar,
                'supplier_details_en' => $request->supplier_details_en,
                'facebook_link' => $request->facebook_link,
                'twitter_link' => $request->twitter_link,
                'instagram_link' => $request->instagram_link,
                'linkedin_link' => $request->linkedin_link,
                'googleplus_link' => $request->googleplus_link,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'city_id' => $request->city_id,
                'region_id' => $request->region_id,
                'active' => $request->active,
                'special' => $request->special,
            ]);

            $supplier->save();

            return response()->json(['message' => 'Updated successfully', 'status' => 200]);
        } else {
            $request->validate([
                'name_ar' => 'required', // name_en,' . $request->id
                'name_en' => 'required|unique:suppliers,name_en,'. $supplier->id,
                'phone' => 'required|numeric',
            ]);

            if (isset($request->logo) && $request->logo != $supplier->supplier_logo)
            {
                $image = $request->file('logo');
                $logo = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/' . $request->name_en), $logo);
                $supplier->update([
                    'supplier_logo' => $logo
                ]);
            }

            $supplier->update([
                'supplier_order' => $request->supplier_order,
                'supplier_type' => implode(',', $request->type),
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'email' => $request->email_supplier,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'website' => $request->website,
                'location' => $request->location,
                'supplier_details_ar' => $request->supplier_details_ar,
                'supplier_details_en' => $request->supplier_details_en,
                'facebook_link' => $request->facebook_link,
                'twitter_link' => $request->twitter_link,
                'instagram_link' => $request->instagram_link,
                'linkedin_link' => $request->linkedin_link,
                'googleplus_link' => $request->googleplus_link,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'city_id' => $request->city_id,
                'region_id' => $request->region_id,
                'active' => $request->active,
                'special' => $request->special,
            ]);

            $supplier->save();

            return back()->with(['success' => 'تم التعديل بنجاح']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
       $supplier->delete();
    }
}
