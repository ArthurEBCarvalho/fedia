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
        Nova {{substr_replace("Partidas", "", -1)}}</h5>
    </h2>

    {!! Form::open(['route' => [$url, $partida->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('campeonato', 'Campeonato <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('campeonato', ["Liga FEDIA","Copa FEDIA"], $partida->campeonato, ['class' => 'form-control','required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('rodada', 'Rodada <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('rodada', $partida->rodada, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('temporada', 'Temporada <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('temporada', $partida->temporada, ['class' => 'form-control','required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time1_id', 'Time Casa <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('time1_id', $times, $partida->time1_id, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time2_id', 'Time Fora <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('time2_id', $times, $partida->time2_id, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('resultado1', 'Resultado Casa <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('resultado1', $partida->resultado1, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('resultado2', 'Resultado Fora <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('resultado2', $partida->resultado2, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('penalti1', 'Penalti Casa <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('penalti1', $partida->penalti1, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('penalti2', 'Penalti Fora <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('penalti2', $partida->penalti2, ['class' => 'form-control','onKeyPress' => 'validar_numero(event)', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('administracao.partidas.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
@endsection