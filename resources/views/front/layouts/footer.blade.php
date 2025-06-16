<!-- footer start -->
<footer>
    <div class="container">
        <div class="logo-footer"> <img src="{{asset('front/home/assets/images/logo/logo.svg')}}" alt="" /> </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="footer-box">
                    <p>Focused on the competitive hunter-jumper audience, our platform offers a comprehensive space where equestrians can find premium horses, top-quality equipment and apparel, specialized services and jobs, exclusive boarding barns, and properties—all in one place. Whether you’re buying, selling, promoting, hiring, or job hunting, ELITE EQUINE provides the tools and connections to help you achieve your goals quickly and effectively.</p>
                    <p>Together, we are building a global network where passion for horses meets cutting-edge technology.</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-link">
                    <ul>
                        <li><a href="{{route('horse-listing')}}">HORSES</a></li>
                        <li><a href="{{route('equipment-listing')}}">EQUIPMENT & APPAREL</a></li>
                        <li><a href="{{route('barns-listing')}}">BARNS & HOUSING</a></li>
                        <li><a href="{{route('service-listing')}}">EQUINE SERVICES & JOBS</a></li>
                        <li><a href="{{route('community-events')}}">Community & Events</a></li>
                        <li><a href="{{route('sold')}}">SOLD</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="footer-link">
                    <ul>
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('aboutus')}}">About Us</a></li>
                        <li><a href="{{route('partnerships')}}">Partnerships</a></li>
                        <li><a href="{{route('hj-forum')}}">H/J Forum</a></li>
                        <li><a href="{{route('blog')}}">Blog</a></li>
                        {{--<li><a href="{{route('bidNow')}}">BID Now</a></li>
                        <li><a href="{{route('checkout')}}">Checkout</a></li>
                        <li><a href="{{route('occasion')}}">Occasion</a></li>
                        <li><a href="{{route('sale')}}">Call For Price</a></li>--}}
                        {{--<li><a href="{{route('notFound')}}">Not Found</a></li>--}}
                        
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-box">
                    <h3>Get the App</h3>
                    @if($ios_app = social_links('ios_app'))
                        <a href="{{ $ios_app }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{asset('front/home/assets/images/vactors/app_store.svg')}}" alt="" />
                        </a>
                    @endif

                    @if($android_app = social_links('android_app'))
                    <a href="{{ $android_app }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{asset('front/home/assets/images/vactors/paly_store.svg')}}" alt="" />
                    </a>
                    @endif
                </div>
                <div class="social-media">
                    <h4>Mobile App on the Way!</h4>
                    <div class="icon-img">
                        @if($youtube = social_links('youtube'))
                            <a href="{{ $youtube }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('front/home/assets/images/youtube.svg') }}" alt="YouTube" />
                            </a>
                        @endif
                        @if($facebook = social_links('facebook'))
                            <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('front/home/assets/images/facebook.svg') }}" alt="Facebook" />
                            </a>
                        @endif
                        @if($twitter = social_links('twitter'))
                            <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('front/home/assets/images/twitter.svg') }}" alt="Twitter" />
                            </a>
                        @endif
                        @if($instagram = social_links('instagram'))
                            <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('front/home/assets/images/instagram.svg') }}" alt="Instagram" />
                            </a>
                        @endif
                        @if($linkedin = social_links('linkedin'))
                            <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('front/home/assets/images/linkedin.svg') }}" alt="LinkedIn" />
                            </a>
                        @endif
                        @if($tiktok = social_links('tiktok'))
                            <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('front/home/assets/images/tik-tok.svg') }}" alt="TikTok" />
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="footer-bottom">
            <div class="row">
                <div class="col-lg-6">
                    <div class="copy-right">
                        <p>Copyright © EliteEquineMarketplace 2025 All rights reserved.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="footer-bottom-link">
                        <li><a href="{{url('/terms-conditions')}}">Terms of Use</a></li>
                        <li><a href="{{url('/privacy-policies')}}">Privacy Policy </a></li>
                        <li class="me-0"><a href="{{route('contact.form')}}">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
