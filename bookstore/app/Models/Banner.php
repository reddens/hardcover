<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
use HasFactory;

protected $fillable = [
'title',
'description',
'image',
'link',
'button_text',
'is_active',
'order',
];

protected $casts = [
'is_active' => 'boolean',
];
}