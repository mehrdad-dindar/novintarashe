<!-- Start footer -->
<footer class="main-footer dt-sl position-relative">
    <div class="back-to-top">
        <a href="#"><span class="icon"><i class="mdi mdi-chevron-up"></i></span> <span>{{ trans('front::messages.index.back-to-top') }}</span></a>
    </div>
    <div class="container main-container">


        <div class="footer-widgets">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        @foreach($footer_links as $group)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="widget-menu widget card">
                                    <header class="card-header">
                                        <p class="card-title">{{ option('link_groups_' . $group['key'], $group['name']) }}</p>
                                    </header>
                                    <ul class="footer-menu">
                                        @foreach($links->where('link_group_id', $group['key']) as $link)
                                            <li>
                                                <a href="{{ $link->link }}">{{ $link->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card widget ">
                                 <p class="text-justify" style="color: #666;">
                                {!! option('about_us_in_footer') !!}
                            </p>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="col-12 col-md-3 col-lg-3">

                    <div class="symbol footer-logo">

                        @if(option('info_enamad'))
                            {!! option('info_enamad') !!}
                        @endif

                        @if(option('info_samandehi'))
                            {!! option('info_samandehi') !!}
                        @endif

                    </div>




                        <div class="row">
                        <div class="footer-social d-block">
                            <div class="text-center">
                                <div class="col-4" style="float: right;">
                                                                       <div id="qrcode" style=" float: right;
    padding-left: 25px;"></div>

    اینستاگرام
    </div>
                                <div class="col-4" style="float: left;">

                        <div id="qrcodeTelegram" style=" float: left;
    padding-left: 25px;"></div>
تلگرام
    </div>

                                    <div class="col-4" style="float: left;">

                        <div id="qrcodeEita" style=" float: left;
    padding-left: 25px;"></div>
ایتا
    </div>

                            </div>
                        </div>
                    </div>




                    <div class="socials">
                        <div class="footer-social">
                            <ul class="text-center">
                                @if(option('social_instagram'))
                                    <li><a href="{{ option('social_instagram') }}"><i class="mdi mdi-instagram"></i></a></li>
                                @endif

                                @if(option('social_whatsapp'))
                                    <li><a href="{{ option('social_whatsapp') }}"><i class="mdi mdi-whatsapp"></i></a></li>
                                @endif

                                @if(option('social_telegram'))
                                    <li><a href="{{ option('social_telegram') }}"><i class="mdi mdi-telegram"></i></a></li>
                                @endif

                                @if(option('social_facebook'))
                                    <li><a href="{{ option('social_facebook') }}"><i class="mdi mdi-facebook"></i></a></li>
                                @endif

                                @if(option('social_twitter'))
                                    <li><a href="{{ option('social_twitter') }}"><i class="mdi mdi-twitter"></i></a></li>
                                @endif
                                @if(option('social_rubika'))
                                    <li><a href="{{ option('social_rubika') }}"><img src="{{ asset('/img/rubika-icon.png')}}" style="    width: 25px;
    padding-bottom: 10px;"></a></li>
                                @endif
                                @if(option('social_eita'))
                                    <li><a href="{{ option('social_eita') }}"><img src="{{ asset('/img/eitaa-icon.png')}}" style="    width: 25px;
    padding-bottom: 10px;"></a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="copyright">
        <div class="container main-container">
            <p class="text-center">{!! option('info_footer_text') !!} </p>
        </div>
    </div>
</footer>
<!-- End footer -->
