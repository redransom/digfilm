
                <div class="panel">
                    <h2><span>League Chat</span></h2>
                    
                    <div class="panel-content">
                        @if($messages->count() > 0)
                        <div class="d-articles">
                            @foreach($messages as $message)
                            <div class="item">
                                <div class="item-header">
                                    <a href="{{URL('profile', ['id'=>$message->owner->id])}}">
                                    @if($message->owner->thumbnail != "")
                                    <img src="{{asset($message->owner->thumbnail)}}" alt="" />
                                    @else
                                    <img src="{{asset('images/photos/image-95.jpg')}}" alt="" />
                                    @endif
                                    </a>
                                </div>
                                <div class="item-content">
                                    <h5>{{$message->owner->fullName()}} said {{date("d M Y h:iA", strtotime($message->created_at))}}</h5>
                                    <p>{{$message->message}}</p>
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
                                    <div class="textarea-wrapper strike-wysiwyg-enable" rel="wys-current">
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
