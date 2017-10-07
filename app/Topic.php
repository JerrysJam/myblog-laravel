<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title', 'questions_count'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
