@extends('layouts.app')

@section('title'){{trans('post.index.title')}}@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-lg-8">
                <h2>{{trans('post.index.title')}}</h2>
                <p>{{trans('post.index.description')}}</p><br>
            </div>
            <div class="col-sm-4 col-lg-4 text-right">
                <p><a class="btn btn-info" href="{{ url('post/create') }}">{{trans('post.index.create')}}</a></p>
                <form>
                    <div class="input-group" style="margin-bottom: 2em;">
                        <input type="text" class="form-control" name="q" placeholder="{{trans('post.index.search')}}">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="row">
            @foreach ($posts as $post)
                <div class="row">
                    <div class="col-sm-4 col-lg-4">
                        @if($post->image_cover)
                            <a href="{{ url('post', $post->id) }}"><img src="{{ $post->image_cover }}" style="width:100%"></a>
                        @endif
                    </div>
                    <div class="col-sm-8 col-lg-8">
                        <a href="{{ url('post', $post->id) }}"><h3>{{ $post->title }}</h3></a>
                        <small class="text-muted">
                            <i>{{trans('post.posted_on')}} {{ $post->created_at->format('F j, Y') }}</i></small>
                        <p>{!! str_limit($post->body, 560) !!}</p>
                        <p>
                            <a href="{{ url('post', $post->id) }}">{{trans('post.index.read_more')}}</a>
                        </p>
                        @if(!empty($post->tags))
                            <p>
                                <span>{{trans('post.tags')}}:</span>
                                @foreach ($post->tags as $tag)
                                    <a href="{{ url('/post?q=' . $tag) }}"><span
                                                class="label label-info">{{$tag}}</span></a>
                                @endforeach
                            </p>
                        @endif
                    </div>
                </div>

                <hr>
            @endforeach

            {{ $posts->appends(Request::only('q'))->links() }}
        </div>
@endsection
