@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @foreach($questions as $question)
                        <div class="media">
                            <div class="media-left">
                                <a href="">
                                    <img width="48" alt="64x64" src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}" style="width: 64px">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="/questions/{{ $question->id }}">
                                        {{ $question->title }}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
