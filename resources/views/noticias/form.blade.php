@extends('template')

@section('content')
@if ($errors->any())
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>                
    <div class="media">
        <div class="media-body">
            <ul>
                @foreach($errors->all() as $error)
                <li><h2>{{ $error }}</h2></li>
                @endforeach
            </ul>
        </div>        
    </div>           
</div>     
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        Nova {{substr_replace("Notícias", "", -1)}}
    </h2>

    {!! Form::open(['route' => [$url, $noticium->id], 'method' => $method, 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('titulo', 'Título <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('titulo', $noticium->titulo, ['class' => 'form-control','required' => 'true', 'max' => '150']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('subtitulo', 'Subtítulo <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('subtitulo', $noticium->subtitulo, ['class' => 'form-control','required' => 'true', 'max' => '255']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('conteudo', 'Conteúdo <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::textarea('conteudo', $noticium->conteudo, ['class' => 'form-control ckeditor','rows' => '4', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Form::label('imagem', 'Imagem', ['class' => 'control-label']) !!}
            {!! Form::file('imagem', ['class' => 'filestyle', 'data-placeholder' => $noticium->imagem]) !!}
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('noticias.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
@endsection