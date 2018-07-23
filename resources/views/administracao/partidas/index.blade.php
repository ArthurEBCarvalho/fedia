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
@if(isset($lesionados))
@if(count($lesionados))
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>                
    <div class="media">
        <div class="media-body">
            <h2>Jogadores lesionados:</h2>
            <ul>
                @foreach($lesionados as $jogador => $rodadas)
                <li>{{$jogador}}: {{$rodadas}} rodadas fora.</li>
                @endforeach
            </ul>
        </div>        
    </div>                
</div>
@endif
@endif

@if(count($indisponiveis))
<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Jogadores Indisponíveis:</h2>
    @foreach($indisponiveis as $time => $array)
    <p><strong>{{$time}}:</strong></p>
    <ul>
        @foreach($array as $jogador)
        <li>{{$jogador}}</li>
        @endforeach
    </ul>
    @endforeach
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
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th colspan="7">Partidas da {{$rodada}}ª rodada da Liga FEDIA - Temporada {{$temporada}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas as $partida)
                <tr>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time1()->escudo, $partida->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="right">{{$partida->time1()->nome}}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado1}}</td>
                    <td align="center">@if(is_null($partida->resultado1) && Auth::user()->isAdmin()) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}',null,null,'Liga',null,'{{$rodada}}','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}',null,null,'Liga',null,'{{$rodada}}','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif</td>
                    <td @if($partida->resultado1 < $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 > $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado2}}</td>
                    <td @if($partida->resultado1 < $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 > $partida->resultado2) bgcolor="FFF0F0" @endif align="left">{{$partida->time2()->nome}}</td>
                    <td @if($partida->resultado1 < $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 > $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time2()->escudo, $partida->time2()->nome, ['class' => 'time_img']) !!}</td>
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
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['0|1']->time1()->escudo, @$partidas['0|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['0|1']->time1()->nome}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|1']->resultado1}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|2']->resultado2}} @if(isset($partidas['0|2']->penalti2)) ({{$partidas['0|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['0|1']) && isset($partidas['0|1']->time1_id) && isset($partidas['0|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['0|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['0|1']->id}}','{{@$partidas['0|1']->time1()->escudo}}','{{@$partidas['0|1']->time1()->nome}}','{{@$partidas['0|1']->time2()->escudo}}','{{@$partidas['0|1']->time2()->nome}}','{{@$partidas['0|1']->time1()->id}}','{{@$partidas['0|1']->time2()->id}}','{{@$partidas['0|1']->resultado1}}','{{@$partidas['0|1']->resultado2}}','{{@$partidas['0|1']->penalti1}}','{{@$partidas['0|1']->penalti2}}','Copa',{{@$partidas['0|1']->ordem}},'Ida','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['0|1']->id}}','{{@$partidas['0|1']->time1()->escudo}}','{{@$partidas['0|1']->time1()->nome}}','{{@$partidas['0|1']->time2()->escudo}}','{{@$partidas['0|1']->time2()->nome}}','{{@$partidas['0|1']->time1()->id}}','{{@$partidas['0|1']->time2()->id}}','{{@$partidas['0|1']->resultado1}}','{{@$partidas['0|1']->resultado2}}','{{@$partidas['0|1']->penalti1}}','{{@$partidas['0|1']->penalti2}}','Copa',{{@$partidas['0|1']->ordem}},'Ida','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['0|1']->time2()->escudo, @$partidas['0|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['0|1']->time2()->nome}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|1']->resultado2}}</td>
                    <td @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|1']->time1_id == @$partidas['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['0|2']->resultado1}} @if(isset($partidas['0|2']->penalti1)) ({{$partidas['0|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['0|2']) && isset($partidas['0|2']->time1_id) && isset($partidas['0|2']->time2_id) && isset($partidas['0|1']->resultado1) && isset($partidas['0|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['0|2']->resultado1) && is_null($partidas['0|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['0|2']->id}}','{{@$partidas['0|2']->time1()->escudo}}','{{@$partidas['0|2']->time1()->nome}}','{{@$partidas['0|2']->time2()->escudo}}','{{@$partidas['0|2']->time2()->nome}}','{{@$partidas['0|2']->time1()->id}}','{{@$partidas['0|2']->time2()->id}}','{{@$partidas['0|2']->resultado1}}','{{@$partidas['0|2']->resultado2}}','{{@$partidas['0|2']->penalti1}}','{{@$partidas['0|2']->penalti2}}','Copa',{{@$partidas['0|2']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['0|2']->id}}','{{@$partidas['0|2']->time1()->escudo}}','{{@$partidas['0|2']->time1()->nome}}','{{@$partidas['0|2']->time2()->escudo}}','{{@$partidas['0|2']->time2()->nome}}','{{@$partidas['0|2']->time1()->id}}','{{@$partidas['0|2']->time2()->id}}','{{@$partidas['0|2']->resultado1}}','{{@$partidas['0|2']->resultado2}}','{{@$partidas['0|2']->penalti1}}','{{@$partidas['0|2']->penalti2}}','Copa',{{@$partidas['0|2']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['4|1']->time1()->escudo, @$partidas['4|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time1()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado1}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado1}} @if(isset($partidas['4|2']->penalti1)) ({{$partidas['4|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time1_id) && isset($partidas['4|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['4|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['4|1']->id}}','{{@$partidas['4|1']->time1()->escudo}}','{{@$partidas['4|1']->time1()->nome}}','{{@$partidas['4|1']->time2()->escudo}}','{{@$partidas['4|1']->time2()->nome}}','{{@$partidas['4|1']->time1()->id}}','{{@$partidas['4|1']->time2()->id}}','{{@$partidas['4|1']->resultado1}}','{{@$partidas['4|1']->resultado2}}','{{@$partidas['4|1']->penalti1}}','{{@$partidas['4|1']->penalti2}}','Copa',{{@$partidas['4|1']->ordem}},'Ida','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['4|1']->id}}','{{@$partidas['4|1']->time1()->escudo}}','{{@$partidas['4|1']->time1()->nome}}','{{@$partidas['4|1']->time2()->escudo}}','{{@$partidas['4|1']->time2()->nome}}','{{@$partidas['4|1']->time1()->id}}','{{@$partidas['4|1']->time2()->id}}','{{@$partidas['4|1']->resultado1}}','{{@$partidas['4|1']->resultado2}}','{{@$partidas['4|1']->penalti1}}','{{@$partidas['4|1']->penalti2}}','Copa',{{@$partidas['4|1']->ordem}},'Ida','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['1|1']->time1()->escudo, @$partidas['1|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['1|1']->time1()->nome}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|1']->resultado1}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|2']->resultado2}} @if(isset($partidas['1|2']->penalti2)) ({{$partidas['1|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['1|1']) && isset($partidas['1|1']->time1_id) && isset($partidas['1|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['1|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['1|1']->id}}','{{@$partidas['1|1']->time1()->escudo}}','{{@$partidas['1|1']->time1()->nome}}','{{@$partidas['1|1']->time2()->escudo}}','{{@$partidas['1|1']->time2()->nome}}','{{@$partidas['1|1']->time1()->id}}','{{@$partidas['1|1']->time2()->id}}','{{@$partidas['1|1']->resultado1}}','{{@$partidas['1|1']->resultado2}}','{{@$partidas['1|1']->penalti1}}','{{@$partidas['1|1']->penalti2}}','Copa',{{@$partidas['1|1']->ordem}},'Ida','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['1|1']->id}}','{{@$partidas['1|1']->time1()->escudo}}','{{@$partidas['1|1']->time1()->nome}}','{{@$partidas['1|1']->time2()->escudo}}','{{@$partidas['1|1']->time2()->nome}}','{{@$partidas['1|1']->time1()->id}}','{{@$partidas['1|1']->time2()->id}}','{{@$partidas['1|1']->resultado1}}','{{@$partidas['1|1']->resultado2}}','{{@$partidas['1|1']->penalti1}}','{{@$partidas['1|1']->penalti2}}','Copa',{{@$partidas['1|1']->ordem}},'Ida','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['4|1']->time2()->escudo, @$partidas['4|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time2()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado2}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado2}} @if(isset($partidas['4|2']->penalti2)) ({{$partidas['4|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['4|2']) && isset($partidas['4|2']->time1_id) && isset($partidas['4|2']->time2_id) && isset($partidas['4|1']->resultado1) && isset($partidas['4|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['4|2']->resultado1) && is_null($partidas['4|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['4|2']->id}}','{{@$partidas['4|2']->time1()->escudo}}','{{@$partidas['4|2']->time1()->nome}}','{{@$partidas['4|2']->time2()->escudo}}','{{@$partidas['4|2']->time2()->nome}}','{{@$partidas['4|2']->time1()->id}}','{{@$partidas['4|2']->time2()->id}}','{{@$partidas['4|2']->resultado1}}','{{@$partidas['4|2']->resultado2}}','{{@$partidas['4|2']->penalti1}}','{{@$partidas['4|2']->penalti2}}','Copa',{{@$partidas['4|2']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['4|2']->id}}','{{@$partidas['4|2']->time1()->escudo}}','{{@$partidas['4|2']->time1()->nome}}','{{@$partidas['4|2']->time2()->escudo}}','{{@$partidas['4|2']->time2()->nome}}','{{@$partidas['4|2']->time1()->id}}','{{@$partidas['4|2']->time2()->id}}','{{@$partidas['4|2']->resultado1}}','{{@$partidas['4|2']->resultado2}}','{{@$partidas['4|2']->penalti1}}','{{@$partidas['4|2']->penalti2}}','Copa',{{@$partidas['4|2']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['1|1']->time2()->escudo, @$partidas['1|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['1|1']->time2()->nome}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|1']->resultado2}}</td>
                    <td @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['4|2']->time1_id == @$partidas['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['1|2']->resultado1}} @if(isset($partidas['1|2']->penalti1)) ({{$partidas['1|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['1|2']) && isset($partidas['1|2']->time1_id) && isset($partidas['1|2']->time2_id) && isset($partidas['1|1']->resultado1) && isset($partidas['1|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['1|2']->resultado1) && is_null($partidas['1|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['1|2']->id}}','{{@$partidas['1|2']->time1()->escudo}}','{{@$partidas['1|2']->time1()->nome}}','{{@$partidas['1|2']->time2()->escudo}}','{{@$partidas['1|2']->time2()->nome}}','{{@$partidas['1|2']->time1()->id}}','{{@$partidas['1|2']->time2()->id}}','{{@$partidas['1|2']->resultado1}}','{{@$partidas['1|2']->resultado2}}','{{@$partidas['1|2']->penalti1}}','{{@$partidas['1|2']->penalti2}}','Copa',{{@$partidas['1|2']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['1|2']->id}}','{{@$partidas['1|2']->time1()->escudo}}','{{@$partidas['1|2']->time1()->nome}}','{{@$partidas['1|2']->time2()->escudo}}','{{@$partidas['1|2']->time2()->nome}}','{{@$partidas['1|2']->time1()->id}}','{{@$partidas['1|2']->time2()->id}}','{{@$partidas['1|2']->resultado1}}','{{@$partidas['1|2']->resultado2}}','{{@$partidas['1|2']->penalti1}}','{{@$partidas['1|2']->penalti2}}','Copa',{{@$partidas['1|2']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['6|1']->time1()->escudo, @$partidas['6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($partidas['6|1'])) {{@$partidas['6|1']->time1()->nome}} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($partidas['6|1'])) {{$partidas['6|1']->resultado1}} @if(isset($partidas['6|1']->penalti1)) ({{$partidas['6|1']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time1_id) && isset($partidas['6|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['6|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['6|1']->id}}','{{@$partidas['6|1']->time1()->escudo}}','{{@$partidas['6|1']->time1()->nome}}','{{@$partidas['6|1']->time2()->escudo}}','{{@$partidas['6|1']->time2()->nome}}','{{@$partidas['6|1']->time1()->id}}','{{@$partidas['6|1']->time2()->id}}','{{@$partidas['6|1']->resultado1}}','{{@$partidas['6|1']->resultado2}}','{{@$partidas['6|1']->penalti1}}','{{@$partidas['6|1']->penalti2}}','Copa',{{@$partidas['6|1']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['6|1']->id}}','{{@$partidas['6|1']->time1()->escudo}}','{{@$partidas['6|1']->time1()->nome}}','{{@$partidas['6|1']->time2()->escudo}}','{{@$partidas['6|1']->time2()->nome}}','{{@$partidas['6|1']->time1()->id}}','{{@$partidas['6|1']->time2()->id}}','{{@$partidas['6|1']->resultado1}}','{{@$partidas['6|1']->resultado2}}','{{@$partidas['6|1']->penalti1}}','{{@$partidas['6|1']->penalti2}}','Copa',{{@$partidas['6|1']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['2|1']->time1()->escudo, @$partidas['2|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['2|1']->time1()->nome}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|1']->resultado1}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|2']->resultado2}} @if(isset($partidas['2|2']->penalti2)) ({{$partidas['2|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['2|1']) && isset($partidas['2|1']->time1_id) && isset($partidas['2|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['2|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['2|1']->id}}','{{@$partidas['2|1']->time1()->escudo}}','{{@$partidas['2|1']->time1()->nome}}','{{@$partidas['2|1']->time2()->escudo}}','{{@$partidas['2|1']->time2()->nome}}','{{@$partidas['2|1']->time1()->id}}','{{@$partidas['2|1']->time2()->id}}','{{@$partidas['2|1']->resultado1}}','{{@$partidas['2|1']->resultado2}}','{{@$partidas['2|1']->penalti1}}','{{@$partidas['2|1']->penalti2}}','Copa',{{@$partidas['2|1']->ordem}},'Ida','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['2|1']->id}}','{{@$partidas['2|1']->time1()->escudo}}','{{@$partidas['2|1']->time1()->nome}}','{{@$partidas['2|1']->time2()->escudo}}','{{@$partidas['2|1']->time2()->nome}}','{{@$partidas['2|1']->time1()->id}}','{{@$partidas['2|1']->time2()->id}}','{{@$partidas['2|1']->resultado1}}','{{@$partidas['2|1']->resultado2}}','{{@$partidas['2|1']->penalti1}}','{{@$partidas['2|1']->penalti2}}','Copa',{{@$partidas['2|1']->ordem}},'Ida','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['2|1']->time2()->escudo, @$partidas['2|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['2|1']->time2()->nome}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|1']->resultado2}}</td>
                    <td @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|1']->time1_id == @$partidas['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['2|2']->resultado1}} @if(isset($partidas['2|2']->penalti1)) ({{$partidas['2|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['2|2']) && isset($partidas['2|2']->time1_id) && isset($partidas['2|2']->time2_id) && isset($partidas['2|1']->resultado1) && isset($partidas['2|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['2|2']->resultado1) && is_null($partidas['2|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['2|2']->id}}','{{@$partidas['2|2']->time1()->escudo}}','{{@$partidas['2|2']->time1()->nome}}','{{@$partidas['2|2']->time2()->escudo}}','{{@$partidas['2|2']->time2()->nome}}','{{@$partidas['2|2']->time1()->id}}','{{@$partidas['2|2']->time2()->id}}','{{@$partidas['2|2']->resultado1}}','{{@$partidas['2|2']->resultado2}}','{{@$partidas['2|2']->penalti1}}','{{@$partidas['2|2']->penalti2}}','Copa',{{@$partidas['2|2']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['2|2']->id}}','{{@$partidas['2|2']->time1()->escudo}}','{{@$partidas['2|2']->time1()->nome}}','{{@$partidas['2|2']->time2()->escudo}}','{{@$partidas['2|2']->time2()->nome}}','{{@$partidas['2|2']->time1()->id}}','{{@$partidas['2|2']->time2()->id}}','{{@$partidas['2|2']->resultado1}}','{{@$partidas['2|2']->resultado2}}','{{@$partidas['2|2']->penalti1}}','{{@$partidas['2|2']->penalti2}}','Copa',{{@$partidas['2|2']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['5|1']->time1()->escudo, @$partidas['5|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time1()->nome}} @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado1}} @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado1}} @if(isset($partidas['5|2']->penalti1)) ({{$partidas['5|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time1_id) && isset($partidas['5|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['5|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['5|1']->id}}','{{@$partidas['5|1']->time1()->escudo}}','{{@$partidas['5|1']->time1()->nome}}','{{@$partidas['5|1']->time2()->escudo}}','{{@$partidas['5|1']->time2()->nome}}','{{@$partidas['5|1']->time1()->id}}','{{@$partidas['5|1']->time2()->id}}','{{@$partidas['5|1']->resultado1}}','{{@$partidas['5|1']->resultado2}}','{{@$partidas['5|1']->penalti1}}','{{@$partidas['5|1']->penalti2}}','Copa',{{@$partidas['5|1']->ordem}},'Ida','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['5|1']->id}}','{{@$partidas['5|1']->time1()->escudo}}','{{@$partidas['5|1']->time1()->nome}}','{{@$partidas['5|1']->time2()->escudo}}','{{@$partidas['5|1']->time2()->nome}}','{{@$partidas['5|1']->time1()->id}}','{{@$partidas['5|1']->time2()->id}}','{{@$partidas['5|1']->resultado1}}','{{@$partidas['5|1']->resultado2}}','{{@$partidas['5|1']->penalti1}}','{{@$partidas['5|1']->penalti2}}','Copa',{{@$partidas['5|1']->ordem}},'Ida','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['3|1']->time1()->escudo, @$partidas['3|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['3|1']->time1()->nome}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|1']->resultado1}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|2']->resultado2}} @if(isset($partidas['3|2']->penalti2)) ({{$partidas['3|2']->penalti2}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['3|1']) && isset($partidas['3|1']->time1_id) && isset($partidas['3|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['3|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['3|1']->id}}','{{@$partidas['3|1']->time1()->escudo}}','{{@$partidas['3|1']->time1()->nome}}','{{@$partidas['3|1']->time2()->escudo}}','{{@$partidas['3|1']->time2()->nome}}','{{@$partidas['3|1']->time1()->id}}','{{@$partidas['3|1']->time2()->id}}','{{@$partidas['3|1']->resultado1}}','{{@$partidas['3|1']->resultado2}}','{{@$partidas['3|1']->penalti1}}','{{@$partidas['3|1']->penalti2}}','Copa',{{@$partidas['3|1']->ordem}},'Ida','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['3|1']->id}}','{{@$partidas['3|1']->time1()->escudo}}','{{@$partidas['3|1']->time1()->nome}}','{{@$partidas['3|1']->time2()->escudo}}','{{@$partidas['3|1']->time2()->nome}}','{{@$partidas['3|1']->time1()->id}}','{{@$partidas['3|1']->time2()->id}}','{{@$partidas['3|1']->resultado1}}','{{@$partidas['3|1']->resultado2}}','{{@$partidas['3|1']->penalti1}}','{{@$partidas['3|1']->penalti2}}','Copa',{{@$partidas['3|1']->ordem}},'Ida','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['5|1']->time2()->escudo, @$partidas['5|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time2()->nome}} @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado2}} @endif</td>
                    <td @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|2']->time1_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado2}} @if(isset($partidas['5|2']->penalti2)) ({{$partidas['5|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['5|2']) && isset($partidas['5|2']->time1_id) && isset($partidas['5|2']->time2_id) && isset($partidas['5|1']->resultado1) && isset($partidas['5|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['5|2']->resultado1) && is_null($partidas['5|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['5|2']->id}}','{{@$partidas['5|2']->time1()->escudo}}','{{@$partidas['5|2']->time1()->nome}}','{{@$partidas['5|2']->time2()->escudo}}','{{@$partidas['5|2']->time2()->nome}}','{{@$partidas['5|2']->time1()->id}}','{{@$partidas['5|2']->time2()->id}}','{{@$partidas['5|2']->resultado1}}','{{@$partidas['5|2']->resultado2}}','{{@$partidas['5|2']->penalti1}}','{{@$partidas['5|2']->penalti2}}','Copa',{{@$partidas['5|2']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['5|2']->id}}','{{@$partidas['5|2']->time1()->escudo}}','{{@$partidas['5|2']->time1()->nome}}','{{@$partidas['5|2']->time2()->escudo}}','{{@$partidas['5|2']->time2()->nome}}','{{@$partidas['5|2']->time1()->id}}','{{@$partidas['5|2']->time2()->id}}','{{@$partidas['5|2']->resultado1}}','{{@$partidas['5|2']->resultado2}}','{{@$partidas['5|2']->penalti1}}','{{@$partidas['5|2']->penalti2}}','Copa',{{@$partidas['5|2']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                </tr>
                <tr>
                    <td style="border:0;"></td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$partidas['3|1']->time2()->escudo, @$partidas['3|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$partidas['3|1']->time2()->nome}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|1']->resultado2}}</td>
                    <td @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$partidas['5|2']->time1_id == @$partidas['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$partidas['3|2']->resultado1}} @if(isset($partidas['3|2']->penalti1)) ({{$partidas['3|2']->penalti1}}) @endif</td>
                    <td style="border:0;">@if(isset($partidas['3|2']) && isset($partidas['3|2']->time1_id) && isset($partidas['3|2']->time2_id) && isset($partidas['3|1']->resultado1) && isset($partidas['3|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['3|2']->resultado1) && is_null($partidas['3|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['3|2']->id}}','{{@$partidas['3|2']->time1()->escudo}}','{{@$partidas['3|2']->time1()->nome}}','{{@$partidas['3|2']->time2()->escudo}}','{{@$partidas['3|2']->time2()->nome}}','{{@$partidas['3|2']->time1()->id}}','{{@$partidas['3|2']->time2()->id}}','{{@$partidas['3|2']->resultado1}}','{{@$partidas['3|2']->resultado2}}','{{@$partidas['3|2']->penalti1}}','{{@$partidas['3|2']->penalti2}}','Copa',{{@$partidas['3|2']->ordem}},'Volta','store')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['3|2']->id}}','{{@$partidas['3|2']->time1()->escudo}}','{{@$partidas['3|2']->time1()->nome}}','{{@$partidas['3|2']->time2()->escudo}}','{{@$partidas['3|2']->time2()->nome}}','{{@$partidas['3|2']->time1()->id}}','{{@$partidas['3|2']->time2()->id}}','{{@$partidas['3|2']->resultado1}}','{{@$partidas['3|2']->resultado2}}','{{@$partidas['3|2']->penalti1}}','{{@$partidas['3|2']->penalti2}}','Copa',{{@$partidas['3|2']->ordem}},'Volta','show')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
<!-- Modal Store -->
<div class="modal fade" id="modal_store" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'administracao.partidas.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" id="partida_id" name="partida_id">
            <input type="hidden" id="campeonato" name="campeonato">
            <input type="hidden" id="temporada" name="temporada" value="{{$temporada}}">
            <input type="hidden" id="rodada" name="rodada" value="{{$rodada}}">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered templatemo-user-table">
                    <thead>
                        <tr>
                            <th colspan="8" class="body-title"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('resultado1', 0, ['class' => 'form-control resultado','required' => 'true', 'min' => 0]) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('resultado2', 0, ['class' => 'form-control resultado','required' => 'true', 'min' => 0]) !!}</td>
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
                            <td width="17%" align="center">{!! Form::number('penalti1', null, ['class' => 'form-control', 'min' => 0]) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('penalti2', null, ['class' => 'form-control', 'min' => 0]) !!}</td>
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
                            <td colspan="2">{!! Form::select('gols_jogador1[]', [], null, ['class' => 'chzn-select time1 form-control store']) !!}</td>
                            <td>{!! Form::number('gols_qtd1[]', 1, ['class' => 'form-control gols','placeholder' => 'Qtd']) !!}</td>
                            <td></td>
                            <td>{!! Form::number('gols_qtd2[]', 1, ['class' => 'form-control gols','placeholder' => 'Qtd']) !!}</td>
                            <td colspan="2">{!! Form::select('gols_jogador2[]', [], null, ['class' => 'chzn-select time2 form-control store']) !!}</td>
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
                            <td colspan="2">{!! Form::select('cartoes_jogador1[]', [], null, ['class' => 'chzn-select time1 form-control store']) !!}</td>
                            <td>{!! Form::select('cartoes_cor1[]', ['Amarelo','Vermelho'], null, ['class' => 'form-control', 'style' => 'padding:0;']) !!}</td>
                            <td></td>
                            <td>{!! Form::select('cartoes_cor2[]', ['Amarelo','Vermelho'], null, ['class' => 'form-control', 'style' => 'padding:0;']) !!}</td>
                            <td colspan="2">{!! Form::select('cartoes_jogador2[]', [], null, ['class' => 'chzn-select time2 form-control store']) !!}</td>
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
                            <td colspan="3">{!! Form::select('lesoes_jogador1[]', [], null, ['class' => 'chzn-select time1 lesao form-control store']) !!}</td>
                            <td></td>
                            <td colspan="3">{!! Form::select('lesoes_jogador2[]', [], null, ['class' => 'chzn-select time2 lesao form-control store']) !!}</td>
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

<!-- Modal Show -->
<div class="modal fade" id="modal_show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <input type="hidden" id="partida_id" name="partida_id">
            <input type="hidden" id="campeonato" name="campeonato">
            <input type="hidden" id="temporada" name="temporada" value="{{$temporada}}">
            <input type="hidden" id="rodada" name="rodada" value="{{$rodada}}">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered templatemo-user-table">
                    <thead>
                        <tr>
                            <th colspan="8" class="body-title"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('resultado1', 0, ['class' => 'form-control resultado','disabled' => 'true', 'id' => 'resultado1', 'min' => 0]) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('resultado2', 0, ['class' => 'form-control resultado','disabled' => 'true', 'id' => 'resultado2', 'min' => 0]) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
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
                            <td width="17%" align="center">{!! Form::number('penalti1', null, ['class' => 'form-control', 'id' => 'penalti1', 'disabled' => 'true']) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('penalti2', null, ['class' => 'form-control', 'id' => 'penalti2', 'disabled' => 'true']) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Gols</th>
                            <th></th>
                            <th colspan="3">Gols</th>
                        </tr>
                    </thead>
                    <tbody id="gols">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Cartões</th>
                            <th></th>
                            <th colspan="3">Cartões</th>
                        </tr>
                    </thead>
                    <tbody id="cartoes">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Lesões</th>
                            <th></th>
                            <th colspan="3">Lesões</th>
                        </tr>
                    </thead>
                    <tbody id="lesoes">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .add_linha {
        cursor: pointer;
    }

    .chzn-container, .chzn-drop, .chzn-search input { width: 100% !important; }

    #modal_store { overflow-y:scroll;overflow-x:scroll; }
    @media screen and (max-width: 992px) {
        #modal_store .modal-content { width: 685px; }
        #modal_store table { width: 640px; }
    }
    #modal_store input { min-width: 60px; }
</style>
<script type="text/javascript">
    $img_path = "images/times/image.png";
    $(".penaltis").hide();

    $jogadores = [];
    $nomes = [];
    $gols = [];
    $cartoes = [];
    $lesoes = [];
    $cor = ['Amarelo','Vermelho'];

    <?php 
    foreach($jogadores as $time_id => $list){
        echo 'if(!$jogadores[\''.$time_id.'\']){$jogadores[\''.$time_id.'\'] = [];}';
        foreach ($list as $key => $value){
            echo '$jogadores[\''.$time_id.'\'].push({\'id\': '.$value->id.', \'nome\': \''.$value->nome.'\'});';
            echo '$nomes['.$value->id.'] = \''.$value->nome.'\';';
        }
    }

    foreach($gols as $value){
        echo 'if(!$gols[\''.$value->partida_id.'_'.$value->time_id.'\']){$gols[\''.$value->partida_id.'_'.$value->time_id.'\'] = [];}';
        echo '$gols[\''.$value->partida_id.'_'.$value->time_id.'\'].push({\'jogador\': '.$value->jogador_id.', \'time\': '.$value->time_id.', \'quantidade\': '.$value->quantidade.'});';
    }
    foreach($cartoes as $value){
        echo 'if(!$cartoes[\''.$value->partida_id.'_'.$value->time_id.'\']){$cartoes[\''.$value->partida_id.'_'.$value->time_id.'\'] = [];}';
        echo '$cartoes[\''.$value->partida_id.'_'.$value->time_id.'\'].push({\'jogador\': '.$value->jogador_id.', \'time\': '.$value->time_id.', \'cor\': '.$value->cor.'});';
    }
    foreach($lesoes as $value){
        echo 'if(!$lesoes[\''.$value->partida_id.'_'.$value->time_id.'\']){$lesoes[\''.$value->partida_id.'_'.$value->time_id.'\'] = [];}';
        echo '$lesoes[\''.$value->partida_id.'_'.$value->time_id.'\'].push({\'jogador\': '.$value->jogador_id.', \'time\': '.$value->time_id.', \'rodadas\': '.$value->rodadas.'});';
    }
    ?>

    function resultado(id,img1,time1,img2,time2,id1,id2,resultado1,resultado2,penalti1,penalti2,campeonato,ordem,rodada,tipo){
        if(campeonato == "Copa" && rodada == "Volta")
            $(".penaltis").show();
        else
            $(".penaltis").hide();
        $("#partida_id").val(id);
        $("#campeonato").val(campeonato);
        $(".resultado").val(0);
        $(".gols").val(0);
        $array = $img_path.split('/');
        $array[$array.length-1] = img1;
        $(".img_1").attr('src',"{{Request::root()}}/"+$array.join('/'));
        $(".time_1").html(time1);
        $array = $img_path.split('/');
        $array[$array.length-1] = img2;
        $(".img_2").attr('src',"{{Request::root()}}/"+$array.join('/'));
        $(".time_2").html(time2);
        if(tipo == 'show'){
            $("#modal_show").find('.modal-title').html('Visualizar Resultado da '+campeonato+' FEDIA');
            if(campeonato == 'Copa'){
                if([0,1,2,3].includes(ordem))
                    $message = 'Quartas de Final'+' - '+rodada;
                else if([4,5].includes(ordem))
                    $message = 'Semi-Final'+' - '+rodada;
                else
                    $message = 'Final';
                $("#modal_show").find('.body-title').html($message);
            } else {
                $("#modal_show").find('.body-title').html('Rodada '+rodada);
            }
            $("#modal_show").find('tbody#gols').html('');
            $("#modal_show").find('tbody#cartoes').html('');
            $("#modal_show").find('tbody#lesoes').html('');
            $("#modal_show").find('input#resultado1').val(resultado1);
            $("#modal_show").find('input#resultado2').val(resultado2);
            $("#modal_show").find('input#penalti1').val(penalti1);
            $("#modal_show").find('input#penalti2').val(penalti2);
            // gols
            $row = '';
            if(typeof $gols[id+'_'+id1] !== 'undefined'){$tamanho1 = $gols[id+'_'+id1].length;}else{$tamanho1 = 0;}
            if(typeof $gols[id+'_'+id2] !== 'undefined'){$tamanho2 = $gols[id+'_'+id2].length;}else{$tamanho2 = 0;}
            if($tamanho1 > $tamanho2)
                $maior = $tamanho1;
            else
                $maior = $tamanho2;
            for (var index = 0; index < $maior; index++) {
                if(typeof $gols[id+'_'+id1] !== 'undefined' && typeof $gols[id+'_'+id1][index] !== 'undefined'){
                    $jogador1 = $nomes[$gols[id+'_'+id1][index]['jogador']];
                    $qtd1 = $gols[id+'_'+id1][index]['quantidade'];
                } else {
                    $jogador1 = '';
                    $qtd1 = '';
                }
                if(typeof $gols[id+'_'+id2] !== 'undefined' && typeof $gols[id+'_'+id2][index] !== 'undefined'){
                    $jogador2 = $nomes[$gols[id+'_'+id2][index]['jogador']];
                    $qtd2 = $gols[id+'_'+id2][index]['quantidade'];
                } else {
                    $jogador2 = '';
                    $qtd2 = '';
                }
                $row += '<tr><td colspan="2">'+$jogador1+'</td><td>'+$qtd1+'</td><td></td><td colspan="2">'+$jogador2+'</td><td>'+$qtd2+'</td></tr>';
            }
            $("#modal_show").find('tbody#gols').append($row);
            // cartões
            $row = '';
            if(typeof $cartoes[id+'_'+id1] !== 'undefined'){$tamanho1 = $cartoes[id+'_'+id1].length;}else{$tamanho1 = 0;}
            if(typeof $cartoes[id+'_'+id2] !== 'undefined'){$tamanho2 = $cartoes[id+'_'+id2].length;}else{$tamanho2 = 0;}
            if($tamanho1 > $tamanho2)
                $maior = $tamanho1;
            else
                $maior = $tamanho2;
            for (var index = 0; index < $maior; index++) {
                if(typeof $cartoes[id+'_'+id1] !== 'undefined' && typeof $cartoes[id+'_'+id1][index] !== 'undefined'){
                    $jogador1 = $nomes[$cartoes[id+'_'+id1][index]['jogador']];
                    $cor1 = $cor[$cartoes[id+'_'+id1][index]['cor']];
                } else {
                    $jogador1 = '';
                    $cor1 = '';
                }
                if(typeof $cartoes[id+'_'+id2] !== 'undefined' && typeof $cartoes[id+'_'+id2][index] !== 'undefined'){
                    $jogador2 = $nomes[$cartoes[id+'_'+id2][index]['jogador']];
                    $cor2 = $cor[$cartoes[id+'_'+id2][index]['cor']];
                } else {
                    $jogador2 = '';
                    $cor2 = '';
                }
                $row += '<tr><td colspan="2">'+$jogador1+'</td><td>'+$cor1+'</td><td></td><td colspan="2">'+$jogador2+'</td><td>'+$cor2+'</td></tr>';
            }
            $("#modal_show").find('tbody#cartoes').append($row);
            // lesões
            $row = '';
            if(typeof $lesoes[id+'_'+id1] !== 'undefined'){$tamanho1 = $lesoes[id+'_'+id1].length;}else{$tamanho1 = 0;}
            if(typeof $lesoes[id+'_'+id2] !== 'undefined'){$tamanho2 = $lesoes[id+'_'+id2].length;}else{$tamanho2 = 0;}
            if($tamanho1 > $tamanho2)
                $maior = $tamanho1;
            else
                $maior = $tamanho2;
            for (var index = 0; index < $maior; index++) {
                if(typeof $lesoes[id+'_'+id1] !== 'undefined' && typeof $lesoes[id+'_'+id1][index] !== 'undefined'){
                    $jogador1 = $nomes[$lesoes[id+'_'+id1][index]['jogador']];
                    $qtd1 = ', '+ $lesoes[id+'_'+id1][index]['rodadas']+' rodada(s)';
                } else {
                    $jogador1 = '';
                    $qtd1 = '';
                }
                if(typeof $lesoes[id+'_'+id2] !== 'undefined' && typeof $lesoes[id+'_'+id2][index] !== 'undefined'){
                    $jogador2 = $nomes[$lesoes[id+'_'+id2][index]['jogador']];
                    $qtd2 = ', '+$lesoes[id+'_'+id2][index]['rodadas']+' rodada(s)';
                } else {
                    $jogador2 = '';
                    $qtd2 = '';
                }
                $row += '<tr><td colspan="3">'+$jogador1+$qtd1+'</td><td></td><td colspan="3">'+$jogador2+$qtd2+'</td></tr>';
            }
            $("#modal_show").find('tbody#lesoes').append($row);
        } else {
            $("#modal_store").find('.modal-title').html('Cadastrar Resultado da '+campeonato+' FEDIA');
            $("#modal_store").find('.body-title').html('Rodada '+rodada);
            $("#modal_store").find('select.chzn-select > option').remove();
            $("#modal_store").find('select.time1').each(function( index ) {
                $(this).append("<option value=''>Nenhum</option>");
                for(var index in $jogadores[id1])
                    $(this).append("<option value='"+$jogadores[id1][index]['id']+"'>"+$jogadores[id1][index]['nome']+"</option>");
                $(this).trigger("liszt:updated");
            });
            $("#modal_store").find('select.time2').each(function( index ) {
                $(this).append("<option value=''>Nenhum</option>");
                for(var index in $jogadores[id2])
                    $(this).append("<option value='"+$jogadores[id2][index]['id']+"'>"+$jogadores[id2][index]['nome']+"</option>");
                $(this).trigger("liszt:updated");
            });
        }
    }

    function add_linha(elemento){
        $linha = $(elemento).parent().parent().clone();
        $($linha).find('input[type=text]').val('');
        $($linha).find('input[type=number]').val('0');
        $(elemento).parent().parent().after($linha);
        $size = $(elemento).parent().parent().parent().find('tr').size();
        // Restaura chzn-select
        $($linha).find('select.time1').attr('id',$($linha).find('select').attr('id')+"_1_"+$size);
        $($linha).find('select.time2').attr('id',$($linha).find('select').attr('id')+"_2_"+$size);
        $($linha).find('.chzn-container').remove();
        $($linha).find('.chzn-select').show();
        $($linha).find('.chzn-select').removeClass('chzn-done');
        $($linha).find('.chzn-select').chosen();
    }
</script>
@endsection
