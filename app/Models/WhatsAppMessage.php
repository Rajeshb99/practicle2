<?php

// Example WhatsAppMessage model

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppMessage extends Model
{
    use HasFactory;
    protected $table = "whatsapp_messages";
    protected $fillable = ['from', 'body'];
}

