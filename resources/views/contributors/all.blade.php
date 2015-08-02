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

                            @for($contr_row = 0; $contr_row<(count($contributors)/2); $contr_row++)
                                <div class="row-fluid">
                                @for($contr_no = $contr_row; $contr_no < ($contr_row+2); $contr_no++)
                                <?php $contributor = $contributors[$contr_no]; ?>
                                    <div class="span6">
                                        <div class="media user">
                                            <a class="media-avatar pull-left" href="{{URL('contributors', array('id'=>$contributor->id))}}">
                                                <img src="images/user.png">
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
                                    <?php if (count($contributors) == 1) break; ?>
                                @endfor
                                </div>
                                <!--/.row-fluid-->
                                <br />
                            @endfor
                            @endif
                                <div class="pagination pagination-centered">
                                    <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
@endsection