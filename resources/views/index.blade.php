@extends('template')
@section('content')
<div class="templatemo-flex-row flex-content-row">
  <div class="templatemo-content-widget white-bg col-1 text-center">
    <i class="fa fa-times"></i>
    {!! Html::image(Storage::url('times/'.Auth::user()->time()->escudo), Auth::user()->time()->nome, ['style' => 'max-width:300px;']) !!}
  </div>
  <div class="templatemo-content-widget white-bg col-2">
    <i class="fa fa-times"></i>
    <div class="square"></div>
    <h2 class="templatemo-inline-block">Visual Admin Template</h2><hr>
    <p>Works on all major browsers. IE 10+. Visual Admin is <a href="http://www.templatemo.com/tag/admin" target="_parent">free responsive admin template</a> for everyone. Feel free to use this template for your backend user interfaces. Please tell your friends about <a href="http://www.templatemo.com" target="_parent">templatemo.com</a> website. You may <a href="http://www.templatemo.com/contact" target="_parent">contact us</a> if you have anything to say.</p>
    <p>Nunc placerat purus eu tincidunt consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus dapibus nulla quis risus auctor, non placerat augue consectetur. Fusce mi lacus, semper sit amet mattis eu.</p>              
  </div>
  <!-- <div class="templatemo-content-widget white-bg col-1">
    <i class="fa fa-times"></i>
    <h2 class="text-uppercase">Dictum</h2>
    <h3 class="text-uppercase">Sedvel Erat Non</h3><hr>
    <div class="progress">
      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
    </div>
    <div class="progress">
      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
    </div>
    <div class="progress">
      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
    </div>                          
  </div> -->
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
              <td colspan="2" width="25%">Classificação</td>
              <td align="center">Pontos</td>
              <td align="center">Jogos</td>
              <td align="center">Vitórias</td>
              <td align="center">Empates</td>
              <td align="center">Derrotas</td>
              <td align="center">Gols Pró</td>
              <td align="center">Gols Contra</td>
              <td align="center">Saldo de Gols</td>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; ?>
            @foreach($classificacao as $key => $value)
            <tr @if($key == count($classificacao)-1) bgcolor="#FFF0F0" @endif @if($key == 0) bgcolor="#F0FFF0" @endif>
              <td align="center">{!! Html::image(Storage::url('times/'.$value['escudo']), $value['nome'], ['style' => 'max-width:50px;']) !!}</td>
              <td>{{$value['nome']}}</td>
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
              <td align="center">{!! Html::image(Storage::url('times/'.$value->escudo), $value->nome, ['style' => 'max-width:50px;']) !!}</td>
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
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['0|1']->time1()->escudo), @$copa['0|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['0|1']->time1()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['0|1']->resultado1}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['0|2']->resultado2}} @if(isset($copa['0|2']->penalti2)) ({{$copa['0|2']->penalti2}}) @endif</td>
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
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['0|1']->time2()->escudo), @$copa['0|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['0|1']->time2()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['0|1']->resultado2}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['0|2']->resultado1}} @if(isset($copa['0|2']->penalti1)) ({{$copa['0|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($copa['4|1']) && isset($copa['4|1']->time1_id)) {!! Html::image(Storage::url('times/'.@$copa['4|1']->time1()->escudo), @$copa['4|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($copa['4|1'])) {{@$copa['4|1']->time1()->nome}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['4|1'])) {{$copa['4|1']->resultado1}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['4|2'])) {{$copa['4|2']->resultado1}} @if(isset($copa['4|2']->penalti1)) ({{$copa['4|2']->penalti1}}) @endif @endif</td>
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
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['1|1']->time1()->escudo), @$copa['1|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['1|1']->time1()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['1|1']->resultado1}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['1|2']->resultado2}} @if(isset($copa['1|2']->penalti2)) ({{$copa['1|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($copa['4|1']) && isset($copa['4|1']->time2_id)) {!! Html::image(Storage::url('times/'.@$copa['4|1']->time2()->escudo), @$copa['4|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($copa['4|1'])) {{@$copa['4|1']->time2()->nome}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['4|1'])) {{$copa['4|1']->resultado2}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['4|2'])) {{$copa['4|2']->resultado2}} @if(isset($copa['4|2']->penalti2)) ({{$copa['4|2']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['1|1']->time2()->escudo), @$copa['1|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['1|1']->time2()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['1|1']->resultado2}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['1|2']->resultado1}} @if(isset($copa['1|2']->penalti1)) ({{$copa['1|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($copa['6|1']) && isset($copa['6|1']->time1_id)) {!! Html::image(Storage::url('times/'.@$copa['6|1']->time1()->escudo), @$copa['6|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($copa['6|1'])) {{@$copa['6|1']->time1()->nome}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['6|1'])) {{$copa['6|1']->resultado1}} @if(isset($copa['6|1']->penalti1)) ({{$copa['6|1']->penalti1}}) @endif @endif</td>
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
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['2|1']->time1()->escudo), @$copa['2|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['2|1']->time1()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['2|1']->resultado1}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['2|2']->resultado2}} @if(isset($copa['2|2']->penalti2)) ({{$copa['2|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($copa['6|1']) && isset($copa['6|1']->time2_id)) {!! Html::image(Storage::url('times/'.@$copa['6|1']->time2()->escudo), @$copa['6|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($copa['6|1'])) {{@$copa['6|1']->time2()->nome}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['6|1'])) {{$copa['6|1']->resultado2}} @if(isset($copa['6|1']->penalti2)) ({{$copa['6|1']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['2|1']->time2()->escudo), @$copa['2|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['2|1']->time2()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['2|1']->resultado2}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['2|2']->resultado1}} @if(isset($copa['2|2']->penalti1)) ({{$copa['2|2']->penalti1}}) @endif</td>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($copa['5|1']) && isset($copa['5|1']->time1_id)) {!! Html::image(Storage::url('times/'.@$copa['5|1']->time1()->escudo), @$copa['5|1']->time1()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($copa['5|1'])) {{@$copa['5|1']->time1()->nome}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['5|1'])) {{$copa['5|1']->resultado1}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['5|2'])) {{$copa['5|2']->resultado1}} @if(isset($copa['5|2']->penalti1)) ({{$copa['5|2']->penalti1}}) @endif @endif</td>
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
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['3|1']->time1()->escudo), @$copa['3|1']->time1()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['3|1']->time1()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['3|1']->resultado1}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['3|2']->resultado2}} @if(isset($copa['3|2']->penalti2)) ({{$copa['3|2']->penalti2}}) @endif</td>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">@if(isset($copa['5|1']) && isset($copa['5|1']->time2_id)) {!! Html::image(Storage::url('times/'.@$copa['5|1']->time2()->escudo), @$copa['5|1']->time2()->nome, ['class' => 'time_img']) !!} @endif</td>
              <td bgcolor="#f9f9f9" align="left" width="200">@if(isset($copa['5|1'])) {{@$copa['5|1']->time2()->nome}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['5|1'])) {{$copa['5|1']->resultado2}} @endif</td>
              <td bgcolor="#f9f9f9" align="center" width="60">@if(isset($copa['5|2'])) {{$copa['5|2']->resultado2}} @if(isset($copa['5|2']->penalti2)) ({{$copa['5|2']->penalti2}}) @endif @endif</td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
              <td style="border:0;"></td>
            </tr>
            <tr>
              <td style="border:0;"></td>
              <td bgcolor="#f9f9f9" align="center" width="70">{!! Html::image(Storage::url('times/'.@$copa['3|1']->time2()->escudo), @$copa['3|1']->time2()->nome, ['class' => 'time_img']) !!}</td>
              <td bgcolor="#f9f9f9" align="left" width="200">{{@$copa['3|1']->time2()->nome}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['3|1']->resultado2}}</td>
              <td bgcolor="#f9f9f9" align="center" width="60">{{$copa['3|2']->resultado1}} @if(isset($copa['3|2']->penalti1)) ({{$copa['3|2']->penalti1}}) @endif</td>
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
  <div class="col-3">
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
              <td align="center">{!! Html::image(Storage::url('times/'.$value->escudo), $value->nome, ['style' => 'max-width:50px;']) !!}</td>
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

<div class="templatemo-flex-row flex-content-row templatemo-overflow-hidden"> <!-- overflow hidden for iPad mini landscape view-->
  <div class="col-1 templatemo-overflow-hidden">
    <div class="templatemo-content-widget white-bg templatemo-overflow-hidden">
      <i class="fa fa-times"></i>
      <div class="templatemo-flex-row flex-content-row">
        <div class="col-1 col-lg-6 col-md-12">
          <h2 class="text-center">Modular<span class="badge">new</span></h2>
          <div id="pie_chart_div" class="templatemo-chart"></div> <!-- Pie chart div -->
        </div>
        <div class="col-1 col-lg-6 col-md-12">
          <h2 class="text-center">Interactive<span class="badge">new</span></h2>
          <div id="bar_chart_div" class="templatemo-chart"></div> <!-- Bar chart div -->
        </div>  
      </div>                
    </div>
  </div>
</div>
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
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Topping');
          data.addColumn('number', 'Slices');
          data.addRows([
            ['Mushrooms', 3],
            ['Onions', 1],
            ['Olives', 1],
            ['Zucchini', 1],
            ['Pepperoni', 2]
            ]);

          // Set chart options
          var options = {'title':'How Much Pizza I Ate Last Night'};

          // Instantiate and draw our chart, passing in some options.
          var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
          pieChart.draw(data, options);

          var barChart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
          barChart.draw(data, options);
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
  </script>
  @endsection