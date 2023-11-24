<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    // Generate Token
    public function generateToken(Request $request){
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    // Sends an OTP (One-Time Password) to a user's email address for verification
    public function GenerateOtp(Request $request){
        $otp = random_int(100000, 999999);// Generate a 6-digit OTP
        $user = User::where('email', $request->email)->first();
         if ($user) {
            $user->otp = $otp;
            $user->save();
            // Send the OTP via email
            Mail::to($user->email)->send(new OtpMail($otp));
            return response()->json([
                "status"=>true,
                "message"=>"OTP sent successfully",
            ]);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    // Verify a user's email address using the provided OTP.
    public function VerifyEmail(Request $request){
        $request->validate([
            'email' => 'required',
            'otp' => 'required'
        ]);
        $email = $request->email;
        $otp = $request->otp;
        if(User::where(["email" => $email, "otp"=> $otp])->exists()){
            $userDetails = User::where(["email" => $email, "otp"=> $otp])->first();
            return response()->json([
                "status" => true,
                "message" => "Email verified successfully",
                "data" => $userDetails
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Your email could not be verify"
        ]);
    }

}