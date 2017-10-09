<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/9
 * Time: 下午11:28
 */

namespace App\Repositories;

use App\Question;
use App\Topic;


/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function byIdWithTopics($id)
    {
        return Question::where('id',$id)->with('topics')->first();
    }

    /**
     * @param array $attributes
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    /**
     * @param $id
     * @return mixed|static
     */
    public function byId($id)
    {
        return Question::find($id);
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    /**
     * @param array $topics
     * @return array
     */
    public function normalize(array $topics)
    {
        return collect($topics)->map(function($topic){
            $topicFromDB = Topic::find($topic);
            if( $topicFromDB == null ){
                $newTopic = Topic::create(['name' => $topic , 'questions_count' => 1]);
                return $newTopic->id;
            }
            $topicFromDB->increment('questions_count');
            if(is_numeric($topic)){
                return (int)$topic;
            }
            return $topicFromDB->id;
        })->toArray();
    }


}