<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html {
            margin: 0;
            height: 100%;
        }

        body {
            margin: 0;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: black;
            color: #ccc;
        }

        html::before,
        html::after,
        body::before,
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: .5vmin;
            height: .5vmin;
            border-radius: 50%;
            color: transparent;
        }

        html::before {
            box-shadow: 93vw 63vh .3vmin rgba(255,255,255,.8),
                        3vw 17vh .3vmin rgba(255,255,255,.8),
                        /* Mais sombras... */
                        26vw 32vh .3vmin rgba(255,255,255,.8),
                        46vw 9vh .3vmin rgba(255,255,255,.8),
                        2vw 13vh .3vmin rgba(255,255,255,.8),
                        29vw 63vh .3vmin rgba(255,255,255,.8),
                        17vw 90vh .3vmin rgba(255,255,255,.8),
                        78vw 9vh .3vmin rgba(255,255,255,.8),
                        15vw 39vh .3vmin rgba(255,255,255,.8),
                        90vw 5vh .3vmin rgba(255,255,255,.8);
        }

        html::after { 
            box-shadow: 67vw 35vh .2vmin .1vmin rgba(255,200,200,.8),
                        89vw 13vh .2vmin .1vmin rgba(255,200,200,.8),
                        /* Mais sombras... */
                        85vw 70vh .1vmin rgba(200,255,230,.7),
                        54vw 93vh .1vmin rgba(200,255,230,.7),
                        9vw 46vh .1vmin rgba(200,255,230,.7),
                        63vw 59vh .1vmin rgba(200,255,230,.7),
                        48vw 28vh .1vmin rgba(200,255,230,.7);
        }

        body::before {
            box-shadow: 30vw 90vh .2vmin rgba(190,200,255,.9),
                        93vw 64vh .2vmin rgba(190,200,255,.9),
                        /* Mais sombras... */
                        60vw 93vh .1vmin rgba(200,255,230,.7),
                        14vw 82vh .1vmin rgba(200,255,230,.7),
                        6vw 64vh .1vmin rgba(200,255,230,.7),
                        19vw 12vh .1vmin rgba(200,255,230,.7),
                        25vw 39vh .1vmin rgba(200,255,230,.7);
        }

        body::after {
            box-shadow: 80vw 64vh .1vmin rgba(200,255,230,.7),
                        32vw 45vh .1vmin rgba(200,255,230,.7),
                        /* Mais sombras... */
                        54vw 34vh .1vmin rgba(200,255,230,.7),
                        1vw 56vh .1vmin rgba(200,255,230,.7),
                        95vw 1vh .1vmin rgba(200,255,230,.7),
                        54vw 93vh .1vmin rgba(200,255,230,.7),
                        9vw 46vh .1vmin rgba(200,255,230,.7),
                        63vw 59vh .1vmin rgba(200,255,230,.7),
                        48vw 28vh .1vmin rgba(200,255,230,.7);
        }

        h1 {
            margin: 0;
            height: 12vmin;
            width: 120vmin;
            display: flex;
            justify-content: center;
            position: relative;
        }

        h1::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            top: -26vmin;
            left: 29vmin;
            width: 62vmin;
            height: 62vmin;
            border-radius: 50%;
            border: 1.3vmin solid currentColor;
            box-sizing: border-box;
        }

        em {
            font-family: 'Josefin Sans', sans-serif;
            color: currentColor;
            font-size: 15vmin;
            position: relative;
            font-style: normal;
            width: 20vmin;
            text-align: center;
        }

        em.planet {
            -webkit-animation: planet-rotate 4s linear infinite;
            animation: planet-rotate 4s linear infinite;
            position: relative;
        }

        em.planet::before {
            content: "";
            position: absolute;
            top: -.5vmin;
            left: 3.5vmin;
            z-index: -1;
            width: 13vmin;
            height: 13vmin;
            border-radius: 50%;
            background: black;
        }

        em.planet.left {
            -webkit-transform-origin: 40vmin 5vmin;
            transform-origin: 40vmin 5vmin;
        }

        em.planet.right {
            -webkit-transform-origin: -20vmin 5vmin;
            transform-origin: -20vmin 5vmin;
        }

        @-webkit-keyframes planet-rotate {
            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn);
            }
        }

        @keyframes planet-rotate {
            to {
                transform: rotate(1turn);
            }
        }

        .login {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .login a {
            background-color: #6c5b7b;
            border-color: #6c5b7b;
        }

        .login a:hover {
            background-color: #4b3e52;
            border-color: #4b3e52;
        }

        .login a:focus, .login a.focus {
            box-shadow: 0 0 0 0.2rem rgba(108, 91, 123, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <em>C</em>
            <em class="planet left">O</em>
            <em>D</em>
            <em>E</em>
            <em class="planet right">T</em>
            <em>I</em>
        </h1>

        <div class="login">
            <a href="Login.php" class="btn btn-primary btn-lg">Fazer Login</a>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>
</html>