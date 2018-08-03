@extends('template')

@section('content')

<div class="templatemo-content-widget white-bg">
    <div class="row">
        <div class="col-md-2 col-sm-0 col-xs-0"></div>
        <div class="col-md-8 col-sm-12 col-xs-12">
            <h1 class="margin-bottom-10">
                {{$noticium->titulo}}
            </h1>
            <h3 class="margin-bottom-10">
                {{$noticium->subtitulo}}
            </h3>
            <div class="row margin-bottom-10">
                <div class="col-md-2 col-sm-0 col-xs-0"></div>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    {!! Html::image("images/noticias/$noticium->id/$noticium->imagem", $noticium->imagem) !!}
                </div>
                <div class="col-md-2 col-sm-0 col-xs-0"></div>
            </div>
            <hr>
            <?=$noticium->conteudo?>
        </div>
        <div class="col-md-2 col-sm-0 col-xs-0"></div>
    </div>

</div>

<style type="text/css">
    h1, h3 {font-weight: bold;text-align: center;}
    h1 { color: #39ADB4; }
    h3, p { color: #7f7f7f; }
    img {width: 100%;}
    p { font-size: 14px; }
</style>
@endsection