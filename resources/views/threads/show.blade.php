@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{$thread->body}}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center ">
        <div class="col-md-8">
            <div class="card">
                 @foreach ($thread->replies as $reply)
                    @include ('threads.reply')
                @endforeach
                
            </div>
        </div>
    </div>

    @if (auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="{{ $thread->path() . '/replies' }}" >
                    @csrf
                    <div class="form-group">
                        <label for="body" for="">Body:</label>
                        <textarea name="body" id="body" class="form-control" cols="30" rows="5" placeholder="How something to say?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
    </div>
    @else
        <p>Please <a href=" {{ route('login') }}"> sign in</a> to participate in this discussion</p>
    @endif
    
</div>
@endsection
