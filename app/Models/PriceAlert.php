<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PriceAlert extends Model
{
    use HasFactory, HasApiTokens;
    protected $guarded = [];

//     public function user(){
// 	return $this->belongsTo(User::class, 'email_id', 'id');
// }
}