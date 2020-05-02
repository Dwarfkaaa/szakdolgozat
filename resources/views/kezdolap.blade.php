
<!DOCTYPE html>

<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
</script>
<meta name="viewport" content="width=device-width">
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script>
    const api_url = 'https://ipapi.co/json';
    async function getIP() {
        const response = await fetch(api_url);
        const data = await response.json();
        const {city} = data;
        $('#location').val(city);
        $("#atiranyitas").submit();
    }

    document.addEventListener("DOMContentLoaded", getIP);

</script>
<style>

    /* HOMEPAGE: spinner */
  body{
        height: 100%;
        display: -webkit-box;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        background-color: black;
        position: fixed;
        bottom: 10%;
        left: 47%;
    }



    .spinner {
        -webkit-animation: rotator 1.4s linear infinite;
        animation: rotator 1.4s linear infinite;
    }

    @-webkit-keyframes rotator {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
        }
    }

    @keyframes rotator {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
        }
    }
    .path {
        stroke-dasharray: 187;
        stroke-dashoffset: 0;
        -webkit-transform-origin: center;
        transform-origin: center;
        -webkit-animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
        animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
    }

    @-webkit-keyframes colors {
        0% {
            stroke: #4285F4;
        }
        25% {
            stroke: #DE3E35;
        }
        50% {
            stroke: #F7C223;
        }
        75% {
            stroke: #1B9A59;
        }
        100% {
            stroke: #4285F4;
        }
    }

    @keyframes colors {
        0% {
            stroke: #4285F4;
        }
        25% {
            stroke: #DE3E35;
        }
        50% {
            stroke: #F7C223;
        }
        75% {
            stroke: #1B9A59;
        }
        100% {
            stroke: #4285F4;
        }
    }
    @-webkit-keyframes dash {
        0% {
            stroke-dashoffset: 187;
        }
        50% {
            stroke-dashoffset: 46.75;
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
        }
        100% {
            stroke-dashoffset: 187;
            -webkit-transform: rotate(450deg);
            transform: rotate(450deg);
        }
    }
    @keyframes dash {
        0% {
            stroke-dashoffset: 187;
        }
        50% {
            stroke-dashoffset: 46.75;
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
        }
        100% {
            stroke-dashoffset: 187;
            -webkit-transform: rotate(450deg);
            transform: rotate(450deg);
        }
    }


    /* HOMEPAGE: text */


    @-moz-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @-webkit-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @-ms-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @-o-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }




    @-moz-keyframes spin {
        0% {
            -moz-transform: rotate(0deg);
        }
        20% {
            -moz-transform: rotate(-50deg);
        }

        80% {
            -moz-transform: rotate(780deg);
        }

        100% {
            -moz-transform: rotate(720deg);
        }
    }
    @-moz-keyframes spinoff {
        0% {
            -moz-transform: rotate(0deg);
        }
        100% {
            -moz-transform: rotate(-360deg);
        }
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        20% {
            -webkit-transform: rotate(-50deg);
        }
        80% {
            -webkit-transform: rotate(780deg);
        }
        100% {
            -webkit-transform: rotate(720deg);
        }
    }
    @-webkit-keyframes spinoff {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(-360deg);
        }
    }

    @-ms-keyframes spin {
        0% {
            -ms-transform: rotate(0deg);
        }
        20% {
            -ms-transform: rotate(-50deg);
        }
        80% {
            -ms-transform: rotate(780deg);
        }
        100% {
            -ms-transform: rotate(720deg);
        }
    }
    @-ms-keyframes spinoff {
        0% {
            -ms-transform: rotate(0deg);
        }
        100% {
            -ms-transform: rotate(-360deg);
        }
    }

    @-o-keyframes spin {
        0% {
            -o-transform: rotate(0deg);
        }
        20% {
            -o-transform: rotate(-50deg);
        }
        80% {
            -o-transform: rotate(780deg);
        }
        100% {
            -o-transform: rotate(720deg);
        }
    }
    @-o-keyframes spinoff {
        0% {
            -o-transform: rotate(0deg);
        }
        100% {
            -o-transform: rotate(-360deg);
        }
    }

    @-moz-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @-webkit-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @-ms-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @-o-keyframes spinnertext-opacity {
        0%  {opacity: 0}
        20% {opacity: 0}
        50% {opacity: 1}
        100%{opacity: 0}
    }

    @media(max-width: 800px){
        .spinnertext{
            position:relative;
            font-size: 30px;
            color:#ADADAD;
            right: 50% !important;
            top: 20%;
            -moz-animation: spinnertext-opacity 2s linear 0s infinite normal;
            -webkit-animation: spinnertext-opacity 2s linear 0s infinite;
            -ms-animation: spinnertext-opacity 2s linear 0s infinite;
            -o-animation: spinnertext-opacity 2s linear 0s infinite;
            text-align: center;
        }
    }
    @media(min-width: 801px){
        .spinnertext{
            position:relative;
            font-size: 36px;
            color:#ADADAD;
            right: 50% !important;
            top: 20%;
            -moz-animation: spinnertext-opacity 2s linear 0s infinite normal;
            -webkit-animation: spinnertext-opacity 2s linear 0s infinite;
            -ms-animation: spinnertext-opacity 2s linear 0s infinite;
            -o-animation: spinnertext-opacity 2s linear 0s infinite;
            text-align: center;

        }
    }

</style>
<form action="/" id="atiranyitas"  method="post" >
    {{csrf_field()}}
    <input type="hidden" id="location" name="location"/>
    <button type="submit" style="display:none;"></button>
</form>



        <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
            <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
        </svg>
        <div class="spinnertext">Pozíció lekérdezése...</div>

