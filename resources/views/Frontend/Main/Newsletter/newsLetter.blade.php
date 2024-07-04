<!-- Newsletter -->
<section class="py-5 newsletter-wrapper style-2" style="background-image: url('{{ asset('assets/frontend/images//background/bg1.jpg')}}'); background-size: cover;">
    <div class="container">
        <div class="subscride-inner">
            <div class="row style-1 justify-content-xl-between justify-content-lg-center align-items-center text-xl-start text-center">
                <div class="col-xl-7 col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-head mb-0">
                        <h2 class="title text-white my-lg-3 mt-0">Subscribe our newsletter for newest books updates</h2>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                    <form class="dzSubscribe style-1" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="dzSubscribeMsg">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-0">
                                <input name="email" required="required" type="email" class="form-control bg-transparent text-white" placeholder="Your Email Address">
                                <div class="input-group-addon">
                                    <button name="submit" value="submit" type="submit" class="btn btn-primary btnhover">
                                        <span>SUBSCRIBE</span>
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter End -->
