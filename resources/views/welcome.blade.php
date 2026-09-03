<!DOCTYPE html>

<html lang="bs">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>BeautyBook</title>

    <link
        href="https://fonts.bunny.net/css?family=montserrat:300,400,500&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js'
    ])

</head>


<body class="welcome-page">

    <section
        class="beauty-hero-page"
        style="background-image: url('{{ asset('images/beauty-hero.png') }}') !important;"
    >

        <img
            src="{{ asset('images/beauty-hero.png') }}"
            class="hero-background-image"
            alt=""
        >


        <div class="beauty-hero-overlay"></div>


        <div class="hero-logo">
            BEAUTYBOOK
        </div>


        <div class="hero-center">

            <h1>
                BEAUTYBOOK
            </h1>

            <p>
                BEAUTY BEGINS HERE
            </p>


            <a
                href="{{ route('login') }}"
                class="hero-start-button"
            >

                <span>
                    START
                </span>

                <span class="hero-arrow"></span>

            </a>

        </div>

    </section>

</body>

</html>