@extends('template')

@section('content')

<div class="templatemo-flex-row flex-content-row">
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="templatemo-content-widget white-bg col-1" widt>
      <h2 class="templatemo-inline-block">Calcular Valor do Jogador</h2><hr>
      <form  onSubmit="return calcula();">
        <div class="row form-group">
          <div class="col-md-12">
            {!! Html::decode(Form::label('overall', 'Overall <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('overall', null, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-12">
            {!! Html::decode(Form::label('potencial', 'Potencial <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('potencial', null, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-12">
            {!! Html::decode(Form::label('idade', 'Idade <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('idade', null, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-12">
            {!! Html::decode(Form::label('posicao', 'Posição Primária <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('posicao', $posicoes, null, ['class' => 'form-control', 'required' => true]) !!}
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="templatemo-blue-button""><i class="fa fa-plus"></i> Calcular</button>
        </div>
        <div class="row form-group">
          <div class="col-md-12">
            {!! Html::decode(Form::label('resultado', 'Resultado', ['class' => 'control-label'])) !!}
            {!! Form::text('resultado', null, ['class' => 'form-control', 'disabled' => true]) !!}
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  // Armazena variáveis
  $overall = []; // 15000
  $overall["50"] = 20000;$overall["51"] = 25000;$overall["52"] = 34000;$overall["53"] = 40000;$overall["54"] = 46000;$overall["55"] = 54000;$overall["56"] = 61000;$overall["57"] = 70000;$overall["58"] = 86000;$overall["59"] = 105000;$overall["60"] = 140000;$overall["61"] = 170000;$overall["62"] = 205000;$overall["63"] = 250000;$overall["64"] = 305000;$overall["65"] = 365000;$overall["66"] = 435000;$overall["67"] = 515000;$overall["68"] = 605000;$overall["69"] = 710000;$overall["70"] = 1200000;$overall["71"] = 1600000;$overall["72"] = 2100000;$overall["73"] = 2700000;$overall["74"] = 3800000;$overall["75"] = 4500000;$overall["76"] = 5200000;$overall["77"] = 6000000;$overall["78"] = 7000000;$overall["79"] = 8500000;$overall["80"] = 10000000;$overall["81"] = 12000000;$overall["82"] = 15000000;$overall["83"] = 17500000;$overall["84"] = 21000000;$overall["85"] = 26000000;$overall["86"] = 30000000;$overall["87"] = 34000000;$overall["88"] = 40000000;$overall["89"] = 45000000;$overall["90"] = 52000000;$overall["91"] = 60000000;$overall["92"] = 68000000;$overall["93"] = 75000000;$overall["94"] = 83000000;$overall["95"] = 90000000;$overall["96"] = 11000000;$overall["97"] = 120000000;$overall["98"] = 140000000;$overall["99"] = 150000000;$overall["100"] = 200000000;

  $idade = []; // -75
  $idade["17"] = 18;$idade["18"] = 30;$idade["19"] = 42;$idade["20"] = 50;$idade["21"] = 50;$idade["22"] = 48;$idade["23"] = 48;$idade["24"] = 48;$idade["25"] = 46;$idade["26"] = 44;$idade["27"] = 40;$idade["28"] = 35;$idade["29"] = 30;$idade["30"] = 25;$idade["31"] = 15;$idade["32"] = 0;$idade["33"] = -25;$idade["34"] = -40;$idade["35"] = -50;$idade["36"] = -65;$idade["37"] = -65;$idade["38"] = -65;$idade["39"] = -75;

  $potencial = []; // 190
  $potencial["0"] = 0;$potencial["1"] = 15;$potencial["2"] = 20;$potencial["3"] = 25;$potencial["4"] = 30;$potencial["5"] = 35;$potencial["6"] = 40;$potencial["7"] = 45;$potencial["8"] = 55;$potencial["9"] = 65;$potencial["10"] = 75;$potencial["11"] = 90;$potencial["12"] = 100;$potencial["13"] = 120;$potencial["14"] = 160;$potencial["15"] = 160;$potencial["16"] = 160;$potencial["17"] = 160;$potencial["18"] = 160;$potencial["19"] = 160;$potencial["20"] = 160;$potencial["21"] = 190;$potencial["22"] = 190;$potencial["23"] = 190;$potencial["24"] = 190;$potencial["25"] = 190;$potencial["26"] = 190;$potencial["27"] = 190;$potencial["28"] = 190;$potencial["29"] = 190;$potencial["30"] = 190;$potencial["31"] = 235;$potencial["32"] = 235;$potencial["33"] = 235;$potencial["34"] = 235;$potencial["35"] = 235;$potencial["36"] = 235;$potencial["37"] = 235;$potencial["38"] = 235;$potencial["39"] = 235;$potencial["40"] = 235;$potencial["41"] = 235;$potencial["42"] = 235;$potencial["43"] = 235;$potencial["44"] = 235;$potencial["45"] = 235;$potencial["46"] = 235;$potencial["47"] = 235;$potencial["48"] = 235;$potencial["49"] = 235;$potencial["60"] = 235;

  $posicao = [];
  $posicao["PE"] = 15;$posicao["ATA"] = 18;$posicao["PD"] = 15;$posicao["MAE"] = 18;$posicao["SA"] = 18;$posicao["MAD"] = 18;$posicao["MEI"] = 15;$posicao["ME"] = 15;$posicao["MC"] = 12;$posicao["MD"] = 15;$posicao["VOL"] = -15;$posicao["ADE"] = -18;$posicao["LE"] = -18;$posicao["ZAG"] = -15;$posicao["LD"] = -18;$posicao["ADD"] = -18;$posicao["GOL"] = -40;

  $goleiro = [];
  $goleiro["26"] = "24";$goleiro["27"] = "25";$goleiro["28"] = "26";$goleiro["29"] = "27";$goleiro["30"] = "28";$goleiro["31"] = "29";$goleiro["32"] = "30";$goleiro["33"] = "31";$goleiro["34"] = "32";$goleiro["35"] = "33";$goleiro["36"] = "34";$goleiro["37"] = "35";$goleiro["38"] = "35";$goleiro["39"] = "35";$goleiro["40"] = "35";$goleiro["41"] = "35";$goleiro["42"] = "35";$goleiro["43"] = "35";$goleiro["44"] = "35";$goleiro["45"] = "35";$goleiro["46"] = "35";$goleiro["47"] = "35";$goleiro["48"] = "35";$goleiro["49"] = "35";$goleiro["50"] = "35";

  // Calcula o valor do jogador
  function calcula() {
    overall = $overall[$("#overall").val()];
    if(overall == null)
      overall = 15000;
    if($("#posicao").val() == "GOL"){
      idade = parseInt($("#idade").val());
      if(idade >= 28)
        idade = $idade[$goleiro[idade.toString()]];
      else
        idade = $idade[idade.toString()];
    } else {
      idade = $idade[$("#idade").val()];
    }
    if(idade == null)
      idade = -75;
    potencial = $potencial[parseInt($("#potencial").val())-parseInt($("#overall").val())];
    posicao = $posicao[$("#posicao").val()];
    resultado = overall * (((idade + potencial + posicao) / 100) + 1);
    // alert("OVERALL: "+overall+" IDADE: "+idade+" POTENCIAL: "+potencial+" POSICAO: "+posicao+" RESULTADO: "+resultado);
    if(resultado >= 0 && resultado < 300000){
      multiplo = 10000;
    } else if(resultado >= 300000 && resultado < 1000000) {
      multiplo = 25000;
    } else if(resultado >= 1000000 && resultado < 5000000) {
      multiplo = 100000;
    } else if(resultado >= 5000000) {
      multiplo = 500000;
    }
    resultado = Math.round((resultado-1)/multiplo)*multiplo;
    $("#resultado").val(number_format(resultado,2,',','.'));
    return false;
  }

  // Coloca formato de dinheiro
  function number_format( numero, decimal, decimal_separador, milhar_separador ){ 
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
    prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
    sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
    dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }
</script>
@endsection
