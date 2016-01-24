@extends('layouts.admin')

@section('content')
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
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
<div class="content">

    <div class="module">
        <div class="module-head">
            <h3>Add Content</h3>
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
                    <div class="control-group">
                        <label class="control-label" for="SiteContentSection">Section / Page</label>
                        <div class="controls">
                            {!! Form::select('section', $sections, null, ['class'=>'span4']) !!}
                            <span class="help-inline">Select page that is to added (you can only add one Page Content for each page except the news/blog pages).</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="SiteContentTitle">Title</label>
                        <div class="controls">
                            {!! Form::text('title', null, ['class'=>'span8', 'placeholder'=>'Heading for content']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>

                    @if($type == 'N')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentSummary">Summary</label>
                        <div class="controls">
                            {!! Form::textarea('summary', null, ['class'=>'span8', 'placeholder'=>'Brief description of content...', 'id'=>'summary']) !!}
                        </div>
                    </div>
                    @endif

                    <div class="control-group">
                        <label class="control-label" for="SiteContentBody">Body</label>
                        <div class="controls">
                            {!! Form::textarea('body', null, ['class'=>'span8', 'placeholder'=>'WYSIWYG here...', 'id'=>'body']) !!}
                        </div>
                    </div>

                    @if($type == 'N')
                    <div class="control-group">
                        <label class="control-label" for="SiteContentThumbnail">Thumbnail</label>
                        <div class="controls">
                            {!! Form::file('thumbnail', null, ['class'=>'span8']) !!}
                            <span class="help-inline">For use in lists.</span>
                        </div>
                    </div>
                    @endif

                    <div class="control-group">
                        <label class="control-label" for="SiteContentMainImage">Main Image</label>
                        <div class="controls">
                            {!! Form::file('main_image', null, ['class'=>'span8']) !!}
                            <span class="help-inline">Main image for article if available.</span>
                        </div>
                    </div>

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