@extends('layout')

@section('content')
    <meta name="viewport" content="width=device-width">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
    <style>
    #SubmitNotice{
        display: none;
    }
    #SubmitNotice span{
        color: red;
    }
    </style>
    <div class="flex-cont">
        <div class="form-cont">
            <h1 class="form-heading">Töltsd fel kedvenc képed a galériába!</h1>
            <form action="/galleryupload" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="name" value="{{ $user->name }}">
                <div class="form-content">Adj címet a képnek
                    <div class="form-row">
                        <label for="first-name" class="form-label" style="padding-bottom: 2%"> </label><br>
                        <input type="text" placeholder="Kép címe" name="description" class="form-textbox input-animate-target"   minlength="5" maxlength="40">
                        <div class="input-animate"></div>
                        <div class="form-check-icon"></div>
                    </div>

                    <div class="form-row">
                        <div class="input-group" style="z-index: 0">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input">
                                <label class="custom-file-label">Kép kiválasztása (jpg, jpeg, png)</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="submit" id="SubmitButton" onclick="feltoltes()"  name="submit"  class="form-submit" value="Kép feltöltése">
                        <b id="SubmitNotice"><span>Kérlek várj!</span></b>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">

        function feltoltes(){
            var SubmitButtonElement = document.getElementById("SubmitButton");
            SubmitButtonElement.style.display = "none";

            var SubmittingNote = document.getElementById("SubmitNotice");
            SubmittingNote.style.display = "inline";
            alert('Kép feltöltése folyamatban..')

        }

    </script>
@endsection
