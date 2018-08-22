@extends('template')
@section('content')
<div class="templatemo-flex-row flex-content-row">
  <div class="templatemo-content-widget white-bg col-1 text-center">
    <i class="fa fa-times"></i>
    {!! Html::image('images/times/'.Auth::user()->time()->escudo, Auth::user()->time()->nome, ['style' => 'max-width:300px;']) !!}
  </div>
  <div class="templatemo-content-widget white-bg col-2">
    <h2 class="templatemo-inline-block">Status Atual</h2><hr>
    <p><strong>Player: </strong>{{Auth::user()->nome}}</p>
    <p><strong>Time: </strong>{{Auth::user()->time()->nome}}</p>
    <p><strong>Dinheiro: </strong>‎€ {{number_format(Auth::user()->time()->dinheiro,2,',','.')}}</p>
    <p><strong>Últimas Contratações: </strong></p>
    @if($contratacoes->count())
    <ul>
      @foreach($contratacoes as $contratacao)
      <li>{{$contratacao->nome}}, por € {{number_format($contratacao->valor,2,',','.')}}.</li>
      @endforeach
    </ul>
    @endif
  </div>
  <div class="templatemo-content-widget white-bg col-2">
    <h2 class="templatemo-inline-block">Contusões e Cartões</h2><hr>
    <p><strong>Lesionados: </strong></p>
    @if($lesoes->count())
    <ul>
      @foreach($lesoes as $lesao)
      <li>{{$lesao->jogador()->nome}}, {{$lesao->restantes}} rodadas restantes.</li>
      @endforeach
    </ul>
    @endif
    <br><p><strong>Cartões: </strong></p>
    @if($cartoes->count())
    <ul>
      @foreach($cartoes as $cartao)
      @if($cartao->qtd == 1) <?php $palavra = 'cartão' ?> @else <?php $palavra = 'cartões' ?> @endif
      <li>{{$cartao->jogador()->nome}}, {{$cartao->qtd}} {{$palavra}} @if($cartao->cor == 0) amarelo @else vermelho @endif na {{$cartao->campeonato}} FEDIA.</li>
      @endforeach
    </ul>
    @endif
  </div>
</div>
@if(isset($temporada))
<!-- Liga -->
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <i class="fa fa-times"></i>
      <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">Classificação da Liga - Temporada {{$temporada}}</h2></div>
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
            <tr @if($key == count($classificacao)-1) bgcolor="#FFF0F0" @endif @if($key == 0) bgcolor="#F0FFF0" @endif>
              <td align="center">{{$key+1}}</td>
              <td align="center"><a href="{{ route('partidas.partidas',['time_id' => $value['id']]) }}">{!! Html::image('images/times/'.$value['escudo'], $value['nome'], ['style' => 'max-height:50px;']) !!}</a></td>
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
  <div class="col-2">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <i class="fa fa-times"></i>
      <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">Artilharia da Liga - Temporada {{$temporada}}</h2></div>
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
              <td align="center">{!! Html::image('images/times/'.$value->escudo, $value->nome, ['style' => 'max-height:50px;']) !!}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
          </tbody>
        </table>    
      </div>                          
    </div>
  </div>
</div>
<!-- Copa -->
<div class="templatemo-flex-row flex-content-row">
  <div class="col-1">
    <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
      <i class="fa fa-times"></i>
      <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">Copa - Temporada {{$temporada}}</h2></div>
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
              <td @if(@$copa['4|1']->time1_id == @$copa['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['0|1']->time1()->escudo, @$copa['0|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['4|1']->time1_id == @$copa['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['0|1']->time1()->nome}}</td>
              <td @if(@$copa['4|1']->time1_id == @$copa['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['0|1']->resultado1}}</td>
              <td @if(@$copa['4|1']->time1_id == @$copa['0|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['0|2']->resultado2}} @if(isset($copa['0|2']->penalti2)) ({{$copa['0|2']->penalti2}}) @endif</td>
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
              <td @if(@$copa['4|1']->time1_id == @$copa['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['0|1']->time2()->escudo, @$copa['0|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['4|1']->time1_id == @$copa['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['0|1']->time2()->nome}}</td>
              <td @if(@$copa['4|1']->time1_id == @$copa['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['0|1']->resultado2}}</td>
              <td @if(@$copa['4|1']->time1_id == @$copa['0|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|1']->time1_id == @$copa['0|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['0|2']->resultado1}} @if(isset($copa['0|2']->penalti1)) ({{$copa['0|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|1']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|1']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($copa['4|1']) && isset($copa['4|1']->time1_id)) {!! Html::image('images/times/'.@$copa['4|1']->time1()->escudo, @$copa['4|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|1']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|1']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($copa['4|1'])) {{@$copa['4|1']->time1()->nome}} @endif</td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|1']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|1']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['4|1'])) {{$copa['4|1']->resultado1}} @endif</td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|1']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|1']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['4|2'])) {{$copa['4|2']->resultado1}} @if(isset($copa['4|2']->penalti1)) ({{$copa['4|2']->penalti1}}) @endif @endif</td>
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
              <td @if(@$copa['4|2']->time1_id == @$copa['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['1|1']->time1()->escudo, @$copa['1|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['1|1']->time1()->nome}}</td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['1|1']->resultado1}}</td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['1|2']->resultado2}} @if(isset($copa['1|2']->penalti2)) ({{$copa['1|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|2']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|2']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($copa['4|1']) && isset($copa['4|1']->time2_id)) {!! Html::image('images/times/'.@$copa['4|1']->time2()->escudo, @$copa['4|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|2']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|2']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($copa['4|1'])) {{@$copa['4|1']->time2()->nome}} @endif</td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|2']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|2']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['4|1'])) {{$copa['4|1']->resultado2}} @endif</td>
              <td @if((@$copa['6|1']->time1_id == @$copa['4|2']->time1_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|1']->time1_id == @$copa['4|2']->time2_id) && !is_null(@$copa['6|1']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['4|2'])) {{$copa['4|2']->resultado2}} @if(isset($copa['4|2']->penalti2)) ({{$copa['4|2']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['1|1']->time2()->escudo, @$copa['1|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['1|1']->time2()->nome}}</td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['1|1']->resultado2}}</td>
              <td @if(@$copa['4|2']->time1_id == @$copa['1|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['4|2']->time1_id == @$copa['1|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['1|2']->resultado1}} @if(isset($copa['1|2']->penalti1)) ({{$copa['1|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td @if(is_null(@$copa['6|1']->penalti1) && is_null(@$copa['6|1']->penalti2)) @if(is_null(@$copa['6|1']->resultado1) && is_null(@$copa['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$copa['6|1']->resultado1 > @$copa['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$copa['6|1']->penalti1 > @$copa['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($copa['6|1']) && isset($copa['6|1']->time1_id)) {!! Html::image('images/times/'.@$copa['6|1']->time1()->escudo, @$copa['6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(is_null(@$copa['6|1']->penalti1) && is_null(@$copa['6|1']->penalti2)) @if(is_null(@$copa['6|1']->resultado1) && is_null(@$copa['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$copa['6|1']->resultado1 > @$copa['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$copa['6|1']->penalti1 > @$copa['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($copa['6|1'])) {{@$copa['6|1']->time1()->nome}} @endif</td>
              <td @if(is_null(@$copa['6|1']->penalti1) && is_null(@$copa['6|1']->penalti2)) @if(is_null(@$copa['6|1']->resultado1) && is_null(@$copa['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$copa['6|1']->resultado1 > @$copa['6|1']->resultado2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$copa['6|1']->penalti1 > @$copa['6|1']->penalti2) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($copa['6|1'])) {{$copa['6|1']->resultado1}} @if(isset($copa['6|1']->penalti1)) ({{$copa['6|1']->penalti1}}) @endif @endif</td>
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
              <td @if(@$copa['5|1']->time1_id == @$copa['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['2|1']->time1()->escudo, @$copa['2|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['2|1']->time1()->nome}}</td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['2|1']->resultado1}}</td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['2|2']->resultado2}} @if(isset($copa['2|2']->penalti2)) ({{$copa['2|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td @if(is_null(@$copa['6|1']->penalti1) && is_null(@$copa['6|1']->penalti2)) @if(is_null(@$copa['6|1']->resultado1) && is_null(@$copa['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$copa['6|1']->resultado2 > @$copa['6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$copa['6|1']->penalti2 > @$copa['6|1']->penalti1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="70">@if(isset($copa['6|1']) && isset($copa['6|1']->time2_id)) {!! Html::image('images/times/'.@$copa['6|1']->time2()->escudo, @$copa['6|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if(is_null(@$copa['6|1']->penalti1) && is_null(@$copa['6|1']->penalti2)) @if(is_null(@$copa['6|1']->resultado1) && is_null(@$copa['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$copa['6|1']->resultado2 > @$copa['6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$copa['6|1']->penalti2 > @$copa['6|1']->penalti1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="left" width="200">@if(isset($copa['6|1'])) {{@$copa['6|1']->time2()->nome}} @endif</td>
              <td @if(is_null(@$copa['6|1']->penalti1) && is_null(@$copa['6|1']->penalti2)) @if(is_null(@$copa['6|1']->resultado1) && is_null(@$copa['6|1']->resultado2)) bgcolor="F9F9F9" @else @if(@$copa['6|1']->resultado2 > @$copa['6|1']->resultado1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif @else @if(@$copa['6|1']->penalti2 > @$copa['6|1']->penalti1) bgcolor="F0FFF0" @else bgcolor="FFF0F0" @endif @endif align="center" width="60">@if(isset($copa['6|1'])) {{$copa['6|1']->resultado2}} @if(isset($copa['6|1']->penalti2)) ({{$copa['6|1']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['2|1']->time2()->escudo, @$copa['2|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['2|1']->time2()->nome}}</td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['2|1']->resultado2}}</td>
              <td @if(@$copa['5|1']->time1_id == @$copa['2|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|1']->time1_id == @$copa['2|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['2|2']->resultado1}} @if(isset($copa['2|2']->penalti1)) ({{$copa['2|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|1']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|1']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($copa['5|1']) && isset($copa['5|1']->time1_id)) {!! Html::image('images/times/'.@$copa['5|1']->time1()->escudo, @$copa['5|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|1']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|1']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($copa['5|1'])) {{@$copa['5|1']->time1()->nome}} @endif</td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|1']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|1']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['5|1'])) {{$copa['5|1']->resultado1}} @endif</td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|1']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|1']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['5|2'])) {{$copa['5|2']->resultado1}} @if(isset($copa['5|2']->penalti1)) ({{$copa['5|2']->penalti1}}) @endif @endif</td>
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
              <td @if(@$copa['5|2']->time1_id == @$copa['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['3|1']->time1()->escudo, @$copa['3|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['3|1']->time1()->nome}}</td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['3|1']->resultado1}}</td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|1']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|1']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['3|2']->resultado2}} @if(isset($copa['3|2']->penalti2)) ({{$copa['3|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|2']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|2']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">@if(isset($copa['5|1']) && isset($copa['5|1']->time2_id)) {!! Html::image('images/times/'.@$copa['5|1']->time2()->escudo, @$copa['5|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|2']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|2']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">@if(isset($copa['5|1'])) {{@$copa['5|1']->time2()->nome}} @endif</td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|2']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|2']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['5|1'])) {{$copa['5|1']->resultado2}} @endif</td>
              <td @if((@$copa['6|2']->time1_id == @$copa['5|2']->time1_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="#F0FFF0" @else @if((@$copa['6|2']->time1_id == @$copa['5|2']->time2_id) && !is_null(@$copa['6|2']->time1_id)) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">@if(isset($copa['5|2'])) {{$copa['5|2']->resultado2}} @if(isset($copa['5|2']->penalti2)) ({{$copa['5|2']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="70">{!! Html::image('images/times/'.@$copa['3|1']->time2()->escudo, @$copa['3|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="left" width="200">{{@$copa['3|1']->time2()->nome}}</td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['3|1']->resultado2}}</td>
              <td @if(@$copa['5|2']->time1_id == @$copa['3|2']->time1_id) bgcolor="#F0FFF0" @else @if(@$copa['5|2']->time1_id == @$copa['3|2']->time2_id) bgcolor="FFF0F0" @else bgcolor="F9F9F9" @endif @endif align="center" width="60">{{$copa['3|2']->resultado1}} @if(isset($copa['3|2']->penalti1)) ({{$copa['3|2']->penalti1}}) @endif</td>
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
      <i class="fa fa-times"></i>
      <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">Artilharia da Copa - Temporada {{$temporada}}</h2></div>
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
              <td align="center">{!! Html::image('images/times/'.$value->escudo, $value->nome, ['style' => 'max-height:50px;']) !!}</td>
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

<div class="templatemo-flex-row flex-content-row">
  <div class="templatemo-content-widget white-bg col-1">
    <h2 class="templatemo-inline-block">Últimas Notícias</h2><hr>
    @if($noticias->count())
    @foreach($noticias as $key => $noticia)
    <a href="/noticias/{{$noticia->id}}">
      <div class="noticia">
        <div class="row">
          @if(!is_null($noticia->imagem))
          <div class="col-md-2 col-sm-12 col-xs-12 margin-bottom-10">
            {!! Html::image("images/noticias/$noticia->id/$noticia->imagem", $noticia->imagem) !!}
          </div>
          @endif
          <div class="col-md-8 col-sm-12 col-xs-12">
            <h2>{{$noticia->titulo}}</h2>
          </div>
          <div class="col-md-8 col-sm-12 col-xs-12">
            <h5>{{$noticia->subtitulo}}</h5>
          </div>
          <div class="col-md-8 col-sm-12 col-xs-12 footer">
            <p>{{date_format(date_create_from_format('Y-m-d H:s:i', $noticia->created_at), 'd/m/Y H:s:i')}} - {{$noticia->nome}}</p>
          </div>
        </div>
      </div>
    </a>
    <?php if ($key != $noticias->count()-1) {echo "<hr>";} ?>
    @endforeach
    @endif
  </div>
</div>

@if(isset($temporada))
<div class="templatemo-flex-row flex-content-row templatemo-overflow-hidden"> <!-- overflow hidden for iPad mini landscape view-->
  <div class="col-1 templatemo-overflow-hidden">
    <div class="templatemo-content-widget white-bg templatemo-overflow-hidden">
      <i class="fa fa-times"></i>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1 col-lg-4 col-md-12">
          <h2 class="text-center"><strong>Gols na Temporada {{$temporada}}</strong></h2>
          <div id="pie_chart_div_gol" class="templatemo-chart"></div> <!-- Pie chart div -->
        </div>
        <div class="col-1 col-lg-4 col-md-12">
          <h2 class="text-center"><strong>Aproveitamento na Temporada {{$temporada}}</strong></h2>
          <div id="pie_chart_div_lesao" class="templatemo-chart"></div> <!-- Pie chart div -->
        </div>
      </div>                
    </div>
  </div>
</div>
@endif
<script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
<script type="text/javascript">
  /* Google Chart 
  -------------------------------------------------------------------*/
  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart); 

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {

    // Create the data table.
    var gols = new google.visualization.DataTable();
    gols.addColumn('string', 'Topping');
    gols.addColumn('number', 'Slices');
    gols.addRows([
      <?php 
      foreach ($gols as $value)
        echo "['".$value->jogador()->nome."', $value->qtd],"
      ?>
      ]);

    var aproveitamento = new google.visualization.DataTable();
    aproveitamento.addColumn('string', 'Topping');
    aproveitamento.addColumn('number', 'Slices');
    aproveitamento.addRows([
      <?php 
      foreach ($aproveitamento as $key => $value)
        echo "['".$key."', $value],"
      ?>
      ]);

    // Instantiate and draw our chart, passing in some options.
    var pieChartGol = new google.visualization.PieChart(document.getElementById('pie_chart_div_gol'));
    pieChartGol.draw(gols, null);

    var pieChartLesao = new google.visualization.PieChart(document.getElementById('pie_chart_div_lesao'));
    pieChartLesao.draw(aproveitamento, null);
  }

  $(document).ready(function(){
    if($.browser.mozilla) {
      //refresh page on browser resize
      // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
      $(window).bind('resize', function(e)
      {
        if (window.RT) clearTimeout(window.RT);
        window.RT = setTimeout(function()
        {
          this.location.reload(false); /* false to get page from cache */
        }, 200);
      });      
    } else {
      $(window).resize(function(){
        drawChart();
      });  
    }   
  });

</script>
<style type="text/css">
  .col-2 { max-width: 600px; }
</style>
@endsection