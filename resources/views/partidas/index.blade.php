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
                    <td align="center">@if(is_null($partida->resultado1) && Auth::user()->isAdmin()) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}',null,null,'Liga',null,'{{$rodada}}','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}',null,null,'Liga',null,'{{$rodada}}','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['0|1']) && isset($partidas['0|1']->time1_id) && isset($partidas['0|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['0|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['0|1']->id}}','{{@$partidas['0|1']->time1()->escudo}}','{{@$partidas['0|1']->time1()->nome}}','{{@$partidas['0|1']->time2()->escudo}}','{{@$partidas['0|1']->time2()->nome}}','{{@$partidas['0|1']->time1()->id}}','{{@$partidas['0|1']->time2()->id}}','{{@$partidas['0|1']->resultado1}}','{{@$partidas['0|1']->resultado2}}','{{@$partidas['0|1']->penalti1}}','{{@$partidas['0|1']->penalti2}}','Copa',{{@$partidas['0|1']->ordem}},'Ida','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['0|1']->id}}','{{@$partidas['0|1']->time1()->escudo}}','{{@$partidas['0|1']->time1()->nome}}','{{@$partidas['0|1']->time2()->escudo}}','{{@$partidas['0|1']->time2()->nome}}','{{@$partidas['0|1']->time1()->id}}','{{@$partidas['0|1']->time2()->id}}','{{@$partidas['0|1']->resultado1}}','{{@$partidas['0|1']->resultado2}}','{{@$partidas['0|1']->penalti1}}','{{@$partidas['0|1']->penalti2}}','Copa',{{@$partidas['0|1']->ordem}},'Ida','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['0|2']) && isset($partidas['0|2']->time1_id) && isset($partidas['0|2']->time2_id) && isset($partidas['0|1']->resultado1) && isset($partidas['0|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['0|2']->resultado1) && is_null($partidas['0|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['0|2']->id}}','{{@$partidas['0|2']->time1()->escudo}}','{{@$partidas['0|2']->time1()->nome}}','{{@$partidas['0|2']->time2()->escudo}}','{{@$partidas['0|2']->time2()->nome}}','{{@$partidas['0|2']->time1()->id}}','{{@$partidas['0|2']->time2()->id}}','{{@$partidas['0|2']->resultado1}}','{{@$partidas['0|2']->resultado2}}','{{@$partidas['0|2']->penalti1}}','{{@$partidas['0|2']->penalti2}}','Copa',{{@$partidas['0|2']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['0|2']->id}}','{{@$partidas['0|2']->time1()->escudo}}','{{@$partidas['0|2']->time1()->nome}}','{{@$partidas['0|2']->time2()->escudo}}','{{@$partidas['0|2']->time2()->nome}}','{{@$partidas['0|2']->time1()->id}}','{{@$partidas['0|2']->time2()->id}}','{{@$partidas['0|2']->resultado1}}','{{@$partidas['0|2']->resultado2}}','{{@$partidas['0|2']->penalti1}}','{{@$partidas['0|2']->penalti2}}','Copa',{{@$partidas['0|2']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['4|1']->time1()->escudo, @$partidas['4|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time1()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado1}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|1']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado2}} @if(isset($partidas['4|2']->penalti1)) ({{$partidas['4|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time1_id) && isset($partidas['4|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['4|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['4|1']->id}}','{{@$partidas['4|1']->time1()->escudo}}','{{@$partidas['4|1']->time1()->nome}}','{{@$partidas['4|1']->time2()->escudo}}','{{@$partidas['4|1']->time2()->nome}}','{{@$partidas['4|1']->time1()->id}}','{{@$partidas['4|1']->time2()->id}}','{{@$partidas['4|1']->resultado1}}','{{@$partidas['4|1']->resultado2}}','{{@$partidas['4|1']->penalti1}}','{{@$partidas['4|1']->penalti2}}','Copa',{{@$partidas['4|1']->ordem}},'Ida','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['4|1']->id}}','{{@$partidas['4|1']->time1()->escudo}}','{{@$partidas['4|1']->time1()->nome}}','{{@$partidas['4|1']->time2()->escudo}}','{{@$partidas['4|1']->time2()->nome}}','{{@$partidas['4|1']->time1()->id}}','{{@$partidas['4|1']->time2()->id}}','{{@$partidas['4|1']->resultado1}}','{{@$partidas['4|1']->resultado2}}','{{@$partidas['4|1']->penalti1}}','{{@$partidas['4|1']->penalti2}}','Copa',{{@$partidas['4|1']->ordem}},'Ida','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['1|1']) && isset($partidas['1|1']->time1_id) && isset($partidas['1|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['1|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['1|1']->id}}','{{@$partidas['1|1']->time1()->escudo}}','{{@$partidas['1|1']->time1()->nome}}','{{@$partidas['1|1']->time2()->escudo}}','{{@$partidas['1|1']->time2()->nome}}','{{@$partidas['1|1']->time1()->id}}','{{@$partidas['1|1']->time2()->id}}','{{@$partidas['1|1']->resultado1}}','{{@$partidas['1|1']->resultado2}}','{{@$partidas['1|1']->penalti1}}','{{@$partidas['1|1']->penalti2}}','Copa',{{@$partidas['1|1']->ordem}},'Ida','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['1|1']->id}}','{{@$partidas['1|1']->time1()->escudo}}','{{@$partidas['1|1']->time1()->nome}}','{{@$partidas['1|1']->time2()->escudo}}','{{@$partidas['1|1']->time2()->nome}}','{{@$partidas['1|1']->time1()->id}}','{{@$partidas['1|1']->time2()->id}}','{{@$partidas['1|1']->resultado1}}','{{@$partidas['1|1']->resultado2}}','{{@$partidas['1|1']->penalti1}}','{{@$partidas['1|1']->penalti2}}','Copa',{{@$partidas['1|1']->ordem}},'Ida','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['4|1']) && isset($partidas['4|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['4|1']->time2()->escudo, @$partidas['4|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['4|1'])) {{@$partidas['4|1']->time2()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|1'])) {{$partidas['4|1']->resultado2}} @endif</td>
                    <td @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time1_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time1_id == @$partidas['4|2']->time2_id) && !is_null(@$partidas['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['4|2'])) {{$partidas['4|2']->resultado1}} @if(isset($partidas['4|2']->penalti2)) ({{$partidas['4|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['4|2']) && isset($partidas['4|2']->time1_id) && isset($partidas['4|2']->time2_id) && isset($partidas['4|1']->resultado1) && isset($partidas['4|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['4|2']->resultado1) && is_null($partidas['4|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['4|2']->id}}','{{@$partidas['4|2']->time1()->escudo}}','{{@$partidas['4|2']->time1()->nome}}','{{@$partidas['4|2']->time2()->escudo}}','{{@$partidas['4|2']->time2()->nome}}','{{@$partidas['4|2']->time1()->id}}','{{@$partidas['4|2']->time2()->id}}','{{@$partidas['4|2']->resultado1}}','{{@$partidas['4|2']->resultado2}}','{{@$partidas['4|2']->penalti1}}','{{@$partidas['4|2']->penalti2}}','Copa',{{@$partidas['4|2']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['4|2']->id}}','{{@$partidas['4|2']->time1()->escudo}}','{{@$partidas['4|2']->time1()->nome}}','{{@$partidas['4|2']->time2()->escudo}}','{{@$partidas['4|2']->time2()->nome}}','{{@$partidas['4|2']->time1()->id}}','{{@$partidas['4|2']->time2()->id}}','{{@$partidas['4|2']->resultado1}}','{{@$partidas['4|2']->resultado2}}','{{@$partidas['4|2']->penalti1}}','{{@$partidas['4|2']->penalti2}}','Copa',{{@$partidas['4|2']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['1|2']) && isset($partidas['1|2']->time1_id) && isset($partidas['1|2']->time2_id) && isset($partidas['1|1']->resultado1) && isset($partidas['1|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['1|2']->resultado1) && is_null($partidas['1|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['1|2']->id}}','{{@$partidas['1|2']->time1()->escudo}}','{{@$partidas['1|2']->time1()->nome}}','{{@$partidas['1|2']->time2()->escudo}}','{{@$partidas['1|2']->time2()->nome}}','{{@$partidas['1|2']->time1()->id}}','{{@$partidas['1|2']->time2()->id}}','{{@$partidas['1|2']->resultado1}}','{{@$partidas['1|2']->resultado2}}','{{@$partidas['1|2']->penalti1}}','{{@$partidas['1|2']->penalti2}}','Copa',{{@$partidas['1|2']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['1|2']->id}}','{{@$partidas['1|2']->time1()->escudo}}','{{@$partidas['1|2']->time1()->nome}}','{{@$partidas['1|2']->time2()->escudo}}','{{@$partidas['1|2']->time2()->nome}}','{{@$partidas['1|2']->time1()->id}}','{{@$partidas['1|2']->time2()->id}}','{{@$partidas['1|2']->resultado1}}','{{@$partidas['1|2']->resultado2}}','{{@$partidas['1|2']->penalti1}}','{{@$partidas['1|2']->penalti2}}','Copa',{{@$partidas['1|2']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td style="border:0;"></td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['6|1']->time1()->escudo, @$partidas['6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($partidas['6|1'])) {{@$partidas['6|1']->time1()->nome}} @endif</td>
                    <td @if(is_null(@$partidas['6|1']->penalti1) && is_null(@$partidas['6|1']->penalti2)) @if(is_null(@$partidas['6|1']->resultado1) && is_null(@$partidas['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$partidas['6|1']->resultado1 > @$partidas['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$partidas['6|1']->penalti1 > @$partidas['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($partidas['6|1'])) {{$partidas['6|1']->resultado1}} @if(isset($partidas['6|1']->penalti1)) ({{$partidas['6|1']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['6|1']) && isset($partidas['6|1']->time1_id) && isset($partidas['6|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['6|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['6|1']->id}}','{{@$partidas['6|1']->time1()->escudo}}','{{@$partidas['6|1']->time1()->nome}}','{{@$partidas['6|1']->time2()->escudo}}','{{@$partidas['6|1']->time2()->nome}}','{{@$partidas['6|1']->time1()->id}}','{{@$partidas['6|1']->time2()->id}}','{{@$partidas['6|1']->resultado1}}','{{@$partidas['6|1']->resultado2}}','{{@$partidas['6|1']->penalti1}}','{{@$partidas['6|1']->penalti2}}','Copa',{{@$partidas['6|1']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['6|1']->id}}','{{@$partidas['6|1']->time1()->escudo}}','{{@$partidas['6|1']->time1()->nome}}','{{@$partidas['6|1']->time2()->escudo}}','{{@$partidas['6|1']->time2()->nome}}','{{@$partidas['6|1']->time1()->id}}','{{@$partidas['6|1']->time2()->id}}','{{@$partidas['6|1']->resultado1}}','{{@$partidas['6|1']->resultado2}}','{{@$partidas['6|1']->penalti1}}','{{@$partidas['6|1']->penalti2}}','Copa',{{@$partidas['6|1']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['2|1']) && isset($partidas['2|1']->time1_id) && isset($partidas['2|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['2|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['2|1']->id}}','{{@$partidas['2|1']->time1()->escudo}}','{{@$partidas['2|1']->time1()->nome}}','{{@$partidas['2|1']->time2()->escudo}}','{{@$partidas['2|1']->time2()->nome}}','{{@$partidas['2|1']->time1()->id}}','{{@$partidas['2|1']->time2()->id}}','{{@$partidas['2|1']->resultado1}}','{{@$partidas['2|1']->resultado2}}','{{@$partidas['2|1']->penalti1}}','{{@$partidas['2|1']->penalti2}}','Copa',{{@$partidas['2|1']->ordem}},'Ida','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['2|1']->id}}','{{@$partidas['2|1']->time1()->escudo}}','{{@$partidas['2|1']->time1()->nome}}','{{@$partidas['2|1']->time2()->escudo}}','{{@$partidas['2|1']->time2()->nome}}','{{@$partidas['2|1']->time1()->id}}','{{@$partidas['2|1']->time2()->id}}','{{@$partidas['2|1']->resultado1}}','{{@$partidas['2|1']->resultado2}}','{{@$partidas['2|1']->penalti1}}','{{@$partidas['2|1']->penalti2}}','Copa',{{@$partidas['2|1']->ordem}},'Ida','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['2|2']) && isset($partidas['2|2']->time1_id) && isset($partidas['2|2']->time2_id) && isset($partidas['2|1']->resultado1) && isset($partidas['2|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['2|2']->resultado1) && is_null($partidas['2|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['2|2']->id}}','{{@$partidas['2|2']->time1()->escudo}}','{{@$partidas['2|2']->time1()->nome}}','{{@$partidas['2|2']->time2()->escudo}}','{{@$partidas['2|2']->time2()->nome}}','{{@$partidas['2|2']->time1()->id}}','{{@$partidas['2|2']->time2()->id}}','{{@$partidas['2|2']->resultado1}}','{{@$partidas['2|2']->resultado2}}','{{@$partidas['2|2']->penalti1}}','{{@$partidas['2|2']->penalti2}}','Copa',{{@$partidas['2|2']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['2|2']->id}}','{{@$partidas['2|2']->time1()->escudo}}','{{@$partidas['2|2']->time1()->nome}}','{{@$partidas['2|2']->time2()->escudo}}','{{@$partidas['2|2']->time2()->nome}}','{{@$partidas['2|2']->time1()->id}}','{{@$partidas['2|2']->time2()->id}}','{{@$partidas['2|2']->resultado1}}','{{@$partidas['2|2']->resultado2}}','{{@$partidas['2|2']->penalti1}}','{{@$partidas['2|2']->penalti2}}','Copa',{{@$partidas['2|2']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time1_id)) {!! Html::image('images/times/'.@$partidas['5|1']->time1()->escudo, @$partidas['5|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time1()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado1}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|1']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado2}} @if(isset($partidas['5|2']->penalti1)) ({{$partidas['5|2']->penalti1}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time1_id) && isset($partidas['5|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['5|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['5|1']->id}}','{{@$partidas['5|1']->time1()->escudo}}','{{@$partidas['5|1']->time1()->nome}}','{{@$partidas['5|1']->time2()->escudo}}','{{@$partidas['5|1']->time2()->nome}}','{{@$partidas['5|1']->time1()->id}}','{{@$partidas['5|1']->time2()->id}}','{{@$partidas['5|1']->resultado1}}','{{@$partidas['5|1']->resultado2}}','{{@$partidas['5|1']->penalti1}}','{{@$partidas['5|1']->penalti2}}','Copa',{{@$partidas['5|1']->ordem}},'Ida','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['5|1']->id}}','{{@$partidas['5|1']->time1()->escudo}}','{{@$partidas['5|1']->time1()->nome}}','{{@$partidas['5|1']->time2()->escudo}}','{{@$partidas['5|1']->time2()->nome}}','{{@$partidas['5|1']->time1()->id}}','{{@$partidas['5|1']->time2()->id}}','{{@$partidas['5|1']->resultado1}}','{{@$partidas['5|1']->resultado2}}','{{@$partidas['5|1']->penalti1}}','{{@$partidas['5|1']->penalti2}}','Copa',{{@$partidas['5|1']->ordem}},'Ida','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['3|1']) && isset($partidas['3|1']->time1_id) && isset($partidas['3|1']->time2_id)) @if(Auth::user()->isAdmin() && is_null($partidas['3|1']->resultado1)) <a href="javascript:;" onClick="resultado('{{@$partidas['3|1']->id}}','{{@$partidas['3|1']->time1()->escudo}}','{{@$partidas['3|1']->time1()->nome}}','{{@$partidas['3|1']->time2()->escudo}}','{{@$partidas['3|1']->time2()->nome}}','{{@$partidas['3|1']->time1()->id}}','{{@$partidas['3|1']->time2()->id}}','{{@$partidas['3|1']->resultado1}}','{{@$partidas['3|1']->resultado2}}','{{@$partidas['3|1']->penalti1}}','{{@$partidas['3|1']->penalti2}}','Copa',{{@$partidas['3|1']->ordem}},'Ida','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['3|1']->id}}','{{@$partidas['3|1']->time1()->escudo}}','{{@$partidas['3|1']->time1()->nome}}','{{@$partidas['3|1']->time2()->escudo}}','{{@$partidas['3|1']->time2()->nome}}','{{@$partidas['3|1']->time1()->id}}','{{@$partidas['3|1']->time2()->id}}','{{@$partidas['3|1']->resultado1}}','{{@$partidas['3|1']->resultado2}}','{{@$partidas['3|1']->penalti1}}','{{@$partidas['3|1']->penalti2}}','Copa',{{@$partidas['3|1']->ordem}},'Ida','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($partidas['5|1']) && isset($partidas['5|1']->time2_id)) {!! Html::image('images/times/'.@$partidas['5|1']->time2()->escudo, @$partidas['5|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($partidas['5|1'])) {{@$partidas['5|1']->time2()->nome}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|1'])) {{$partidas['5|1']->resultado2}} @endif</td>
                    <td @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time1_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="#F0FFF0" @else @if((@$partidas['6|1']->time2_id == @$partidas['5|2']->time2_id) && !is_null(@$partidas['6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($partidas['5|2'])) {{$partidas['5|2']->resultado1}} @if(isset($partidas['5|2']->penalti2)) ({{$partidas['5|2']->penalti2}}) @endif @endif</td>
                    <td style="border:0;">@if(isset($partidas['5|2']) && isset($partidas['5|2']->time1_id) && isset($partidas['5|2']->time2_id) && isset($partidas['5|1']->resultado1) && isset($partidas['5|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['5|2']->resultado1) && is_null($partidas['5|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['5|2']->id}}','{{@$partidas['5|2']->time1()->escudo}}','{{@$partidas['5|2']->time1()->nome}}','{{@$partidas['5|2']->time2()->escudo}}','{{@$partidas['5|2']->time2()->nome}}','{{@$partidas['5|2']->time1()->id}}','{{@$partidas['5|2']->time2()->id}}','{{@$partidas['5|2']->resultado1}}','{{@$partidas['5|2']->resultado2}}','{{@$partidas['5|2']->penalti1}}','{{@$partidas['5|2']->penalti2}}','Copa',{{@$partidas['5|2']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['5|2']->id}}','{{@$partidas['5|2']->time1()->escudo}}','{{@$partidas['5|2']->time1()->nome}}','{{@$partidas['5|2']->time2()->escudo}}','{{@$partidas['5|2']->time2()->nome}}','{{@$partidas['5|2']->time1()->id}}','{{@$partidas['5|2']->time2()->id}}','{{@$partidas['5|2']->resultado1}}','{{@$partidas['5|2']->resultado2}}','{{@$partidas['5|2']->penalti1}}','{{@$partidas['5|2']->penalti2}}','Copa',{{@$partidas['5|2']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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
                    <td style="border:0;">@if(isset($partidas['3|2']) && isset($partidas['3|2']->time1_id) && isset($partidas['3|2']->time2_id) && isset($partidas['3|1']->resultado1) && isset($partidas['3|1']->resultado2)) @if(Auth::user()->isAdmin() && is_null($partidas['3|2']->resultado1) && is_null($partidas['3|2']->resultado2)) <a href="javascript:;" onClick="resultado('{{@$partidas['3|2']->id}}','{{@$partidas['3|2']->time1()->escudo}}','{{@$partidas['3|2']->time1()->nome}}','{{@$partidas['3|2']->time2()->escudo}}','{{@$partidas['3|2']->time2()->nome}}','{{@$partidas['3|2']->time1()->id}}','{{@$partidas['3|2']->time2()->id}}','{{@$partidas['3|2']->resultado1}}','{{@$partidas['3|2']->resultado2}}','{{@$partidas['3|2']->penalti1}}','{{@$partidas['3|2']->penalti2}}','Copa',{{@$partidas['3|2']->ordem}},'Volta','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @else <a href="javascript:;" onClick="resultado('{{@$partidas['3|2']->id}}','{{@$partidas['3|2']->time1()->escudo}}','{{@$partidas['3|2']->time1()->nome}}','{{@$partidas['3|2']->time2()->escudo}}','{{@$partidas['3|2']->time2()->nome}}','{{@$partidas['3|2']->time1()->id}}','{{@$partidas['3|2']->time2()->id}}','{{@$partidas['3|2']->resultado1}}','{{@$partidas['3|2']->resultado2}}','{{@$partidas['3|2']->penalti1}}','{{@$partidas['3|2']->penalti2}}','Copa',{{@$partidas['3|2']->ordem}},'Volta','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif @endif</td>
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

@include('template_resultado')
@endsection
