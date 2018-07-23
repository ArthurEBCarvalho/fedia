@extends('template')

@section('content')
<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Partidas do {{$time->nome}}</h2>
    <div class="row">
        <form role="form" method="get">
            <input type="hidden" name="time_id" value="{{$time->id}}">
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
        <form role="form" method="get">
            <input type="hidden" name="temporada" value="{{$temporada}}">
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
                    <th colspan="7">Partidas do {{$time->nome}} na Liga FEDIA - Temporada {{$temporada}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas['Liga'] as $partida)
                <tr>
                    <td align="center">{{$partida->rodada}}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time1()->escudo, $partida->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="right">{{$partida->time1()->nome}}</td>
                    <td @if($partida->resultado1 > $partida->resultado2) bgcolor="F0FFF0" @endif @if($partida->resultado1 < $partida->resultado2) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado1}}</td>
                    <td align="center">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</td>
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
                    <th colspan="7">Partidas do {{$time->nome}} na Copa FEDIA - Temporada {{$temporada}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partidas['Copa'] as $partida)
                <tr>
                    @if(in_array($partida->ordem,[0,1,2,3]))
                    <td align="center">Quartas de Final</td>
                    @else
                    @if(in_array($partida->ordem,[4,5]))
                    <td align="center">Semi-Final</td>
                    @else
                    <td align="center">Final</td>
                    @endif
                    @endif
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time1()->escudo, $partida->time1()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="right">{{$partida->time1()->nome}}</td>
                    <td @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado1}} @if(isset($partida->penalti1)) ({{$partida->penalti1}}) @endif</td>
                    <td align="center">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{{$partida->resultado2}} @if(isset($partida->penalti2)) ({{$partida->penalti2}}) @endif</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="left">{{$partida->time2()->nome}}</td>
                    <td @if(($partida->resultado1 < $partida->resultado2) || ($partida->penalti1 < $partida->penalti2)) bgcolor="F0FFF0" @endif @if(($partida->resultado1 > $partida->resultado2) || ($partida->penalti1 > $partida->penalti2)) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$partida->time2()->escudo, $partida->time2()->nome, ['class' => 'time_img']) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endif
@endsection
