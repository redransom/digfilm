@extends('layouts.admin')

@section('content')
<div class="module">
    <div class="module-head">
        <h3>{{$title}}</h3>
    </div>
    <div class="module-option clearfix">
        <div class="btn-group pull-right" data-toggle="buttons-radio">
            <a class="btn" href="{{URL('sitecontents')}}">All</a>
            <a class="btn" href="{{URL('sitecontents/C')}}">Page</a>
            <a class="btn" href="{{URL('sitecontents/F')}}">Front</a>
            <a class="btn" href="{{URL('sitecontents/N')}}">News</a>
        </div>
    </div>
    @if($sitecontents->count() > 0)
    <div class="module-body table">

        <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
            <thead>
                <tr>
                    <th width="4%">ID</th>
                    <th width="30%">Title</th>
                    <th width="12%">Created</th>
                    <th width="12%">Modified</th>
                    <th width="11%">Type /<br/>Section</th>
                    <th width="7%">Owned By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $contentCnt = 1; ?>
                @foreach($sitecontents as $content)
                <tr class="<?php echo (($contentCnt++ % 2) == 0) ? "odd" : "even"; ?> content{{$content->id}}">
                    <td>{{$content->id}}</td>
                    <td>{{$content->title}}</td>
                    <td>{{date("j/m/Y g:iA", strtotime($content->created_at))}}</td>
                    <td>{{date("j/m/Y g:iA", strtotime($content->updated_at))}}</td>
                    <td>@if($content->type == 'N')
                    News
                    @elseif($content->type == 'C')
                    {{$sections[$content->section]}}
                    @else
                    Front
                    @endif</td>
                    <td class="center"><a href="{{URL('users/'.$content->owner->id)}}">{{$content->owner->name}}</a></td>
                    <td>
                    <a class="btn btn-mini btn-primary" href="{{URL('sitecontent/'.$content->id.'/edit')}}">Edit</a>

                    @if($content->enabled)
                    <a class="btn btn-mini btn-danger" href="{{URL('sitecontent/'.$content->id.'/disable')}}">Disable</a>
                    @else
                    <a class="btn btn-mini btn-info" href="{{URL('sitecontent/'.$content->id.'/enable')}}">Enable</a>
                    @endif

                    @if(!$content->enabled)
                    {!! Form::open(array('route' => array('sitecontent.destroy', $content->id), 'method' => 'delete', 'style'=>'display:inline')) !!}
                        <button type="submit" class="btn btn-danger btn-mini">Delete</button>
                    {!! Form::close() !!}
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination pagination-centered">
            <?php echo $sitecontents->render(); ?>
        </div>
    </div>
    @else
    <div class="module-body">
    <p>There is no content currently.</p>
    </div>
    @endif
</div>
    
@endsection