@extends('template')
@section('content')

<div class="templatemo-content-widget white-bg">
  <h2 class="margin-bottom-10">Tabelas</h2>
  <div class="row">
    <div class="col-md-4 col-sm-12 form-group">
      <form role="form" class="form-search" method="get">
        @if(isset($turno)) <input type="hidden" name="turno" value="{{$turno}}"> @endif
        @if(isset($campeonato)) <input type="hidden" name="campeonato" value="{{$campeonato}}"> @endif
        <div class="input-group">
          <span class="input-group-addon">Temporada: </span>
          <input type="number" class="form-control" name="temporada" value="{{@$temporada->numero}}">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
          </span>
        </div>
      </form>
    </div>
    <div class="col-md-4 col-sm-12 form-group">
      <form role="form" class="form-search" method="get">
        @if(isset($temporada)) <input type="hidden" name="temporada" value="{{$temporada->numero}}"> @endif
        @if(isset($campeonato)) <input type="hidden" name="campeonato" value="{{$campeonato}}"> @endif
        <div class="input-group">
          <span class="input-group-addon">Turno: </span>
          <select class="form-control" name="turno">
            <option value="0" @if ($turno=="0" ) selected @endif>Temporada Toda</option>
            <option value="1" @if ($turno=="1" ) selected @endif>Somente o 1º turno</option>
            <option value="2" @if ($turno=="2" ) selected @endif>Somente o 2º turno</option>
          </select>
          <span class="input-group-btn">
            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
          </span>
        </div>
      </form>
    </div>
    <div class="col-md-4 col-sm-12 form-group">
      <form role="form" class="form-search" method="get">
        @if(isset($turno)) <input type="hidden" name="turno" value="{{$turno}}"> @endif
        @if(isset($temporada)) <input type="hidden" name="temporada" value="{{$temporada->numero}}"> @endif
        <div class="input-group">
          <span class="input-group-addon">Campeonato: </span>
          <select class="form-control" name="campeonato">
            <option value="0" @if ($is_liga) selected @endif>Liga</option>
            <option value="1" @if ($is_copa) selected @endif>Copa</option>
            <option value="2" @if ($is_taca) selected @endif>Taça</option>
          </select>
          <span class="input-group-btn">
            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
          </span>
        </div>
      </form>
    </div>
  </div>
</div>

@if(isset($temporada))

@if($is_liga)
<!-- Final da Liga -->
@if($final)
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <div class="panel-heading templatemo-position-relative">
        <h2 class="text-uppercase">Final da Liga - Temporada {{$temporada->numero}}</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td @if($final->resultado1 > $final->resultado2 || $final->penalti1 > $final->penalti2) bgcolor="F0FFF0"
                @endif @if($final->resultado1 < $final->resultado2 || $final->penalti1 < $final->penalti2)
                    bgcolor="FFF0F0" @endif align="center">@if($final->time11()) {!!
                    Html::image('images/times/'.@$final->time11()->escudo, @$final->time11()->nome, ['class' =>
                    'time_img']) !!} @endif</td>
              <td @if($final->resultado1 > $final->resultado2 || $final->penalti1 > $final->penalti2) bgcolor="F0FFF0"
                @endif @if($final->resultado1 < $final->resultado2 || $final->penalti1 < $final->penalti2)
                    bgcolor="FFF0F0" @endif align="right">{{@$final->time11()->nome}}</td>
              <td @if($final->resultado1 > $final->resultado2 || $final->penalti1 > $final->penalti2) bgcolor="F0FFF0"
                @endif @if($final->resultado1 < $final->resultado2 || $final->penalti1 < $final->penalti2)
                    bgcolor="FFF0F0" @endif align="center">{{$final->resultado1}} @if(isset($final->penalti1))
                    ({{$final->penalti1}}) @endif</td>
              <td align="center">@if(is_null($final->resultado1) && Auth::user()->isAdmin()) <a href="javascript:;"
                  onClick="resultado('{{$final->id}}','{{@$final->time11()->escudo}}','{{@$final->time11()->nome}}','{{@$final->time21()->escudo}}','{{@$final->time21()->nome}}','{{@$final->time11()->id}}','{{@$final->time21()->id}}','{{$final->resultado1}}','{{$final->resultado2}}',null,null,'Amistoso',null,null,'store',null,null)"
                  data-toggle="modal" data-target="#modal_store">{!! Html::image('images/icons/plus.png', 'Cadastrar
                  Resultado') !!}</a> @else <a href="javascript:;"
                  onClick="resultado('{{$final->id}}','{{@$final->time11()->escudo}}','{{@$final->time11()->nome}}','{{@$final->time21()->escudo}}','{{@$final->time21()->nome}}','{{@$final->time11()->id}}','{{@$final->time21()->id}}','{{$final->resultado1}}','{{$final->resultado2}}',null,null,'Amistoso',null,null,'show',null,null)"
                  data-toggle="modal" data-target="#modal_show">{!! Html::image('images/icons/plus.png', 'Visualizar
                  Resultado') !!}</a> @endif</td>
              <td @if($final->resultado1 < $final->resultado2 || $final->penalti1 < $final->penalti2) bgcolor="F0FFF0"
                    @endif @if($final->resultado1 > $final->resultado2 || $final->penalti1 > $final->penalti2)
                    bgcolor="FFF0F0" @endif align="center">{{$final->resultado2}} @if(isset($final->penalti2))
                    ({{$final->penalti2}}) @endif</td>
              <td @if($final->resultado1 < $final->resultado2 || $final->penalti1 < $final->penalti2) bgcolor="F0FFF0"
                    @endif @if($final->resultado1 > $final->resultado2 || $final->penalti1 > $final->penalti2)
                    bgcolor="FFF0F0" @endif align="left">{{@$final->time21()->nome}}</td>
              <td @if($final->resultado1 < $final->resultado2 || $final->penalti1 < $final->penalti2) bgcolor="F0FFF0"
                    @endif @if($final->resultado1 > $final->resultado2 || $final->penalti1 > $final->penalti2)
                    bgcolor="FFF0F0" @endif align="center">@if($final->time21()) {!!
                    Html::image('images/times/'.@$final->time21()->escudo, @$final->time21()->nome, ['class' =>
                    'time_img']) !!} @endif</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Classificação da Liga -->
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <div class="panel-heading templatemo-position-relative">
        <h2 class="text-uppercase">Classificação da Liga - Temporada {{$temporada->numero}} @if(isset($turno) && @$turno
          != '0') - {{$turno}}º Turno @endif</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="bold">
              <td colspan="3" width="25%">Classificação</td>
              <td align="center" title="Pontos">P</td>
              <td align="center" title="Jogos">J</td>
              <td align="center" title="Vitórias">V</td>
              <td align="center" title="Empates">E</td>
              <td align="center" title="Derrotas">D</td>
              <td align="center" title="Gols Pró">GP</td>
              <td align="center" title="Gols Contra">GC</td>
              <td align="center" title="Saldo de Gols">SG</td>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; ?>
            @foreach($classificacao as $key => $value)
            <tr @if($key==count($classificacao)-1) bgcolor="#FFF0F0" @endif @if($key==0) bgcolor="#F0FFF0" @endif>
              <td align="center">{{$key+1}}</td>
              <td align="center"><a href="{{ route('partidas.partidas',['time_id' => $value['id']]) }}">{!!
                  Html::image('images/times/'.$value['escudo'], $value['nome'], ['style' => 'max-height:50px;']) !!}</a>
              </td>
              <td><a href="{{ route('partidas.partidas',['time_id' => $value['id']]) }}">{{$value['nome']}}</a></td>
              <td align="center">{{$value['P']}}</td>
              <td align="center">{{$value['J']}}</td>
              <td align="center">{{$value['V']}}</td>
              <td align="center">{{$value['E']}}</td>
              <td align="center">{{$value['D']}}</td>
              <td align="center">{{$value['GP']}}</td>
              <td align="center">{{$value['GC']}}</td>
              <td align="center">{{$value['SG']}}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <div class="panel-heading templatemo-position-relative">
        <h2 class="text-uppercase">Artilharia da Liga - Temporada {{$temporada->numero}}</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="bold">
              <td align="center">Gols</td>
              <td align="center">Jogador</td>
              <td align="center">Time</td>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; ?>
            @foreach($artilheiros['Liga'] as $key => $value)
            <tr>
              <td align="center">{{$value->qtd}}</td>
              <td align="center">{{$value->jogador}}</td>
              <td align="center">{!! Html::image('images/times/'.$value->escudo, $value->nome, ['style' =>
                'max-height:50px;']) !!}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <div class="panel-heading templatemo-position-relative">
        <h2 class="text-uppercase">MVP da Liga - Temporada {{$temporada->numero}}</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="bold">
              <td align="center">Quantidade</td>
              <td align="center">Jogador</td>
              <td align="center">Time</td>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; ?>
            @foreach($mvps as $key => $value)
            <tr>
              <td align="center">{{$value['qtd']}}</td>
              <td align="center">{{$value['jogador']}}</td>
              <td align="center">{!! Html::image('images/times/'.$value['escudo'], $value['nome'], ['style' =>
                'max-height:50px;']) !!}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

@if($is_copa || $is_taca)
@if($is_copa) @php $campeonato = 'Copa' @endphp @else @php $campeonato = 'Taca' @endphp @endif
<!-- Copa -->
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <div class="panel-heading templatemo-position-relative">
        <h2 class="text-uppercase">@if($is_taca) Taça @else {{ucfirst($campeonato)}} @endif - Temporada {{$temporada->numero}}</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered templatemo-user-table">
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
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time1_id && isset($copa[$campeonato.'|0|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time2_id && isset($copa[$campeonato.'|0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|0|1']) && isset($copa[$campeonato.'|0|1']->time1_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|0|1']->time1()->escudo,
                @$copa[$campeonato.'|0|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time1_id && isset($copa[$campeonato.'|0|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time2_id && isset($copa[$campeonato.'|0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|0|1']) && isset($copa[$campeonato.'|0|1']->time1_id)) {{@$copa[$campeonato.'|0|1']->time1()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time1_id && isset($copa[$campeonato.'|0|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time2_id && isset($copa[$campeonato.'|0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|0|1']->resultado1}}</td>
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time1_id && isset($copa[$campeonato.'|0|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|1']->time2_id && isset($copa[$campeonato.'|0|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|0|2']->resultado2}} @if(isset($copa[$campeonato.'|0|2']->penalti2))
                ({{@$copa[$campeonato.'|0|2']->penalti2}}) @endif</td>
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
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time1_id && isset($copa[$campeonato.'|0|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time2_id && isset($copa[$campeonato.'|0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|0|1']) && isset($copa[$campeonato.'|0|1']->time2_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|0|1']->time2()->escudo,
                @$copa[$campeonato.'|0|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time1_id && isset($copa[$campeonato.'|0|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time2_id && isset($copa[$campeonato.'|0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|0|1']) && isset($copa[$campeonato.'|0|1']->time2_id)) {{@$copa[$campeonato.'|0|1']->time2()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time1_id && isset($copa[$campeonato.'|0|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time2_id && isset($copa[$campeonato.'|0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|0|1']->resultado2}}</td>
              <td @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time1_id && isset($copa[$campeonato.'|0|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|1']->time1_id == @$copa[$campeonato.'|0|2']->time2_id && isset($copa[$campeonato.'|0|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|0|2']->resultado1}} @if(isset($copa[$campeonato.'|0|2']->penalti1))
                ({{@$copa[$campeonato.'|0|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="70">@if(isset($copa[$campeonato.'|4|1']) && isset($copa[$campeonato.'|4|1']->time1_id)) {!!
                Html::image('images/times/'.@$copa[$campeonato.'|4|1']->time1()->escudo, @$copa[$campeonato.'|4|1']->time1()->nome, ['class' =>
                'time_img']) !!} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left"
                width="200">@if(isset($copa[$campeonato.'|4|1'])) {{@$copa[$campeonato.'|4|1']->time1()->nome}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|4|1'])) {{@$copa[$campeonato.'|4|1']->resultado1}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|4|2'])) {{@$copa[$campeonato.'|4|2']->resultado2}} @if(isset($copa[$campeonato.'|4|2']->penalti1))
                ({{@$copa[$campeonato.'|4|2']->penalti1}}) @endif @endif</td>
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
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time1_id && isset($copa[$campeonato.'|1|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time2_id && isset($copa[$campeonato.'|1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|1|1']) && isset($copa[$campeonato.'|1|1']->time1_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|1|1']->time1()->escudo,
                @$copa[$campeonato.'|1|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time1_id && isset($copa[$campeonato.'|1|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time2_id && isset($copa[$campeonato.'|1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|1|1']) && isset($copa[$campeonato.'|1|1']->time1_id)) {{@$copa[$campeonato.'|1|1']->time1()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time1_id && isset($copa[$campeonato.'|1|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time2_id && isset($copa[$campeonato.'|1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|1|1']->resultado1}}</td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time1_id && isset($copa[$campeonato.'|1|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|1']->time2_id && isset($copa[$campeonato.'|1|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|1|2']->resultado2}} @if(isset($copa[$campeonato.'|1|2']->penalti2))
                ({{@$copa[$campeonato.'|1|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="70">@if(isset($copa[$campeonato.'|4|1']) && isset($copa[$campeonato.'|4|1']->time2_id)) {!!
                Html::image('images/times/'.@$copa[$campeonato.'|4|1']->time2()->escudo, @$copa[$campeonato.'|4|1']->time2()->nome, ['class' =>
                'time_img']) !!} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left"
                width="200">@if(isset($copa[$campeonato.'|4|1'])) {{@$copa[$campeonato.'|4|1']->time2()->nome}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|4|1'])) {{@$copa[$campeonato.'|4|1']->resultado2}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time1_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time1_id == @$copa[$campeonato.'|4|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|4|2'])) {{@$copa[$campeonato.'|4|2']->resultado1}} @if(isset($copa[$campeonato.'|4|2']->penalti2))
                ({{@$copa[$campeonato.'|4|2']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time1_id && isset($copa[$campeonato.'|1|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time2_id && isset($copa[$campeonato.'|1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|1|1']) && isset($copa[$campeonato.'|1|1']->time2_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|1|1']->time2()->escudo,
                @$copa[$campeonato.'|1|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time1_id && isset($copa[$campeonato.'|1|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time2_id && isset($copa[$campeonato.'|1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|1|1']) && isset($copa[$campeonato.'|1|1']->time2_id)) {{@$copa[$campeonato.'|1|1']->time2()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time1_id && isset($copa[$campeonato.'|1|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time2_id && isset($copa[$campeonato.'|1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|1|1']->resultado2}}</td>
              <td @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time1_id && isset($copa[$campeonato.'|1|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|4|2']->time1_id == @$copa[$campeonato.'|1|2']->time2_id && isset($copa[$campeonato.'|1|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|1|2']->resultado1}} @if(isset($copa[$campeonato.'|1|2']->penalti1))
                ({{@$copa[$campeonato.'|1|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td @if(is_null(@$copa[$campeonato.'|6|1']->penalti1) && is_null(@$copa[$campeonato.'|6|1']->penalti2))
                @if(is_null(@$copa[$campeonato.'|6|1']->resultado1) && is_null(@$copa[$campeonato.'|6|1']->resultado2)) bgcolor="F9F9F9" @else
                @if(@$copa[$campeonato.'|6|1']->resultado1 > @$copa[$campeonato.'|6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0"
                @endif @endif @else @if(@$copa[$campeonato.'|6|1']->penalti1 > @$copa[$campeonato.'|6|1']->penalti2) bgcolor="F0FFF0" @else
                bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($copa[$campeonato.'|6|1']) &&
                isset($copa[$campeonato.'|6|1']->time1_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|6|1']->time1()->escudo,
                @$copa[$campeonato.'|6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(is_null(@$copa[$campeonato.'|6|1']->penalti1) && is_null(@$copa[$campeonato.'|6|1']->penalti2))
                @if(is_null(@$copa[$campeonato.'|6|1']->resultado1) && is_null(@$copa[$campeonato.'|6|1']->resultado2)) bgcolor="F9F9F9" @else
                @if(@$copa[$campeonato.'|6|1']->resultado1 > @$copa[$campeonato.'|6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0"
                @endif @endif @else @if(@$copa[$campeonato.'|6|1']->penalti1 > @$copa[$campeonato.'|6|1']->penalti2) bgcolor="F0FFF0" @else
                bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($copa[$campeonato.'|6|1']))
                {{@$copa[$campeonato.'|6|1']->time1()->nome}} @endif</td>
              <td @if(is_null(@$copa[$campeonato.'|6|1']->penalti1) && is_null(@$copa[$campeonato.'|6|1']->penalti2))
                @if(is_null(@$copa[$campeonato.'|6|1']->resultado1) && is_null(@$copa[$campeonato.'|6|1']->resultado2)) bgcolor="F9F9F9" @else
                @if(@$copa[$campeonato.'|6|1']->resultado1 > @$copa[$campeonato.'|6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0"
                @endif @endif @else @if(@$copa[$campeonato.'|6|1']->penalti1 > @$copa[$campeonato.'|6|1']->penalti2) bgcolor="F0FFF0" @else
                bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($copa[$campeonato.'|6|1']))
                {{@$copa[$campeonato.'|6|1']->resultado1}} @if(isset($copa[$campeonato.'|6|1']->penalti1)) ({{@$copa[$campeonato.'|6|1']->penalti1}}) @endif
                @endif</td>
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
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time1_id && isset($copa[$campeonato.'|2|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time2_id && isset($copa[$campeonato.'|2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|2|1']) && isset($copa[$campeonato.'|2|1']->time1_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|2|1']->time1()->escudo,
                @$copa[$campeonato.'|2|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time1_id && isset($copa[$campeonato.'|2|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time2_id && isset($copa[$campeonato.'|2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|2|1']) && isset($copa[$campeonato.'|2|1']->time1_id)) {{@$copa[$campeonato.'|2|1']->time1()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time1_id && isset($copa[$campeonato.'|2|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time2_id && isset($copa[$campeonato.'|2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|2|1']->resultado1}}</td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time1_id && isset($copa[$campeonato.'|2|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|1']->time2_id && isset($copa[$campeonato.'|2|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|2|2']->resultado2}} @if(isset($copa[$campeonato.'|2|2']->penalti2))
                ({{@$copa[$campeonato.'|2|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td @if(is_null(@$copa[$campeonato.'|6|1']->penalti1) && is_null(@$copa[$campeonato.'|6|1']->penalti2))
                @if(is_null(@$copa[$campeonato.'|6|1']->resultado1) && is_null(@$copa[$campeonato.'|6|1']->resultado2)) bgcolor="F9F9F9" @else
                @if(@$copa[$campeonato.'|6|1']->resultado2 > @$copa[$campeonato.'|6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0"
                @endif @endif @else @if(@$copa[$campeonato.'|6|1']->penalti2 > @$copa[$campeonato.'|6|1']->penalti1) bgcolor="F0FFF0" @else
                bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($copa[$campeonato.'|6|1']) &&
                isset($copa[$campeonato.'|6|1']->time2_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|6|1']->time2()->escudo,
                @$copa[$campeonato.'|6|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(is_null(@$copa[$campeonato.'|6|1']->penalti1) && is_null(@$copa[$campeonato.'|6|1']->penalti2))
                @if(is_null(@$copa[$campeonato.'|6|1']->resultado1) && is_null(@$copa[$campeonato.'|6|1']->resultado2)) bgcolor="F9F9F9" @else
                @if(@$copa[$campeonato.'|6|1']->resultado2 > @$copa[$campeonato.'|6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0"
                @endif @endif @else @if(@$copa[$campeonato.'|6|1']->penalti2 > @$copa[$campeonato.'|6|1']->penalti1) bgcolor="F0FFF0" @else
                bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($copa[$campeonato.'|6|1']))
                {{@$copa[$campeonato.'|6|1']->time2()->nome}} @endif</td>
              <td @if(is_null(@$copa[$campeonato.'|6|1']->penalti1) && is_null(@$copa[$campeonato.'|6|1']->penalti2))
                @if(is_null(@$copa[$campeonato.'|6|1']->resultado1) && is_null(@$copa[$campeonato.'|6|1']->resultado2)) bgcolor="F9F9F9" @else
                @if(@$copa[$campeonato.'|6|1']->resultado2 > @$copa[$campeonato.'|6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0"
                @endif @endif @else @if(@$copa[$campeonato.'|6|1']->penalti2 > @$copa[$campeonato.'|6|1']->penalti1) bgcolor="F0FFF0" @else
                bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($copa[$campeonato.'|6|1']))
                {{@$copa[$campeonato.'|6|1']->resultado2}} @if(isset($copa[$campeonato.'|6|1']->penalti2)) ({{@$copa[$campeonato.'|6|1']->penalti2}}) @endif
                @endif</td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time1_id && isset($copa[$campeonato.'|2|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time2_id && isset($copa[$campeonato.'|2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|2|1']) && isset($copa[$campeonato.'|2|1']->time2_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|2|1']->time2()->escudo,
                @$copa[$campeonato.'|2|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time1_id && isset($copa[$campeonato.'|2|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time2_id && isset($copa[$campeonato.'|2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|2|1']) && isset($copa[$campeonato.'|2|1']->time2_id)) {{@$copa[$campeonato.'|2|1']->time2()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time1_id && isset($copa[$campeonato.'|2|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time2_id && isset($copa[$campeonato.'|2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|2|1']->resultado2}}</td>
              <td @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time1_id && isset($copa[$campeonato.'|2|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|1']->time1_id == @$copa[$campeonato.'|2|2']->time2_id && isset($copa[$campeonato.'|2|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|2|2']->resultado1}} @if(isset($copa[$campeonato.'|2|2']->penalti1))
                ({{@$copa[$campeonato.'|2|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="70">@if(isset($copa[$campeonato.'|5|1']) && isset($copa[$campeonato.'|5|1']->time1_id)) {!!
                Html::image('images/times/'.@$copa[$campeonato.'|5|1']->time1()->escudo, @$copa[$campeonato.'|5|1']->time1()->nome, ['class' =>
                'time_img']) !!} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left"
                width="200">@if(isset($copa[$campeonato.'|5|1'])) {{@$copa[$campeonato.'|5|1']->time1()->nome}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|5|1'])) {{@$copa[$campeonato.'|5|1']->resultado1}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|1']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|5|2'])) {{@$copa[$campeonato.'|5|2']->resultado2}} @if(isset($copa[$campeonato.'|5|2']->penalti1))
                ({{@$copa[$campeonato.'|5|2']->penalti1}}) @endif @endif</td>
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
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time1_id && isset($copa[$campeonato.'|3|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time2_id && isset($copa[$campeonato.'|3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|3|1']) && isset($copa[$campeonato.'|3|1']->time1_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|3|1']->time1()->escudo,
                @$copa[$campeonato.'|3|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time1_id && isset($copa[$campeonato.'|3|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time2_id && isset($copa[$campeonato.'|3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|3|1']) && isset($copa[$campeonato.'|3|1']->time1_id)) {{@$copa[$campeonato.'|3|1']->time1()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time1_id && isset($copa[$campeonato.'|3|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time2_id && isset($copa[$campeonato.'|3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|3|1']->resultado1}}</td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time1_id && isset($copa[$campeonato.'|3|1']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|1']->time2_id && isset($copa[$campeonato.'|3|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|3|2']->resultado2}} @if(isset($copa[$campeonato.'|3|2']->penalti2))
                ({{@$copa[$campeonato.'|3|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="70">@if(isset($copa[$campeonato.'|5|1']) && isset($copa[$campeonato.'|5|1']->time2_id)) {!!
                Html::image('images/times/'.@$copa[$campeonato.'|5|1']->time2()->escudo, @$copa[$campeonato.'|5|1']->time2()->nome, ['class' =>
                'time_img']) !!} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left"
                width="200">@if(isset($copa[$campeonato.'|5|1'])) {{@$copa[$campeonato.'|5|1']->time2()->nome}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|5|1'])) {{@$copa[$campeonato.'|5|1']->resultado2}} @endif</td>
              <td @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time1_id) && !is_null(@$copa[$campeonato.'|6|1']->time2_id))
                bgcolor="#F0FFF0" @else @if((@$copa[$campeonato.'|6|1']->time2_id == @$copa[$campeonato.'|5|2']->time2_id) &&
                !is_null(@$copa[$campeonato.'|6|1']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center"
                width="60">@if(isset($copa[$campeonato.'|5|2'])) {{@$copa[$campeonato.'|5|2']->resultado1}} @if(isset($copa[$campeonato.'|5|2']->penalti2))
                ({{@$copa[$campeonato.'|5|2']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time1_id && isset($copa[$campeonato.'|3|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time2_id && isset($copa[$campeonato.'|3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="70">@if(isset($copa[$campeonato.'|3|1']) && isset($copa[$campeonato.'|3|1']->time2_id)) {!! Html::image('images/times/'.@$copa[$campeonato.'|3|1']->time2()->escudo,
                @$copa[$campeonato.'|3|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time1_id && isset($copa[$campeonato.'|3|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time2_id && isset($copa[$campeonato.'|3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="left" width="200">@if(isset($copa[$campeonato.'|3|1']) && isset($copa[$campeonato.'|3|1']->time2_id)) {{@$copa[$campeonato.'|3|1']->time2()->nome}} @endif</td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time1_id && isset($copa[$campeonato.'|3|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time2_id && isset($copa[$campeonato.'|3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|3|1']->resultado2}}</td>
              <td @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time1_id && isset($copa[$campeonato.'|3|2']->time1_id)) bgcolor="#F0FFF0" @else
                @if(@$copa[$campeonato.'|5|2']->time1_id == @$copa[$campeonato.'|3|2']->time2_id && isset($copa[$campeonato.'|3|2']->time2_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif
                @endif align="center" width="60">{{@$copa[$campeonato.'|3|2']->resultado1}} @if(isset($copa[$campeonato.'|3|2']->penalti1))
                ({{@$copa[$campeonato.'|3|2']->penalti1}}) @endif</td>
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
  </div>
  <div class="col-2">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <div class="panel-heading templatemo-position-relative">
        <h2 class="text-uppercase">Artilharia da Copa - Temporada {{$temporada->numero}}</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="bold">
              <td align="center">Gols</td>
              <td align="center">Jogador</td>
              <td align="center">Time</td>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; ?>
            @foreach($artilheiros['Copa'] as $key => $value)
            <tr>
              <td align="center">{{$value->qtd}}</td>
              <td align="center">{{$value->jogador}}</td>
              <td align="center">{!! Html::image('images/times/'.$value->escudo, $value->nome, ['style' =>
                'max-height:50px;']) !!}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

@endif

@include('template_resultado')
@endsection