<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\PriceAlert;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // 
    public function MarketNews(){
        $market_news = News::latest()->get();
        if(!empty($market_news)){
            return response()->json([
            "status" => true,
            "message"=> "Market news retrieved successfully",
            "data" => $market_news
        ]);
        }
        return response()->json([
            "status" => false,
            "message"=> "No news"
        ]);
    }

    // Market
    // Get Single Price Alert
    public function SingleMarketNews(Request $request, $id){
         $otp = $request->header('Otp');
         $email = $request->header('Email');
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
            $market_news = News::where(['id'=> $id])->first();
            if(!empty($market_news)){
            return response()->json([
            "status" => true,
            "message"=> "Market news details retrieved successfully",
            "data" => $market_news
            ]);
         }
        }
        return response()->json([
            "status" => false,
            "message"=> "No market news"
        ]);
    }
}
