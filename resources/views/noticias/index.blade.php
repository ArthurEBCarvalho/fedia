@extends('template')

@section('content')
@if (Session::has('message'))
<div class="templatemo-content-widget green-bg">
    <i class="fa fa-times"></i>                
    <div class="media">
        <div class="media-body">
            <h2>{{Session::get('message')}}</h2>
        </div>        
    </div>                
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Notícias</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="titulo" @if ($filtro == "titulo") selected @endif>Título</option>
                        <option value="subtitulo" @if ($filtro == "subtitulo") selected @endif>Subtítulo</option>
                        <option value="time" @if ($filtro == "time") selected @endif>Time</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('noticias.create') }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Nova {{substr_replace("Notícias", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($noticias->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        @foreach($noticias as $key => $noticia)
        <a href="/noticias/{{$noticia->id}}">
            <div class="noticia">
                <div class="row">
                    @if(!is_null($noticia->imagem))
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        {!! Html::image("images/noticias/$noticia->id/$noticia->imagem", $noticia->imagem) !!}
                    </div>
                    @endif
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <h2>{{$noticia->titulo}}</h2>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <h5>{{$noticia->subtitulo}}</h5>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12 footer">
                        <p>{{date_format(date_create_from_format('Y-m-d H:s:i', $noticia->created_at), 'd/m/Y H:s:i')}} - {{$noticia->nome}}</p>
                    </div>
                </div>
            </div>
            <?php if ($key != $noticias->count()-1) {echo "<hr>";} ?>
        </a>
        @endforeach
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$noticias->firstItem()}}</strong> ao <strong>{{$noticias->lastItem()}}</strong> de um total de <strong>{{$noticias->total()}}</strong> registros</p>
    {!! $noticias->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhum {{substr_replace("Noticias", "", -1)}} encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif

<style type="text/css">
    .noticia {
        margin: 20px;
        padding: 10px;
        border-radius: 10px;
        height: 170px;
        transition: all 0.3s ease;
    }
    .noticia img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
    }
    .noticia h2, .noticia h5 {font-weight: bold;}
    .noticia h2 { color: #39ADB4; }
    .noticia h5, .noticia p { color: #7f7f7f; }
</style>
@endsection
