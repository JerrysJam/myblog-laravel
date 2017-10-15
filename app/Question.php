<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    protected $fillable = [
        'title', 'body','user_id'
    ];

    public function isHidden()
    {
        return $this->is_hidden;
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'user_question')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany('App\comment','commentable');
    }

    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }

}
