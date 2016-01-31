        <!-- BEGIN #slider-imgs -->
    
        <div id="slider-imgs">
            <div class="featured-img-box">
                @if(isset($slider) && $slider->count() > 0)
                    <?php $sliderNo = 1; ?>
                    @foreach($slider as $slide)
                <div id="featured-img-{{$sliderNo}}" class="featured-img<?php echo (($sliderNo > 1) ? " invisible" : ""); ?>"></div>
                    <?php $sliderNo++; ?>
                    @endforeach
                @endif
            </div>
        <!-- END #slider-imgs -->
        </div>