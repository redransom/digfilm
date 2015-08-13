@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Edit Contributor</h3>
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

                {!! Form::open(array('route' => array('contributors.update', $contributor->id), 'class'=>'form-horizontal row-fluid', 'files'=>true, 'method'=>'PUT')) !!}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label" for="ContributorFirstname">Firstname(s)</label>
                        <div class="controls">
                            {!! Form::text('first_name', $contributor->first_name, ['class'=>'span8', 'placeholder'=>'First name(s) here...']) !!}
                            <span class="help-inline">Minimum 3 Characters.</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="ContributorSurname">Surname</label>
                        <div class="controls">
                            {!! Form::text('surname', $contributor->surname, ['class'=>'span8', 'placeholder'=>'Surname here...']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="ContributorThumbnail">Photo</label>
                        <div class="controls">
                            {!! Form::file('thumbnail', null, ['class'=>'span8', 'placeholder'=>'Image of contributor']) !!}
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Save Changes</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
@endsection