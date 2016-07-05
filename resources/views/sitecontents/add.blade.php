@extends('layouts.admin')

@section('content')
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
@if($type == 'F' || $type == 'M')
<script>
tinymce.init({
  selector: '#summary',
  height: 100,
  toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ]
});
</script>
@endif
@if($type != 'F')
<script>
tinymce.init({
  selector: '#body',
  height: 300,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
  ],
  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ]
});
</script>
@endif
<div class="content">

    <div class="module">
        <div class="module-head">
            @if($type == 'N')
            <h3>Add News Content</h3>
            @elseif($type == 'C')
            <h3>Add Page Content</h3>
            @elseif($type == 'F')
            <h3>Add Front Slider</h3>
            @elseif($type == 'M')
            <h3>Add Movie Review</h3>
            @endif
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

                <br />
                {!! Form::open(array('route' => 'sitecontent.store', 'class'=>'form-horizontal row-fluid', 'files'=>true)) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="owners_id" value="{{ $authUser->id }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    @if($type == 'M')
                    <input type="hidden" name="movies_id" value="{{ $movie->id }}">
                    @endif

                    @if(!is_null($movie))
                    <p>Adding a review for the movie <strong>{{$movie->name}}</strong>.</p>
                    @endif

                    @if($type == 'C')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentSection">Section / Page</label>
                        <div class="controls">
                            {!! Form::select('section', $sections, null, ['class'=>'span4']) !!}
                            <span class="help-inline">Select page that is to added (you can only add one Page Content for each page except the news/blog pages).</span>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="section" value="NEW">
                    @endif

                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Title</label>
                        <div class="controls">
                            {!! Form::text('title', null, ['class'=>'span8', 'placeholder'=>'Heading for content']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                            <span class="help-inline">SEO: Used in link of all search engines.</span>
                        </div>
                    </div>

                    @if($type == 'N' || $type == 'F' || $type == 'M')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentSummary">Summary</label>
                        <div class="controls">
                            {!! Form::textarea('summary', null, ['class'=>'span8', 'placeholder'=>'Brief description of content...', 'id'=>'summary', 'maxlength'=>300]) !!}
                        </div>
                    </div>
                    @endif

                    @if($type != 'F')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentBody">Body</label>
                        <div class="controls">
                            {!! Form::textarea('body', null, ['class'=>'span8', 'placeholder'=>'WYSIWYG here...', 'id'=>'body', 'maxlength'=>4000]) !!}
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="body" value="NOT NEEDED">
                    @endif

                    @if($type == 'F')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Link/URL</label>
                        <div class="controls">
                            {!! Form::text('link_url', null, ['class'=>'span8', 'placeholder'=>'Link or URL']) !!}
                            <span class="help-inline">Link to page within site or external.</span>
                            <span class="help-inline">Don't include the domain for internal pages.</span>
                        </div>
                    </div>
                    @endif

                    @if($type == 'N' || $type == 'F')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentThumbnail">Thumbnail</label>
                        <div class="controls">
                            {!! Form::file('thumbnail', null, ['class'=>'span8']) !!}
                            @if($type == 'F')
                            <span class="help-inline">The size of this image needs to be 75px by 45px or else it will be squashed.</span>
                            @else
                            <span class="help-inline">For use in lists. The size of this image needs to be 60px by 45px or else it will be squashed.</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="control-group">
                        <label class="control-label" for="SiteContentMainImage">Main Image</label>
                        <div class="controls">
                            {!! Form::file('main_image', null, ['class'=>'span8']) !!}
                            @if($type == 'F')
                            <span class="help-inline">The size of this image needs to be 1207px by 440px or else it will be squashed.</span>
                            @else
                            <span class="help-inline">The size of this image needs to be 644px by 300px.</span>
                            @endif
                        </div>
                    </div>

                    @if($type != 'F')
                    <h4>SEO</h4>
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Keywords</label>
                        <div class="controls">
                            {!! Form::text('meta_keywords', null, ['class'=>'span8', 'placeholder'=>'Keywords', 'maxlength'=>70]) !!}
                            <span class="help-inline">Not hugely relevant - only Yahoo uses this now - 70 chars.</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Description</label>
                        <div class="controls">
                            {!! Form::text('meta_description', null, ['class'=>'span8', 'placeholder'=>'Meta description', 'maxlength'=>155]) !!}
                            <span class="help-inline">Used in most searches - max of 155 chars normally.</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Add Content</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    
    
</div>
@endsection