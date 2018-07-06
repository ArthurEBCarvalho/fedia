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
    <h2 class="margin-bottom-10">Partidas Liga FEDIA</h2>
    <div class="row">
        <form role="form" method="get">
            <input type="hidden" name="tipo" value="{{$tipo}}">
            <div class="col-md-6 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Temporada: </span>
                    <input type="number" class="form-control" name="temporada" value="{{$temporada}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
        </form>
        @if($tipo == "liga")
        <form role="form" method="get">
            <input type="hidden" name="tipo" value="{{$tipo}}">
            <div class="col-md-6 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Rodada: </span>
                    <input type="number" class="form-control" name="rodada" value="{{$rodada}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
@if($partidas->count())
@if($tipo == "liga")
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th colspan="7">Partidas da {{$rodada}}ª rodada da Liga FEDIA - Temporada {{$temporada}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas as $partida)
                {{ Storage::get('times/tottenham.png') }}
                <tr>
                    <td align="center">{!! Html::image(Storage::url('times/'.$partida->time1()->escudo), $partida->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td align="right">{{$partida->time1()->nome}}</td>
                    <td align="center">{{$partida->resultado1}}</td>
                    <td align="center">@if(is_null($partida->resultado1)) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','Liga')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else X @endif</td>
                    <td align="center">{{$partida->resultado2}}</td>
                    <td align="left">{{$partida->time2()->nome}}</td>
                    <td align="center">{!! Html::image(Storage::url('times/'.$partida->time2()->escudo), $partida->time2()->nome, ['class' => 'time_img']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th colspan="16">Copa FEDIA - Temporada {{$temporada}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['0|1']->time1()->escudo), @$partidas['0|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['0|1']->time1()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['0|1']->resultado1}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['0|2']->resultado2}} @if(isset($partidas['0|2']->penalti2)) ({{$partidas['0|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['0|1']) && is_null($partidas['0|1']->resultado1) && (isset($partidas['0|1']->time1_id) && isset($partidas['0|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['0|1']->id}}','{{@$partidas['0|1']->time1()->escudo}}','{{@$partidas['0|1']->time1()->nome}}','{{@$partidas['0|1']->time2()->escudo}}','{{@$partidas['0|1']->time2()->nome}}','Copa','Ida')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['0|1']->time2()->escudo), @$partidas['0|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['0|1']->time2()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['0|1']->resultado2}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['0|2']->resultado1}} @if(isset($partidas['0|2']->penalti1)) ({{$partidas['0|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['0|2']) && is_null($partidas['0|2']->resultado1) && isset($partidas['0|1']->resultado1) && (isset($partidas['0|2']->time1_id) && isset($partidas['0|2']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['0|2']->id}}','{{@$partidas['0|2']->time1()->escudo}}','{{@$partidas['0|2']->time1()->nome}}','{{@$partidas['0|2']->time2()->escudo}}','{{@$partidas['0|2']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time1_id)) {!! Html::image(Storage::url('times/'.@$partidas['4|1']->time1()->escudo), @$partidas['4|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time1()->nome}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado1}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado1}} @if(isset($partidas['4|2']->penalti1)) ({{$partidas['4|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['4|1']) && is_null($partidas['4|1']->resultado1) && (isset($partidas['4|1']->time1_id) && isset($partidas['4|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['4|1']->id}}','{{@$partidas['4|1']->time1()->escudo}}','{{@$partidas['4|1']->time1()->nome}}','{{@$partidas['4|1']->time2()->escudo}}','{{@$partidas['4|1']->time2()->nome}}','Copa','Ida')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['1|1']->time1()->escudo), @$partidas['1|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['1|1']->time1()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['1|1']->resultado1}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['1|2']->resultado2}} @if(isset($partidas['1|2']->penalti2)) ({{$partidas['1|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['1|1']) && is_null($partidas['1|1']->resultado1) && (isset($partidas['1|1']->time1_id) && isset($partidas['1|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['1|1']->id}}','{{@$partidas['1|1']->time1()->escudo}}','{{@$partidas['1|1']->time1()->nome}}','{{@$partidas['1|1']->time2()->escudo}}','{{@$partidas['1|1']->time2()->nome}}','Copa','Ida')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time2_id)) {!! Html::image(Storage::url('times/'.@$partidas['4|1']->time2()->escudo), @$partidas['4|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time2()->nome}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado2}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado2}} @if(isset($partidas['4|2']->penalti2)) ({{$partidas['4|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['4|2']) && is_null($partidas['4|2']->resultado1) && (isset($partidas['4|1']->resultado1) && isset($partidas['4|2']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['4|2']->id}}','{{@$partidas['4|2']->time1()->escudo}}','{{@$partidas['4|2']->time1()->nome}}','{{@$partidas['4|2']->time2()->escudo}}','{{@$partidas['4|2']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['1|1']->time2()->escudo), @$partidas['1|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['1|1']->time2()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['1|1']->resultado2}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['1|2']->resultado1}} @if(isset($partidas['1|2']->penalti1)) ({{$partidas['1|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['1|2']) && is_null($partidas['1|2']->resultado1) && isset($partidas['1|1']->resultado1) && (isset($partidas['1|2']->time1_id) && isset($partidas['1|2']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['1|2']->id}}','{{@$partidas['1|2']->time1()->escudo}}','{{@$partidas['1|2']->time1()->nome}}','{{@$partidas['1|2']->time2()->escudo}}','{{@$partidas['1|2']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time1_id)) {!! Html::image(Storage::url('times/'.@$partidas['6|1']->time1()->escudo), @$partidas['6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($partidas['6|1'])) {{@$partidas['6|1']->time1()->nome}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['6|1'])) {{$partidas['6|1']->resultado1}} @if(isset($partidas['6|1']->penalti1)) ({{$partidas['6|1']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['6|1']) && is_null($partidas['6|1']->resultado1) && (isset($partidas['6|1']->time1_id) && isset($partidas['6|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['6|1']->id}}','{{@$partidas['6|1']->time1()->escudo}}','{{@$partidas['6|1']->time1()->nome}}','{{@$partidas['6|1']->time2()->escudo}}','{{@$partidas['6|1']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['2|1']->time1()->escudo), @$partidas['2|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['2|1']->time1()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['2|1']->resultado1}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['2|2']->resultado2}} @if(isset($partidas['2|2']->penalti2)) ({{$partidas['2|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['2|1']) && is_null($partidas['2|1']->resultado1) && (isset($partidas['2|1']->time1_id) && isset($partidas['2|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['2|1']->id}}','{{@$partidas['2|1']->time1()->escudo}}','{{@$partidas['2|1']->time1()->nome}}','{{@$partidas['2|1']->time2()->escudo}}','{{@$partidas['2|1']->time2()->nome}}','Copa','Ida')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time2_id)) {!! Html::image(Storage::url('times/'.@$partidas['6|1']->time2()->escudo), @$partidas['6|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($partidas['6|1'])) {{@$partidas['6|1']->time2()->nome}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['6|1'])) {{$partidas['6|1']->resultado2}} @if(isset($partidas['6|1']->penalti2)) ({{$partidas['6|1']->penalti2}}) @endif @endif</td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['2|1']->time2()->escudo), @$partidas['2|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['2|1']->time2()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['2|1']->resultado2}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['2|2']->resultado1}} @if(isset($partidas['2|2']->penalti1)) ({{$partidas['2|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['2|2']) && is_null($partidas['2|2']->resultado1) && isset($partidas['2|1']->resultado1) && (isset($partidas['2|2']->time1_id) && isset($partidas['2|2']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['2|2']->id}}','{{@$partidas['2|2']->time1()->escudo}}','{{@$partidas['2|2']->time1()->nome}}','{{@$partidas['2|2']->time2()->escudo}}','{{@$partidas['2|2']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time1_id)) {!! Html::image(Storage::url('times/'.@$partidas['5|1']->time1()->escudo), @$partidas['5|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time1()->nome}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado1}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado1}} @if(isset($partidas['5|2']->penalti1)) ({{$partidas['5|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['5|1']) && is_null($partidas['5|1']->resultado1) && (isset($partidas['5|1']->time1_id) && isset($partidas['5|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['5|1']->id}}','{{@$partidas['5|1']->time1()->escudo}}','{{@$partidas['5|1']->time1()->nome}}','{{@$partidas['5|1']->time2()->escudo}}','{{@$partidas['5|1']->time2()->nome}}','Copa','Ida')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['3|1']->time1()->escudo), @$partidas['3|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['3|1']->time1()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['3|1']->resultado1}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['3|2']->resultado2}} @if(isset($partidas['3|2']->penalti2)) ({{$partidas['3|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['3|1']) && is_null($partidas['3|1']->resultado1) && (isset($partidas['3|1']->time1_id) && isset($partidas['3|1']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['3|1']->id}}','{{@$partidas['3|1']->time1()->escudo}}','{{@$partidas['3|1']->time1()->nome}}','{{@$partidas['3|1']->time2()->escudo}}','{{@$partidas['3|1']->time2()->nome}}','Copa','Ida')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time2_id)) {!! Html::image(Storage::url('times/'.@$partidas['5|1']->time2()->escudo), @$partidas['5|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time2()->nome}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado2}} @endif</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado2}} @if(isset($partidas['5|2']->penalti2)) ({{$partidas['5|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['5|2']) && is_null($partidas['5|2']->resultado1) && isset($partidas['5|1']->resultado1) && (isset($partidas['5|2']->time1_id) && isset($partidas['5|2']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['5|2']->id}}','{{@$partidas['5|2']->time1()->escudo}}','{{@$partidas['5|2']->time1()->nome}}','{{@$partidas['5|2']->time2()->escudo}}','{{@$partidas['5|2']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$partidas['3|1']->time2()->escudo), @$partidas['3|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td bgcolor="#f9f9f9" align="left" width="200">{{@$partidas['3|1']->time2()->nome}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['3|1']->resultado2}}</td>
                    <td bgcolor="#f9f9f9" align="center" width="60">{{$partidas['3|2']->resultado1}} @if(isset($partidas['3|2']->penalti1)) ({{$partidas['3|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['3|2']) && is_null($partidas['3|2']->resultado1) && isset($partidas['3|1']->resultado1) && (isset($partidas['3|2']->time1_id) && isset($partidas['3|2']->time2_id))) <a href="javascript:;" onClick="resultado('{{@$partidas['3|2']->id}}','{{@$partidas['3|2']->time1()->escudo}}','{{@$partidas['3|2']->time1()->nome}}','{{@$partidas['3|2']->time2()->escudo}}','{{@$partidas['3|2']->time2()->nome}}','Copa','Volta')" data-toggle="modal" data-target="#modal_resultado">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhum {{substr_replace("Partidas", "", -1)}} encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="modal_resultado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'administracao.partidas.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" id="partida_id" name="partida_id">
            <input type="hidden" id="campeonato" name="campeonato">
            <input type="hidden" id="temporada" name="temporada" value="{{$temporada}}">
            <input type="hidden" id="rodada" name="rodada" value="{{$rodada}}">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Resultado Liga FEDIA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered templatemo-user-table">
                    <thead>
                        <tr>
                            <th colspan="8">Liga FEDIA - Temporada {{$temporada}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('resultado1', 0, ['class' => 'form-control resultado','required' => 'true']) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('resultado2', 0, ['class' => 'form-control resultado','required' => 'true']) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <thead class="penaltis">
                        <tr>
                            <th colspan="8">Penaltis</th>
                        </tr>
                    </thead>
                    <tbody class="penaltis">
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('penalti1', null, ['class' => 'form-control']) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('penalti2', null, ['class' => 'form-control']) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Gols</th>
                            <th></th>
                            <th colspan="3">Gols</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{!! Form::text('gols_jogador1[]', null, ['class' => 'form-control','placeholder' => 'Jogador']) !!}</td>
                            <td>{!! Form::number('gols_qtd1[]', 1, ['class' => 'form-control gols','placeholder' => 'Qtd']) !!}</td>
                            <td></td>
                            <td>{!! Form::number('gols_qtd2[]', 1, ['class' => 'form-control gols','placeholder' => 'Qtd']) !!}</td>
                            <td colspan="2">{!! Form::text('gols_jogador2[]', null, ['class' => 'form-control','placeholder' => 'Jogador']) !!}</td>
                            <td>{!! Html::image('images/icons/plus.png', 'add_linha', ['class' => 'add_linha', 'onClick' => 'add_linha(this)']) !!}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Cartões</th>
                            <th></th>
                            <th colspan="3">Cartões</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{!! Form::text('cartoes_jogador1[]', null, ['class' => 'form-control','placeholder' => 'Jogador']) !!}</td>
                            <td>{!! Form::select('cartoes_cor1[]', ['Amarelo','Vermelho'], null, ['class' => 'form-control', 'style' => 'padding-left: 2px;']) !!}</td>
                            <td></td>
                            <td>{!! Form::select('cartoes_cor2[]', ['Amarelo','Vermelho'], null, ['class' => 'form-control', 'style' => 'padding-left: 2px;']) !!}</td>
                            <td colspan="2">{!! Form::text('cartoes_jogador2[]', null, ['class' => 'form-control','placeholder' => 'Jogador']) !!}</td>
                            <td>{!! Html::image('images/icons/plus.png', 'add_linha', ['class' => 'add_linha', 'onClick' => 'add_linha(this)']) !!}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Lesões</th>
                            <th></th>
                            <th colspan="3">Lesões</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">{!! Form::text('lesoes_jogador1[]', null, ['class' => 'form-control','placeholder' => 'Jogador']) !!}</td>
                            <td></td>
                            <td colspan="3">{!! Form::text('lesoes_jogador2[]', null, ['class' => 'form-control','placeholder' => 'Jogador']) !!}</td>
                            <td>{!! Html::image('images/icons/plus.png', 'add_linha', ['class' => 'add_linha', 'onClick' => 'add_linha(this)']) !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Fechar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Cadastrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<style type="text/css">
    .add_linha {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $img_path = "{{Storage::url('times/image.png')}}";
    $(".penaltis").hide();
    function resultado(id,img1,time1,img2,time2,campeonato,rodada){
        if(campeonato == "Copa" && rodada == "Volta")
            $(".penaltis").show();
        else
            $(".penaltis").hide();
        $("#partida_id").val(id);
        $("#campeonato").val(campeonato);
        $(".resultado").val(0);
        $(".gols").val(1);
        $array = $img_path.split('/');
        $array[$array.length-1] = img1;
        $(".img_1").attr('src',$array.join('/'));
        $(".time_1").html(time1);
        $array = $img_path.split('/');
        $array[$array.length-1] = img2;
        $(".img_2").attr('src',$array.join('/'));
        $(".time_2").html(time2);
    }

    function add_linha(elemento){
        $linha = $(elemento).parent().parent().clone();
        $($linha).find('input[type=text]').val('');
        $($linha).find('input[type=number]').val('1');
        $(elemento).parent().parent().after($linha);
    }
</script>
@endsection
