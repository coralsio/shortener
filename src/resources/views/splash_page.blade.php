<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Please wait</title>
    @foreach($trackingPixels as $pixel)
        {!! $pixel->head_script !!}
    @endforeach
    <style>
        body {
            background: #41a5d2;
            font-family: 'Titillium Web', sans-serif;
        }

        .loading {
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            width: 500px;
            color: #FFF;
            font-size: 19px;
            margin: auto;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .loading span {
            position: absolute;
            height: 10px;
            width: 84px;
            top: 50px;
            overflow: hidden;
        }

        .loading span > i {
            position: absolute;
            height: 4px;
            width: 4px;
            border-radius: 50%;
            -webkit-animation: wait 4s infinite;
            -moz-animation: wait 4s infinite;
            -o-animation: wait 4s infinite;
            animation: wait 4s infinite;
        }

        .loading span > i:nth-of-type(1) {
            left: -28px;
            background: yellow;
        }

        .loading span > i:nth-of-type(2) {
            left: -21px;
            -webkit-animation-delay: 0.8s;
            animation-delay: 0.8s;
            background: lightgreen;
        }

        @-webkit-keyframes wait {
            0% {
                left: -7px
            }
            30% {
                left: 52px
            }
            60% {
                left: 22px
            }
            100% {
                left: 100px
            }
        }

        @-moz-keyframes wait {
            0% {
                left: -7px
            }
            30% {
                left: 52px
            }
            60% {
                left: 22px
            }
            100% {
                left: 100px
            }
        }

        @-o-keyframes wait {
            0% {
                left: -7px
            }
            30% {
                left: 52px
            }
            60% {
                left: 22px
            }
            100% {
                left: 100px
            }
        }

        @keyframes wait {
            0% {
                left: -7px
            }
            30% {
                left: 52px
            }
            60% {
                left: 22px
            }
            100% {
                left: 100px
            }
        }
    </style>
</head>
<body>
@foreach($trackingPixels as $pixel)
    {!! $pixel->body_script !!}
@endforeach
<div class="container text-center">
    <div class="col-md-12">
        <div class="loading">
            <p>Please wait while redirecting you to the requested page <b id="countdown">3</b></p>
            <span><i></i><i></i></span>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>


<script>
    window.onload = () => {
        let seconds = document.getElementById("countdown").textContent;
        let countdown = setInterval(function () {
            seconds--;
            document.getElementById("countdown").textContent = seconds;
            if (seconds <= 0) clearInterval(countdown);
        }, 1000);

        setTimeout(() => {
            location.href = '{{ $link->full_url }}';
        }, 3000);
    };
</script>
</body>
</html>
