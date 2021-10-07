       <!--Corona Header start-->

       @if( $header_note_text_first )
           <div class="warning-header" style="background-color:{{$header_note_text_first->background_color}} ; ">
               @if( $header_note_text_first->url_pointer )
               <a href="{{$header_note_text_first->url_pointer}}">
               <p style="color: {{$header_note_text_first->text_color}};">{{$header_note_text_first->text}}
               </p>
               </a>
                   @else

                       <p style="color: {{$header_note_text_first->text_color}};">{{$header_note_text_first->text}}
                       </p>

               @endif

           </div>
       @endif



    <!--Corona Header end-->
    <!--Header start-->
    <header>
        <div class="container">
            <div class="main-logo">
                <a href="{{url('')}}/" title="متجر ممنون لملابس الأطفال">
                    <img class="lazyload logo"  data-src="/website/img/mainlogo.png" alt="متجر ممنون لملابس الأطفال">
                </a>
            </div>
            <div class="search-section">
                <input type="text" class="search-bar"  id="search_product_input" name="search-bar" placeholder="ابحث هنا ...">
                <button class="btn search-icon">
                    <i class="fas fa-search"></i>
                </button>

            </div>
            <div class="social-media">
                <a  href="{{LaravelLocalization::localizeUrl('my-account')}}">
                    <button class="btn account-btn btn-link">
                        <i class="far fa-user"></i>
                        حسابي
                    </button>
                </a>
                <a target="_blank" href="{{$footer_data['instagram']}}">
                    <button class="btn btn-link">
                        <i class="fab fa-instagram"></i>
                    </button>
                </a>
                <a target="_blank" href="{{$footer_data['snapchat']}}">
                    <button class="btn btn-link">
                        <i class="fab fa-snapchat-ghost"></i>
                    </button>
                </a>
                <a target="_blank" href="{{$footer_data['twitter']}}">
                    <button class="btn btn-link">
                        <i class="fab fa-twitter"></i>
                    </button>
                </a>
                <a target="_blank" href="{{$footer_data['facebook']}}">
                    <button class="btn btn-link">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                </a>
            </div>
        </div>
    </header>
    <!--Header end-->