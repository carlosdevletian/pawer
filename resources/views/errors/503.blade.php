<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pawerlab</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
            .icon {
                display: inline-block;
                max-width: 90%;
                width: 45em;
                fill: currentColor;
                color: white;
                vertical-align: text-bottom;
            }
            .icon-small {
                display: inline-block;
                max-width: 35%;
                width: 10em;
                fill: currentColor;
                color: white;
                vertical-align: text-bottom;
            }
            .bottom {
                position: absolute;
                bottom: 5em;
            }
        </style>
    </head>
    <body>
       <!--  <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    @icon('503.stay-tuned', 'icon')
                </div>
                <a href="http://instagram.com/pawerlab">
                    @icon('503.pawerlab', 'icon-small')
                </a>
            </div>
        </div> -->
        <div class="position-ref flex-center full-height" style="flex-direction: column">
            @icon('503.stay-tuned', 'icon')
            @icon('503.pawerlab', 'icon-small bottom')
        </div>
    </body>
</html>
