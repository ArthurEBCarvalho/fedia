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
    <h2 class="margin-bottom-10">Partidas @if($campeonato == 'Taca') Taça @else {{$campeonato}} @endif FEDIA</h2>
    <div class="row">
            <div class="col-md-6 col-sm-12 form-group">
                <form role="form" method="get">
                    <input type="hidden" name="campeonato" value="{{$campeonato}}">
                    <div class="input-group">
                        <span class="input-group-addon">Temporada: </span>
                        <input type="number" class="form-control" name="temporada" value="{{@$temporada->numero}}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-sm-12 form-group">
                <form role="form" method="get">
                    <input type="hidden" name="temporada" value="{{@$temporada->numero}}">
                    <div class="input-group">
                        <span class="input-group-addon">Campeonato: </span>
                        <select class="form-control" name="campeonato">
                            <option value="Copa" @if($campeonato == 'Copa') selected @endif>Copa</option>
                            <option value="Taca" @if($campeonato == 'Taca') selected @endif>Taça</option>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                        </span>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@if($partidas->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th colspan="16">@if($campeonato == 'Taca') Taça @else {{$campeonato}} @endif FEDIA - Temporada {{@$temporada->numero}}</th>
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
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id && !is_null(@$partidas['0|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id && !is_null(@$partidas['0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['0|1']) && isset($partidas['0|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['0|1']->time1()->escudo, @$partidas['0|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id && !is_null(@$partidas['0|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id && !is_null(@$partidas['0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['0|1']->time1()->nome}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id && !is_null(@$partidas['0|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id && !is_null(@$partidas['0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|1']->resultado1}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id && !is_null(@$partidas['0|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id && !is_null(@$partidas['0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|2']->resultado2}} @if(isset($partidas['0|2']->penalti2)) ({{$partidas['0|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['0|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['0|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
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
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id && !is_null(@$partidas['0|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id && !is_null(@$partidas['0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['0|1']) && isset($partidas['0|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['0|1']->time2()->escudo, @$partidas['0|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id && !is_null(@$partidas['0|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id && !is_null(@$partidas['0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['0|1']->time2()->nome}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id && !is_null(@$partidas['0|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id && !is_null(@$partidas['0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|1']->resultado2}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id && !is_null(@$partidas['0|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id && !is_null(@$partidas['0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|2']->resultado1}} @if(isset($partidas['0|2']->penalti1)) ({{$partidas['0|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['0|1']->time2_id)) <a href="javascript:;" onClick="add_time({{@$partidas['0|1']->id}},'fora','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['4|1']->time1()->escudo, @$partidas['4|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time1()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado1}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado2}} @if(isset($partidas['4|2']->penalti1)) ({{$partidas['4|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(!isset($partidas['4|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['4|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
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
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id && !is_null(@$partidas['4|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id && !is_null(@$partidas['1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['1|1']) && isset($partidas['1|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['1|1']->time1()->escudo, @$partidas['1|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id && !is_null(@$partidas['1|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id && !is_null(@$partidas['1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['1|1']->time1()->nome}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id && !is_null(@$partidas['1|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id && !is_null(@$partidas['1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|1']->resultado1}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id && !is_null(@$partidas['1|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id && !is_null(@$partidas['1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|2']->resultado2}} @if(isset($partidas['1|2']->penalti2)) ({{$partidas['1|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['1|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['1|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['4|1']->time2()->escudo, @$partidas['4|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time2()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado2}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado1}} @if(isset($partidas['4|2']->penalti2)) ({{$partidas['4|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(!isset($partidas['4|1']->time2_id)) <a href="javascript:;" onClick="add_time({{@$partidas['4|1']->id}},'fora','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id && !is_null(@$partidas['1|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id && !is_null(@$partidas['1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['1|1']) && isset($partidas['1|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['1|1']->time2()->escudo, @$partidas['1|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id && !is_null(@$partidas['1|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id && !is_null(@$partidas['1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['1|1']->time2()->nome}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id && !is_null(@$partidas['1|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id && !is_null(@$partidas['1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|1']->resultado2}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id && !is_null(@$partidas['1|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id && !is_null(@$partidas['1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|2']->resultado1}} @if(isset($partidas['1|2']->penalti1)) ({{$partidas['1|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['1|1']->time2_id)) <a href="javascript:;" onClick="add_time({{@$partidas['1|1']->id}},'fora','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['6|1']->time1()->escudo, @$partidas['6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($partidas['6|1'])) {{@$partidas['6|1']->time1()->nome}} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($partidas['6|1'])) {{$partidas['6|1']->resultado1}} @if(isset($partidas['6|1']->penalti1)) ({{$partidas['6|1']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(!isset($partidas['6|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['6|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
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
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id && !is_null(@$partidas['2|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id && !is_null(@$partidas['2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['2|1']) && isset($partidas['2|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['2|1']->time1()->escudo, @$partidas['2|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id && !is_null(@$partidas['2|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id && !is_null(@$partidas['2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['2|1']->time1()->nome}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id && !is_null(@$partidas['2|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id && !is_null(@$partidas['2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|1']->resultado1}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id && !is_null(@$partidas['2|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id && !is_null(@$partidas['2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|2']->resultado2}} @if(isset($partidas['2|2']->penalti2)) ({{$partidas['2|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['2|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['2|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado2 > @$partidas['6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti2 > @$partidas['6|1']->penalti1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['6|1']->time2()->escudo, @$partidas['6|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado2 > @$partidas['6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti2 > @$partidas['6|1']->penalti1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($partidas['6|1'])) {{@$partidas['6|1']->time2()->nome}} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado2 > @$partidas['6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti2 > @$partidas['6|1']->penalti1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($partidas['6|1'])) {{$partidas['6|1']->resultado2}} @if(isset($partidas['6|1']->penalti2)) ({{$partidas['6|1']->penalti2}}) @endif @endif</td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id && !is_null(@$partidas['2|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id && !is_null(@$partidas['2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['2|1']) && isset($partidas['2|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['2|1']->time2()->escudo, @$partidas['2|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id && !is_null(@$partidas['2|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id && !is_null(@$partidas['2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['2|1']->time2()->nome}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id && !is_null(@$partidas['2|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id && !is_null(@$partidas['2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|1']->resultado2}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id && !is_null(@$partidas['2|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id && !is_null(@$partidas['2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|2']->resultado1}} @if(isset($partidas['2|2']->penalti1)) ({{$partidas['2|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['2|1']->time2_id)) <a href="javascript:;" onClick="add_time({{@$partidas['2|1']->id}},'fora','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['5|1']->time1()->escudo, @$partidas['5|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time1()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado1}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado2}} @if(isset($partidas['5|2']->penalti1)) ({{$partidas['5|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(!isset($partidas['5|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['5|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
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
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id && !is_null(@$partidas['3|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id && !is_null(@$partidas['3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['3|1']) && isset($partidas['3|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['3|1']->time1()->escudo, @$partidas['3|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id && !is_null(@$partidas['3|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id && !is_null(@$partidas['3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['3|1']->time1()->nome}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id && !is_null(@$partidas['3|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id && !is_null(@$partidas['3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|1']->resultado1}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id && !is_null(@$partidas['3|1']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id && !is_null(@$partidas['3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|2']->resultado2}} @if(isset($partidas['3|2']->penalti2)) ({{$partidas['3|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['3|1']->time1_id)) <a href="javascript:;" onClick="add_time({{@$partidas['3|1']->id}},'casa','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['5|1']->time2()->escudo, @$partidas['5|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time2()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado2}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado1}} @if(isset($partidas['5|2']->penalti2)) ({{$partidas['5|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(!isset($partidas['5|1']->time2_id)) <a href="javascript:;" onClick="add_time({{@$partidas['5|1']->id}},'fora','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id && !is_null(@$partidas['3|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id && !is_null(@$partidas['3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['3|1']) && isset($partidas['3|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['3|1']->time2()->escudo, @$partidas['3|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id && !is_null(@$partidas['3|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id && !is_null(@$partidas['3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['3|1']->time2()->nome}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id && !is_null(@$partidas['3|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id && !is_null(@$partidas['3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|1']->resultado2}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id && !is_null(@$partidas['3|2']->time1_id)) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id && !is_null(@$partidas['3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|2']->resultado1}} @if(isset($partidas['3|2']->penalti1)) ({{$partidas['3|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(!isset($partidas['3|1']->time2_id)) <a href="javascript:;" onClick="add_time({{@$partidas['3|1']->id}},'fora','{{$campeonato}}')" data-toggle="modal" data-target="#modal_times">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif</td>
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

<!-- Modals -->
<div class="modal fade" id="modal_times" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {!! Form::open(['route' => 'administracao.users.copa_store', 'method' => 'post']) !!}
        <input type="hidden" id="partida_id" name="partida_id">
        <input type="hidden" id="mandante" name="mandante">
        <input type="hidden" id="campeonato" name="campeonato">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Selecione o time para esta fase da Copa</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-12">
                        {!! Html::decode(Form::label('time_id', 'Time <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                        {!! Form::select('time_id', $times, NULL, ['class' => 'chzn-select form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Sim</button>
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script type="text/javascript">
    function add_time(partida_id,mandante,campeonato) {
        $("#partida_id").val(partida_id);
        $("#mandante").val(mandante);
        $("#campeonato").val(campeonato);
        console.log(campeonato);
    }
</script>

@endsection
