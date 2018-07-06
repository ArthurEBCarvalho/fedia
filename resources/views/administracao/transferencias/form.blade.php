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
        Nova {{substr_replace("Transferências", "", -1)}}</h5>
    </h2>

    {!! Form::open(['route' => [$url, $transferencium->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('jogador', 'Jogador <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('jogador', $transferencium->jogador, ['class' => 'form-control','required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('valor', 'Valor <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            @if($method == 'post') {!! Form::text('valor', NULL, ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!} @else {!! Form::text('valor', number_format($transferencium->valor,2,',','.'), ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!} @endif
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time1', 'Origem <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('time1', $transferencium->time1, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time2', 'Destino <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('time2', $transferencium->time2, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('administracao.transferencias.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
@endsection