@extends('template')

@section('content')

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
    @foreach($indisponiveis as $campeonato => $array)
    <p><strong>{{$campeonato}}:</strong></p>
    @foreach($array as $t => $j)
    <p><strong>{{$t}}:</strong></p>
    <ul>
        @foreach($j as $nome)
        <li>{{$nome}}</li>
        @endforeach
    </ul>
    @endforeach
    @endforeach
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Partidas do {{$time->nome}}</h2>
    <div class="row">
        <form role="form" method="get">
            <input type="hidden" name="time_id" value="{{$time->id}}">
            <div class="col-md-6 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Temporada: </span>
                    <input type="number" class="form-control" name="temporada" value="{{@$temporada->numero}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
        </form>
        <form role="form" method="get">
            <input type="hidden" name="temporada" value="{{@$temporada->numero}}">
            <div class="col-md-6 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Time: </span>
                    {!! Form::select('time_id', $times, $time->id, ['class' => 'form-control']) !!}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

@if(!count($partidas['Liga']) && !count($partidas['Copa']))
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma {{substr_replace("Partidas", "", -1)}} encontrada!</h2>
            </div>
        </div>
    </div>
</div>
@else
@if(count($partidas['Liga']))
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>Rodada</th>
                    <th colspan="7">Partidas do {{$time->nome}} na Liga FEDIA - Temporada {{@$temporada->numero}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas['Liga'] as $partida)
                <tr>
                    <td align="center">{{$partida->rodada}}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time1()->escudo, $partida->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="right">{{$partida->time1()->nome}}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado1}}</td>
                    <td align="center">@if(isset($partida->resultado1) && isset($partida->resultado2)) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}',null,null,'Liga',null,'{{$partida->rodada}}','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @else @if(Auth::user()->isAdmin()) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}',null,null,'Liga',null,'{{$partida->rodada}}','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif @endif</td>
                    <td @if($partida->resultado1 < $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 > $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado2}}</td>
                    <td @if($partida->resultado1 < $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 > $partida->resultado2) bgcolor="FFF0F0" @endif align="left">{{$partida->time2()->nome}}</td>
                    <td @if($partida->resultado1 < $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 > $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time2()->escudo, $partida->time2()->nome, ['class' => 'time_img']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@if(count($partidas['Copa']))
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>Fase</th>
                    <th colspan="7">Partidas do {{$time->nome}} na Copa FEDIA - Temporada {{@$temporada->numero}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas['Copa'] as $partida)
                <tr>
                    <?php if($partida->rodada == 1){$texto = 'Ida';}else{$texto = 'Volta';} ?>
                    @if(in_array($partida->ordem,[0,1,2,3]))
                    <td align="center">Quartas de Final</td>
                    @else
                    @if(in_array($partida->ordem,[4,5]))
                    <td align="center">Semi-Final</td>
                    @else
                    <td align="center">Final</td>
                    @endif
                    @endif
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="center"> @if(isset($partida->time1_id)) {!! Html::image('images/times/'.@$partida->time1()->escudo, @$partida->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="right">{{@$partida->time1()->nome}}</td>
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado1}} @if(isset($partida->penalti1)) ({{$partida->penalti1}}) @endif</td>
                    <td align="center">@if(isset($partida->resultado1) && isset($partida->resultado2)) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}','{{$partida->penalti1}}','{{$partida->penalti2}}','Copa',{{$partida->ordem}},'{{$texto}}','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @else @if(Auth::user()->isAdmin() && isset($partida->time1_id) && isset($partida->time2_id)) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}','{{$partida->penalti1}}','{{$partida->penalti2}}','Copa',{{$partida->ordem}},'{{$texto}}','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif @endif</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado2}} @if(isset($partida->penalti2)) ({{$partida->penalti2}}) @endif</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="left">{{@$partida->time2()->nome}}</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="center"> @if(isset($partida->time2_id)) {!! Html::image('images/times/'.@$partida->time2()->escudo, @$partida->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@if(count($partidas['Taca']))
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>Fase</th>
                    <th colspan="7">Partidas do {{$time->nome}} na Taça FEDIA - Temporada {{@$temporada->numero}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas['Taca'] as $partida)
                <tr>
                    <?php if($partida->rodada == 1){$texto = 'Ida';}else{$texto = 'Volta';} ?>
                    @if(in_array($partida->ordem,[0,1,2,3]))
                    <td align="center">Quartas de Final</td>
                    @else
                    @if(in_array($partida->ordem,[4,5]))
                    <td align="center">Semi-Final</td>
                    @else
                    <td align="center">Final</td>
                    @endif
                    @endif
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="center"> @if(isset($partida->time1_id)) {!! Html::image('images/times/'.@$partida->time1()->escudo, @$partida->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="right">{{@$partida->time1()->nome}}</td>
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado1}} @if(isset($partida->penalti1)) ({{$partida->penalti1}}) @endif</td>
                    <td align="center">@if(isset($partida->resultado1) && isset($partida->resultado2)) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}','{{$partida->penalti1}}','{{$partida->penalti2}}','Copa',{{$partida->ordem}},'{{$texto}}','show',null,null)" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @else @if(Auth::user()->isAdmin() && isset($partida->time1_id) && isset($partida->time2_id)) <a href="javascript:;" onClick="resultado('{{$partida->id}}','{{$partida->time1()->escudo}}','{{$partida->time1()->nome}}','{{$partida->time2()->escudo}}','{{$partida->time2()->nome}}','{{$partida->time1()->id}}','{{$partida->time2()->id}}','{{$partida->resultado1}}','{{$partida->resultado2}}','{{$partida->penalti1}}','{{$partida->penalti2}}','Copa',{{$partida->ordem}},'{{$texto}}','store',null,null)" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif @endif</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado2}} @if(isset($partida->penalti2)) ({{$partida->penalti2}}) @endif</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="left">{{@$partida->time2()->nome}}</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="center"> @if(isset($partida->time2_id)) {!! Html::image('images/times/'.@$partida->time2()->escudo, @$partida->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endif

@include('template_resultado')
@endsection