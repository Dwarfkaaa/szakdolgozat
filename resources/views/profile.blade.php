@extends('layout')

@section('content')
    <meta name="viewport" content="width=device-width">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />

        <div class="container" id="avatarcontainer">
             <h1 class="avataruser"><b><i>{{$user->name}} </i></b>Profilja</h1>
             <form enctype="multipart/form-data" action="/profile" method="POST">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' id="avatar" name="avatar" accept=".png, .jpg, .jpeg" />
                                <label for="avatar"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url('images/avatars/{{$user->avatar}}')">
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token() }}"><br><br>
                            <button type="submit" class="btn btn-primary btn-lg" style="margin-left: 20%;">Elküldés</button>
                        </div>
             </form>
        </div>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#avatar").change(function() {
            readURL(this);
        });
    </script>
@endsection
