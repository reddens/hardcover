<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
use HasFactory;

protected $fillable = [
'title',
'slug',
'description',
'isbn',
'author_id',
'category_id',
'price',
'stock',
'cover_image',
'pages',
'publisher',
'published_date',
'is_featured',
'is_active',
];

protected $casts = [
'price' => 'decimal:2',
'is_featured' => 'boolean',
'is_active' => 'boolean',
'published_date' => 'date',
];

protected static function boot()
{
parent::boot();

static::creating(function ($book) {
if (empty($book->slug)) {
$book->slug = Str::slug($book->title);
}
});
}

public function author()
{
return $this->belongsTo(Author::class);
}

public function category()
{
return $this->belongsTo(Category::class);
}

public function orderItems()
{
return $this->hasMany(OrderItem::class);
}
}