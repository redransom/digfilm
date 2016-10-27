
                <div class="panel">
                    <h2><span>League Chat</span></h2>
                    
                    <div class="panel-content">
                        @if($messages->count() > 0)
                        <style>
                            div.d-articles {
                                max-height: 250px;
                                clear: both;
                                overflow-y: auto;    
                            }
                            .item-content p:last-of-type {
                                padding-bottom: 0.5em !important;
                            }
                            
                            div.item-header img {
                                max-width: 54px;
                                max-height: 54px;
                            }

                            div.d-articles div.item {
                                padding-bottom: 0px !important;
                                margin-bottom: 0px !important;
                            }

                            div.reply-textarea {
                                padding-top: 1em;
                            }
                        </style>
                        <div class="d-articles">
                            @foreach($messages as $message)
                            <div class="item">
                                <div class="item-header">
                                    <a href="{{URL('profile', ['id'=>$message->owner->id])}}">
                                    @if(!is_null($message->owner->thumbnail) && $message->owner->thumbnail != "")
                                    <img src="{{asset($message->owner->thumbnail)}}" alt="{{$message->owner->name}}" />
                                    @else
                                    <img src="{{asset('images/TNBF.jpg')}}" alt="{{$message->owner->name}}" />
                                    @endif
                                    </a>
                                </div>
                                <div class="item-content">
                                    <h5>{{$message->owner->fullName()}} said {{date("d M Y g:iA", strtotime($message->created_at))}}</h5>
                                    <p>{!! $message->message !!}</p>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        @endif
                        <div class="reply-textarea">
                            <form action="{{Route('add-message', ['id'=>$league->id])}}" method="post">
                                <input type="hidden" name="leagues_id" value="{{$league->id}}" />
                                <input type="hidden" name="owners_id" value="{{$authUser->id}}" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="respond-textarea">
                                    <style>
                                    *{direction:ltr!important!;}
                                    </style>
                                    <div class="textarea-wrapper" rel="wys-current">
                                        <textarea name="message" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="respond-submit">
                                    <input type="submit" name="send" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
