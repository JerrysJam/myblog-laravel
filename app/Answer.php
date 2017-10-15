<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @package App
 */
class Answer extends Model
{
    //
    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'question_id','body'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function question()
    {
        return $this->belongsTo(Question::class);
    }


    public function comments()
    {
        return $this->morphMany('App\comment','commentable');
    }
}
