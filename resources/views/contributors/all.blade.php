@extends('layouts.admin')

@section('content')
                        <div class="module">
                            <div class="module-head">
                                <h3>
                                    All Contributors</h3>
                            </div>
                            <div class="module-option clearfix">
                                <form>
                                <div class="input-append pull-left">
                                    <input type="text" class="span3" placeholder="Filter by name...">
                                    <button type="submit" class="btn">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                                </form>
                            </div>
                            <div class="module-body">
                            @if(isset($contributors) && !empty($contributors))

                            <?php $contributor_count = 0; ?>
                            @foreach($contributors as $contributor)

                                @if($contributor_count == 0 || ($contributor_count % 2) == 0)
                                <div class="row-fluid">
                                @endif
                                    <div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="{{URL('contributors', array('id'=>$contributor->id))}}">
                                                @if(is_null($contributor->thumbnail))
                                                <img src="admin/images/user.png">
                                                @else
                                                <img src="{{ asset($contributor->thumbnail) }}">
                                                @endif
                                            </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    {{$contributor->first_name}} {{$contributor->surname}}
                                                </h3>
                                                <div class="media-option btn-group shaded-icon">
                                                    <a class="btn btn-mini btn-primary" href="{{URL('contributors/'.$contributor->id.'/edit')}}">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @if(($contributor_count++ % 2) == 1)
                                </div>
                                <!--/.row-fluid-->
                                <br />
                                @endif
                            @endforeach

                                @if(($contributor_count % 2) == 1)
                                </div>
                                <!--/.row-fluid-->
                                <br />
                                @endif
                            @endif
                                <div class="pagination pagination-centered">
                                    <!-- <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul> -->
                                    <?php echo $contributors->render(); ?>
                                </div>
                            </div>
                        </div>
@endsection