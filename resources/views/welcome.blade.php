<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">

                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="http://qr.dev/qrcode?content=18898726543&data_type=phone_number&color=0064db&size=200&bg_color=ffffff&format=png&logo=http://toocold.org/favicon.png&module=roundness" style="margin-left: 20px;">
                    <img src="{{
                        'http://qr.dev/qrcode?' . http_build_query(
                            [
                                'content'=> [
                                    '18898726543',
                                    'Hi, QR Code...!'
                                ],
                                'data_type' => 'sms',
                                'color' => 'ff0000',
                                'size' => 200,
                                'bg_color' => 'ffffff',
                                'format' => 'png',
                                'logo' => 'http://toocold.org/favicon.png',
                                'module' => 'roundness',
                            ]
                        )
                    }}" style="margin-left: 20px;">

                    <img src="{{
                        'http://qr.dev/qrcode?' . http_build_query(
                            [
                                'content'=> [
                                    [
                                        'encryption' => 'WPA2',
                                        'ssid' => 'iPhone”bill',
                                        'password' => '@tingting..'
                                    ]
                                ],
                                'data_type' => 'wifi',
                                'color' => '0064db',
                                'size' => 200,
                                'bg_color' => 'ffffff',
                                'format' => 'png',
                                'logo' => 'http://toocold.org/favicon.png',
                                'module' => 'roundness',
                            ]
                        )
                    }}" style="margin-left: 20px;">
                </div>

                <div class="title m-b-md">
                    Ofcold QR Code.
                </div>

            </div>
        </div>
    </body>
</html>
