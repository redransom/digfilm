@extends('layouts.admin')

@section('content')
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
@if($content->type == 'F' || $content->type == 'M')
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
@if($content->type != 'F')
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
            <h3>Edit Content</h3>
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
                {!! Form::open(array('route' => array('sitecontent.update', $content->id), 'class'=>'form-horizontal row-fluid', 'files'=>true, 'method'=>'PUT')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="owners_id" value="{{ $authUser->id }}">
                    <input type="hidden" name="type" value="{{ $content->type }}">
                    @if($content->type == 'C')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentSection">Section / Page</label>
                        <div class="controls">
                            {!! Form::select('section', $sections, $content->section, ['class'=>'span4']) !!}
                            <span class="help-inline">Select page that is to added (you can only add one Page Content for each page except the news/blog pages).</span>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="section" value="{{ $content->section }}">
                    @endif
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Title</label>
                        <div class="controls">
                            {!! Form::text('title', $content->title, ['class'=>'span8', 'placeholder'=>'Heading for content']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>
    
                    <div class="control-group">
                        <div class="controls">
                        <h3>NOTE</h3>
                        <span class="help-inline">Make sure you don't just copy content straight in from another site as the formatting can break the admin of the site.</span>
                        </div>
                    </div>

                    @if($content->type == 'N' || $content->type == 'F' || $content->type == 'M')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentSummary">Summary</label>
                        <div class="controls">
                            {!! Form::textarea('summary', $content->summary, ['class'=>'span8', 'placeholder'=>'Brief description of content...', 'id'=>'summary', 'maxlength'=>300, 'rows'=>5]) !!}
                        </div>
                    </div>
                    @endif

                    @if($content->type != 'F')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentBody">Body</label>
                        <div class="controls">
                            {!! Form::textarea('body', $content->body, ['class'=>'span8', 'placeholder'=>'WYSIWYG here...', 'id'=>'body']) !!}
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="body" value="{{ $content->body }}">
                    @endif

                    @if($content->type == 'F')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Link/URL</label>
                        <div class="controls">
                            {!! Form::text('link_url', $content->link_url, ['class'=>'span8', 'placeholder'=>'Link or URL']) !!}
                            <span class="help-inline">Link to page within site or external.</span>
                            <span class="help-inline">Don't include the domain for internal pages.</span>
                        </div>
                    </div>
                    @endif

                    @if($content->type == 'N' || $content->type == 'F')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentThumbnail">Thumbnail</label>
                        <div class="controls">
                            @if(!is_null($content->thumbnail) && $content->thumbnail != '')
                            <img src="{{asset($content->thumbnail)}}" width="100px"/>
                            @endif
                            {!! Form::file('thumbnail', null, ['class'=>'span8']) !!}
                            @if($content->type == 'F')
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
                            @if(!is_null($content->main_image))
                            <img src="{{asset($content->main_image)}}" width="100px"/>
                            @endif
                            {!! Form::file('main_image', null, ['class'=>'span8']) !!}
                            @if($content->type == 'F')
                            <span class="help-inline">The size of this image needs to be 1000px by 440px or else it will be squashed.</span>
                            @else
                            <span class="help-inline">The size of this image needs to be 644px by 300px.</span>
                            @endif
                        </div>
                    </div>

                    @if($content->type != 'F')
                    <h4>SEO</h4>
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Keywords</label>
                        <div class="controls">
                            {!! Form::text('meta_keywords', $content->meta_keywords, ['class'=>'span8', 'placeholder'=>'Keywords', 'maxlength'=>70]) !!}
                            <span class="help-inline">Not hugely relevant - only Yahoo uses this now - 70 chars.</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Description</label>
                        <div class="controls">
                            {!! Form::text('meta_description', $content->meta_description, ['class'=>'span8', 'placeholder'=>'Meta description', 'maxlength'=>155]) !!}
                            <span class="help-inline">Used in most searches - max of 155 chars normally.</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Save Content</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

@endsection