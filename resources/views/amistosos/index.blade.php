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
    <h2 class="margin-bottom-10">{{get_tipo($tipo)}}</h2>
    <div class="row">
        <form role="form" method="get">
        <input type="hidden" name="tipo" value="{{$tipo}}">
            <div class="col-md-8 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Temporada: </span>
                    <input type="number" class="form-control" name="temporada" value="{{$temporada}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
            @if(Auth::user()->isAdmin() && $tipo != 2)
            <div class="col-md-4">
                <div class="pull-right">
                    <div class="pull-right"><a href="{{ route('amistosos.create',['tipo' => $tipo]) }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Cadastrar</a></div>
                </div>
            </div>
            @endif
        </form>
    </div>
</div>

@if($amistosos->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th colspan="7">{{get_tipo($tipo)}} - {{$temporada}}ª Temporada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($amistosos as $amistoso)
                @if(isset($amistoso->time12_id) && isset($amistoso->time22_id))
                <?php $rowspan = 2 ?>
                @else
                <?php $rowspan = 1 ?>
                @endif
                <tr>
                    <td @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="FFF0F0" @endif align="center">@if(!blank($amistoso->time11_id)){!! Html::image('images/times/'.@$amistoso->time11()->escudo, @$amistoso->time11()->nome, ['class' => 'time_img']) !!}@endif</td>
                    <td @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="FFF0F0" @endif align="right">{{@$amistoso->time11()->nome}}</td>
                    <td @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="FFF0F0" @endif align="center" rowspan="{{$rowspan}}">{{$amistoso->resultado1}} @if(isset($amistoso->penalti1)) ({{$amistoso->penalti1}}) @endif</td>
                    <td align="center" rowspan="{{$rowspan}}">@if(is_null($amistoso->resultado1) && is_null($amistoso->resultado2)) @if(Auth::user()->isAdmin())<a href="javascript:;" onClick="resultado('{{$amistoso->id}}','{{@$amistoso->time11()->escudo}}','{{@$amistoso->time11()->nome}}','{{@$amistoso->time21()->escudo}}','{{@$amistoso->time21()->nome}}','{{@$amistoso->time11()->id}}','{{@$amistoso->time21()->id}}','{{$amistoso->resultado1}}','{{$amistoso->resultado2}}',null,null,'Amistoso',null,null,'store','{{@$amistoso->time12()->nome}}','{{@$amistoso->time22()->nome}}')" data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar Resultado') !!}</a> @endif @else <a href="javascript:;" onClick="resultado('{{$amistoso->id}}','{{@$amistoso->time11()->escudo}}','{{@$amistoso->time11()->nome}}','{{@$amistoso->time21()->escudo}}','{{@$amistoso->time21()->nome}}','{{@$amistoso->time11()->id}}','{{@$amistoso->time21()->id}}','{{$amistoso->resultado1}}','{{$amistoso->resultado2}}','{{$amistoso->penalti1}}','{{$amistoso->penalti2}}','Amistoso',null,null,'show','{{@$amistoso->time12()->nome}}','{{@$amistoso->time22()->nome}}')" data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar Resultado') !!}</a> @endif
                        <br>
                        € {{number_format($amistoso->valor,2,',','.')}}
                    </td>
                    <td @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="FFF0F0" @endif align="center" rowspan="{{$rowspan}}">{{$amistoso->resultado2}} @if(isset($amistoso->penalti2)) ({{$amistoso->penalti2}}) @endif</td>
                    <td @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="FFF0F0" @endif align="left">{{@$amistoso->time21()->nome}}</td>
                    <td @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="FFF0F0" @endif align="center">@if(!blank($amistoso->time21_id)){!! Html::image('images/times/'.@$amistoso->time21()->escudo, @$amistoso->time21()->nome, ['class' => 'time_img']) !!}@endif</td>
                </tr>
                @if(isset($amistoso->time12_id) && isset($amistoso->time22_id))
                <tr>
                    <td @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$amistoso->time12()->escudo, $amistoso->time12()->nome, ['class' => 'time_img']) !!}</td>
                    <td @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="FFF0F0" @endif align="right">{{$amistoso->time12()->nome}}</td>
                    <td @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="FFF0F0" @endif align="left">{{$amistoso->time22()->nome}}</td>
                    <td @if($amistoso->resultado1 < $amistoso->resultado2 || $amistoso->penalti1 < $amistoso->penalti2) bgcolor="F0FFF0" @endif @if($amistoso->resultado1 > $amistoso->resultado2 || $amistoso->penalti1 > $amistoso->penalti2) bgcolor="FFF0F0" @endif align="center">{!! Html::image('images/times/'.$amistoso->time22()->escudo, $amistoso->time22()->nome, ['class' => 'time_img']) !!}</td>
                </tr>
                @endif
                @endforeach
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
                <h2>Nenhuma {{substr_replace("Partidas", "", -1)}} encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif

@include('template_resultado')
@endsection
