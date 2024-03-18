<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    protected $table = 'outboxs';
    protected $fillable = ['user_id', 'subject', 'body', 'file_upload', 'is_read'];
}
