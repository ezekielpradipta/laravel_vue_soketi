<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inboxs';
    protected $fillable = ['sender_id', 'receiver_id', 'subject', 'body', 'file_upload', 'is_read'];
}
