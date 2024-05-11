<?php

namespace App\Models;

use App\Traits\LogChangesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    // Book model
    use LogChangesTrait;

// Tag model

    public function books()
    {
        return $this->morphedByMany(Book::class, 'taggable');
    }


}
