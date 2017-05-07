@extends('layouts.app')

@section('title'){{ $post->title }}@stop

@section('content')
    <div class="container">

        <h2>{{ $post->title }}</h2>
        @if($post->image_full)
            <div class="text-center">
                <img src="{{ $post->image_full }}" style="max-height:400px">
            </div>
        @endif

        <div>{!! $post->body !!}</div>

        <p>
            <small class="text-muted">
                <i>{{trans('post.posted_on')}} {{ $post->created_at->format('F j, Y') }} {{trans('post.by')}} {{ ($post->user)? $post->user->name : trans('post.without_author') }}</i>
            </small>
        </p>

        @if(!empty($post->tags))
            <p>
                <span>{{trans('post.tags')}}:</span>
                @foreach ($post->tags as $tag)
                    <a href="{{ url('/post?q=' . $tag) }}"><span class="label label-info">{{$tag}}</span></a>
                @endforeach
            </p>
        @endif
        <p>
            <a href="{{url('/post')}}">{{trans('post.back')}}</a>
        </p>
    </div>
@endsection
