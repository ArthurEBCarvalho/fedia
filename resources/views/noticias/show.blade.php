@extends('template')

@section('content')

<div class="templatemo-content-widget white-bg">
    <div class="row">
        <div class="col-md-2 col-sm-0 col-xs-0"></div>
        <div class="col-md-8 col-sm-12 col-xs-12">
            <h2 class="margin-bottom-10">
                {{$noticium->titulo}}
            </h2>
            <h5 class="margin-bottom-10">
                {{$noticium->subtitulo}}
            </h5>
            @if(!is_null($noticium->imagem))
            <div class="row margin-bottom-10">
                <div class="col-md-2 col-sm-0 col-xs-0"></div>
                <div class="col-md-8 col-sm-12 col-xs-12">
                    {!! Html::image("images/noticias/$noticium->id/$noticium->imagem", $noticium->imagem) !!}
                </div>
                <div class="col-md-2 col-sm-0 col-xs-0"></div>
            </div>
            @endif
            <hr>
            <div class="conteudo">
                <?=$noticium->conteudo?>
            </div>
            <hr>
            <div class="input-group">
                <input type="text" id="url" class="form-control" name="url" value="{{Request::root()}}/noticia/{{$noticium->id}}" readonly>
                <span class="input-group-btn">
                <button id="btn-copiar" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="URL copiada com sucesso!"><i class="fa fa-copy"></i> Copiar</button>
                </span>
            </div>
        </div>
        <div class="col-md-2 col-sm-0 col-xs-0"></div>
    </div>
</div>

<style type="text/css">
    h2, h5 {font-weight: bold;text-align: center;}
    h2 { color: #39ADB4; }
    h5, .conteudo { color: #7f7f7f; }
    img {width: 100%;}
    .conteudo { font-size: 14px; }
    .conteudo ul { list-style-type: disc;margin-top: 0;margin-bottom: 10px;padding: 0 0 0 40px; }
</style>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'click'
        });
    });


    $('[data-toggle="tooltip"]').click(function () {
        setTimeout(function () {
            $('[data-toggle="tooltip"]').tooltip('hide');
        }, 2000);
    });

    $("#btn-copiar").click(function(){
        $('#url').select();
        document.execCommand('copy');
    });
</script>
@endsection