<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FollowersController extends Controller
{
    protected $user;

    /**
     * FollowersController constructor.
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id)
    {
        $user = $this->user->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();

        if(in_array(Auth::guard('api')->user()->id, $followers)){
            return response()->json(['followed' => true]);
        }

        return response()->json(['followed' => false]);
    }

    public function follow(Request $request)
    {
        $userToFollow = $this->user->byId($request->get('user'));
        $follow = Auth::guard('api')->user()->followThisUser($userToFollow->id);

        if(count($follow['detached']) > 0){
            //
            $userToFollow->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
//    两个if增加代码可读性
        if(count($follow['attached']) > 0){
            //
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');
            return response()->json(['followed' => true]);
        }
    }
}
