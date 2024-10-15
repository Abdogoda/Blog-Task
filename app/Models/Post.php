<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model{

    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'body', 'cover_image', 'is_pinned', 'user_id'];

    //##### Function to convert the is_pinned attribute to boolean
    public function setIsPinnedAttribute($value){
        $this->attributes['is_pinned'] = $value === 'on';
    }

    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}