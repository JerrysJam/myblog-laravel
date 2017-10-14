@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                <div class="panel panel-default">
                    <div class="peanl-heading">通知消息</div>
                    <div class="panel-body">
                        @foreach( $user->notifications as $notification )
                            @include('notifications.'.snake_case(class_basename($notification->type)))
{{--                            {{ snake_case(class_basename($notification->type)) }}--}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection