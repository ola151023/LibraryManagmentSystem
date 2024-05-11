<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogChangesTrait;
class Author extends Model
{
    use HasFactory;
    protected $fillable=[];
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
