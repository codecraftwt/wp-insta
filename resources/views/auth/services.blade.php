@extends('layouts.app')

@section('content')
    <section id="services" class="services">
        <div class="container">
            <div class="section-title">
                <h2>Services</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="service-box">
                        <div class="icon"><i class="fas fa-heartbeat"></i></div>
                        <h4>Nesciunt Mete</h4>
                        <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores iure
                            perferendis tempore et consequatur.</p>
                      
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="service-box">
                        <div class="icon"><i class="fas fa-broadcast-tower"></i></div>
                        <h4>Eosle Commodi</h4>
                        <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque eum hic non
                            ut nesciunt dolorem.</p>

                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="service-box">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h4>Ledo Markt</h4>
                        <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id voluptas
                            adipisci eos earum corrupti.</p>

                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="service-box">
                        <div class="icon"><i class="fas fa-cubes"></i></div>
                        <h4>Asperiores Commodi</h4>
                        <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed est error ea fuga sit
                            provident adipisci neque.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
  .services{
    background: linear-gradient(135deg, #f1fdf6 0%, #f7f7f7 100%);
  }
    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title h2 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
    }

    .section-title p {
        font-size: 16px;
        color: #777;
    }

    .service-box {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .service-box:hover {
        box-shadow: 0 0 45px rgba(0, 0, 0, 0.15);
    }

    .icon {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .icon i {
        color: #a5c171;
    }

    .service-box h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }

    .service-box p {
        font-size: 14px;
        color: #777;
        margin-bottom: 20px;
    }

    .learn-more {
        color: #00bcd4;
        font-weight: 700;
        text-decoration: none;
    }

    .learn-more i {
        margin-left: 5px;
    }
</style>
