@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Add Media to Movie {{$movie->name}}</h3>
        </div>
        <div class="module-body">

                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Warning!</strong>{{ $error }}
                </div>
                @endforeach
                @endif

                @if($media->count() > 0)
                <h4>Media</h4>
                <ul class="unstyled">
                @foreach($media as $item)
                @endforeach
                </ul>
                @endif
                <br />
                {!! Form::open(array('route' => array('add-media', $movie->id), 'class'=>'form-horizontal row-fluid', 'files'=>true)) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="movies_id" value="{{ $movie->id }}">
                    <div class="control-group">
                        <label class="control-label" for="MediaName">Name</label>
                        <div class="controls">
                            {!! Form::text('name', null, ['class'=>'span8', 'placeholder'=>'Enter name here...']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MediaDescription">Description</label>
                        <div class="controls">
                            {!! Form::textarea('description', null, ['class'=>'span8', 'placeholder'=>'Enter description here...']) !!}
                            <span class="help-inline">Description for the external site.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MediaType">Type</label>
                        <div class="controls">
                            {!! Form::select('type', ['T'=>'Trailer', 'I'=>'Image'], null, ['class'=>'span8']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MediaType">Location</label>
                        <div class="controls">
                            {!! Form::select('image_type', ['F'=>'Front', 'L'=>'List'], null, ['class'=>'span8']) !!}
                        </div>
                        <span class="help-inline">
                        <ul>
                            <li>Front images will be used on the front page - 644px by 364px.</li>
                            <li>Front trailers will be used on the front page and also on the movie knowledge page - 660px by 377px.</li>
                            <li>List images will be used on the front page as the first image that is shown in lists - [FIND SIZE]</li>
                        </ul>
                        </span>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MediaFilename">File Name</label>
                        <div class="controls">
                            {!! Form::file('file_name', null, ['class'=>'span8', 'placeholder'=>'Enter filename...']) !!}
                            <span class="help-inline">Provide this field if image.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="MediaFilename">URL</label>
                        <div class="controls">
                            {!! Form::text('url', null, ['class'=>'span8', 'placeholder'=>'Enter url...']) !!}
                            <span class="help-inline">Provide this field if trailer.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Add Media</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
@endsection