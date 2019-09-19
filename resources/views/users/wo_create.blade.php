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
    <h2 class="margin-bottom-10">Aplicar WO</h2>

    {!! Form::open(['route' => 'administracao.users.wo_store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time_id', 'Time <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('time_id', $times, NULL, ['class' => 'chzn-select form-control']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('temporada_id', 'Temporada <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('temporada_id', $temporadas, $temporada->id, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('turno', 'Turno <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('turno', ['Temporada Completa','1º Turno','2º Turno'], NULL, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            <div class="checkbox squaredTwo">
                <input type="checkbox" id="copa" name="copa"/>
                <label for="copa" class="control-label"><span></span>Copa</label>
            </div>
        </div>                  
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('administracao.users.wo_create') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
@endsection