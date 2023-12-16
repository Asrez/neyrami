<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedMsg extends Model
{
    use HasFactory;

    protected $table='received_messages';

    protected $fillable=['user_id','message_id'];

}
