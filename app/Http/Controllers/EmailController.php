<?php

namespace App\Http\Controllers;

use App\Mail\MyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function SendEmail(){
    
    $data = [
        'name' => 'John Doe',
    ];
    
    Mail::to('peterisibor84@gmail.com')->send(new MyEmail($data));

    return response()->json(['message' => 'Email sent successfully']);
    }
}