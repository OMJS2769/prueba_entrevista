<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Region;
use App\Models\Commune;


class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::where('status', 'A')
        ->with('region')
        ->with('commune')
        ->get();
        return response()->json($customers);
    }

    public function store(Request $request){
        if(
            isset($request->dni) &&
            isset($request->id_reg) &&
            isset($request->id_com) &&
            isset($request->email) &&
            isset($request->name) &&
            isset($request->last_name) &&
            isset($request->address) &&
            isset($request->api_token)
        ){
            $region = Region::find($request->id_reg);
            if($region){
                $commune = Commune::find($request->id_com);
                if($commune){
                    if($commune->id_reg == $request->id_reg){
                        $customers = Customer::where('dni',$request->dni)->get();

                        if(count($customers) > 0)
                        {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'dni already exists.'
                            ]);
                        }else{
                            $customer = Customer::create([
                                'dni' => strtoupper($request->dni),
                                'id_reg' => $request->id_reg,
                                'id_com' => $request->id_com,
                                'email' => $request->email,
                                'name' => $request->name,
                                'last_name' => $request->last_name,
                                'address' => $request->address,
                                'date_reg' => date('Y-m-d H:i:s'),
                                'status' => 'A'
                            ]);
                            if($customer){
                                return response()->json([
                                    'status' => 'success',
                                    'message' => 'customer stored.'
                                ]);
                            }
                        }

                    }else{
                        return response()->json([
                            'status' => 'error',
                            'message' => 'invalid region.'
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'commune does not exist.'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'region does not exist.'
                ]);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'missing parameters.'
        ]);
    }

    public function destroy(Request $request){
        $customer = Customer::find($request->customer_id);
        if($customer){
            if($customer->status == 'A'){
                $customer->status = 'I';
                $customer->save();
                return response()->json([
                    'status' => 'error',
                    'message' => 'customer destoyed'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'customer inactive'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'customer not found'
            ]);
        }
    }
}
