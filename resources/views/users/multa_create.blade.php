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
    <h2 class="margin-bottom-10">Aplicar Multa</h2>

    {!! Form::open(['route' => 'administracao.users.multa_store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time_id', 'Time <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('time_id', $times, NULL, ['class' => 'chzn-select form-control']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('valor', 'Valor <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('valor', NULL, ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group jogador_text">
        <div class="col-md-12">
            {!! Html::decode(Form::label('descricao', 'Descrição <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
@endsection