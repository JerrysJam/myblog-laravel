<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $topics = \App\Topic::select(['id','name'])
        ->where('name','like','%'.$request->query('q').'%')
        ->get();
    return $topics;
});

//session 不起作用 对于 auth:api 总是401
Route::middleware('auth:api')->post('/question/follower', function (Request $request) {
    $user = Auth::guard('api')->user();
    $follow = \App\Follow::where('question_id',$request->get('question'))
                            ->where('user_id',$user->id)
                            ->count();
//    $follow = $user->follows($request->get('question'));

    return $follow ? response()->json(['followed' => true]): response()->json(['followed' => false]);
});

Route::middleware('auth:api')->post('/question/follow', function (Request $request) {
//    版本2
    $user = Auth::guard('api')->user();
    $question = \App\Question::find($request->get('question'));
    $followed = $user->followThis($question->id);
    if(count($followed['detached']) > 0){
        $question->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
//    两个if增加代码可读性
    if(count($followed['attached']) > 0){
        $question->increment('followers_count');
        return response()->json(['followed' => true]);
    }

//     版本1
//    $user = Auth::guard('api')->user();
//    $question = \App\Question::find($request->get('question'));
//    $followed = \App\Follow::where('question_id',$question->id)
//        ->where('user_id',$user->id)
//        ->first();
//    if($followed !== null){
//        $question->decrement('followers_count');
//        $followed->delete();
//        return response()->json(['followed' => false]);
//    }else {
//        $user->followThis($question->id);
//        $question->increment('followers_count');
//        return response()->json(['followed' => true]);
//    }
});

Route::get('/user/{id}/followers', 'FollowersController@index');
Route::post('/user/follow', 'FollowersController@follow');

Route::get('/answer/{id}/votes/users', 'VotesController@users');
Route::post('/answer/vote', 'VotesController@vote');

