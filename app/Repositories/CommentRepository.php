<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/15
 * Time: 下午11:29
 */

namespace App\Repositories;
use App\Comment;
/**
 * Class CommentRepository
 * @package App\Repositories
 */
class CommentRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }
}