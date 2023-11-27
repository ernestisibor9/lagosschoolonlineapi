<?php

namespace App\Http\Controllers;

use App\Models\PriceAlert;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PriceAlertController extends Controller
{
    // Create Price Alert
    public function CreatePriceAlert(Request $request){
        $request->validate([
            'email' => 'required|email',
            'target_price' => 'required|numeric',
            'date'=>'required|date',
            'action' => 'required',
            'stock_symbol' => 'required',
        ]);
        $otp = $request->header('Otp');
        $email = $request->header('Email');
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
        PriceAlert::insert([
            'email'=>$request->email,
            'target_price'=> $request->target_price,
            'date'=> $request->date,
            'action'=> $request->action,
            'stock_symbol'=> $request->stock_symbol,
            'created_at'=> Carbon::now()
        ]);
        return response()->json([
            "status"=> true,
            "message"=> "Price alert created successfully"
        ]);
    }
    }

    // Returns all price alerts after verification
    public function PriceAlert(Request $request){
        // $authorization = $request->header('Authorization');
        // $contentType = $request->header('Content-Type');
        $otp = $request->header('Otp');
        $email = $request->header('Email');

        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
            $price_alert = PriceAlert::where(["email" => $email])->first();
            return response()->json([
                "status" => true,
                "message" => "Price alerts retrieved successfully",
                "data" => $price_alert
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Price could not be verified"
        ]);
    }

    // Returns a list of all stocks
    public function GetAllStock(){
         $price_alert = PriceAlert::latest()->get();
        if(!empty($price_alert)){
            return response()->json([
            "status" => true,
            "message"=> "Stocks retrieved successfully",
            "data" => $price_alert
        ]);
        }
        return response()->json([
            "status" => false,
            "message"=> "No stock"
        ]);
    }

    // Get Single Price Alert
    public function GetSingleStock(Request $request, $id){
         $otp = $request->header('Otp');
         $email = $request->header('Email');
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
            $price_alert = PriceAlert::where(['id'=> $id])->first();
            if(!empty($price_alert)){
            return response()->json([
            "status" => true,
            "message"=> "Price alerts retrieved successfully",
            "data" => $price_alert
            ]);
         }
        }
        return response()->json([
            "status" => false,
            "message"=> "No price alert"
        ]);
    }


    // Edit
    public function EditPriceAlert(Request $request, $id){
        $otp = $request->header('Otp');
        $email = $request->header('Email');
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
        $price_alert = PriceAlert::findOrFail($id);
        return response()->json($price_alert);
        }
    }

    // Update
    public function UpdatePriceAlert(Request $request, $id){
        $request->validate([
            'target_price' => 'required|numeric',
        ]);
        $otp = $request->header('Otp');
        $email = $request->header('Email');
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
        PriceAlert::findOrFail($id)->update([
            'target_price'=> $request->target_price,
        ]);
         return response()->json([
            "status" => true,
            "message"=> "Price alert updated successfully"
        ]);
        }
        return response()->json([
            "status" => false,
            "message"=> "Unable to update"
        ]);
    }

    // Delete
    public function DeletePriceAlert(Request $request, $id){
        $otp = $request->header('Otp');
        $email = $request->header('Email');
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
        PriceAlert::findOrFail($id)->delete();
        return response()->json([
            "status" => 'success',
            "message"=> "Price alert deleted successfully"
        ]);
        }
    }
}