@extends('template')

@section('content')
@if ($errors->any())
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>
    <div class="media">
        <div class="media-body">
            <ul>
                @foreach($errors->all() as $error)
                <li><h2>{{ $error }}</h2></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        Nova {{substr_replace("Transferências", "", -1)}}
    </h2>

    {!! Form::open(['route' => [$url, $transferencium->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time1_id', 'Origem <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('time1_id', $times, $transferencium->time1_id, ['class' => 'chzn-select form-control']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('time2_id', 'Destino <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('time2_id', $times, $transferencium->time2_id, ['class' => 'chzn-select form-control']) !!}
        </div>
    </div>
    <div class="row form-group jogador_select">
        <div class="col-md-12">
            {!! Html::decode(Form::label('jogador_id', 'Jogador <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('jogador_id', [], @$transferencium->jogador()->id, ['class' => 'chzn-select form-control']) !!}
        </div>
    </div>
    <div class="row form-group jogador_text">
        <div class="col-md-12">
            {!! Html::decode(Form::label('jogador', 'Jogador <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::text('jogador', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row form-group jogador_text">
        <div class="col-md-12">
            {!! Html::decode(Form::label('overall', 'Overall <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('overall', null, ['class' => 'form-control', 'min' => 1, 'max' => 99]) !!}
        </div>
    </div>
    <div class="row form-group jogador_text">
        <div class="col-md-12">
            {!! Html::decode(Form::label('idade', 'Idade <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::number('idade', null, ['class' => 'form-control', 'min' => 1, 'max' => 99]) !!}
        </div>
    </div>
    <div class="row form-group jogador_text">
        <div class="col-md-12">
            {!! Html::decode(Form::label('posicoes', 'Posições <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            {!! Form::select('posicoes[]', ['GOL' => 'GOL','ADD' => 'ADD','LD' => 'LD','ZAG' => 'ZAG','LE' => 'LE','ADE' => 'ADE','VOL' => 'VOL','MD' => 'MD','MC' => 'MC','ME' => 'ME','MEI' => 'MEI','MAD' => 'MAD','SA' => 'SA','MAE' => 'MAE','PD' => 'PD','ATA' => 'ATA','PE' => 'PE'], null, ['class' => 'chzn-select form-control', 'multiple' => true, 'id' => 'posicoes']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('valor', 'Valor <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            @if($method == 'post') {!! Form::text('valor', NULL, ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!} @else {!! Form::text('valor', number_format($transferencium->valor,2,',','.'), ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!} @endif
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            <div class="templatemo-block">
                <input type="checkbox" name="atualiza_valor" id="atualiza_valor" value="true">
                <label for="atualiza_valor"><span></span>Atualiza o valor do jogador</label>
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('transferencias.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
<script type="text/javascript">
    $jogadores = [];
    <?php
    foreach($jogadores as $time_id => $list){
        echo 'if(!$jogadores[\''.$time_id.'\']){$jogadores[\''.$time_id.'\'] = [];}';
        foreach ($list as $key => $value)
            echo '$jogadores[\''.$time_id.'\'].push({\'id\': '.$value->id.', \'nome\': \''.$value->nome.'\'});';
    }

    foreach($jogadores[array_keys($times)[0]] as $jogador)
        echo "$('#jogador_id').append('<option value=\'$jogador->id\'>$jogador->nome</option>');";
    ?>

    $(".jogador_text").hide();
    $("#time1_id").change(function(){
        if($(this).find("option:selected").text() == "Mercado Externo"){
            $(".jogador_text").show();
            $(".jogador_select").hide();
        } else {
            $(".jogador_text").hide();
            $(".jogador_select").show();
        }
        $('#jogador_id').find('option').remove();
        for(var index in $jogadores[$(this).val()])
            $('#jogador_id').append("<option value='"+$jogadores[$(this).val()][index]['id']+"'>"+$jogadores[$(this).val()][index]['nome']+"</option>");
        $('#jogador_id').trigger("liszt:updated");
    });

    $('#posicoes, #overall, #time1_id').change(function(){
        $("#valor").val(null);
        if($('#overall').val() && $('#posicoes').val() && $('#time1_id').find("option:selected").text() == "Mercado Externo"){
            calcula_valor();
        }
    })

    function calcula_valor(){
        var overall = []; // 15000
        overall["50"] = 20000;overall["51"] = 25000;overall["52"] = 34000;overall["53"] = 40000;overall["54"] = 46000;overall["55"] = 54000;overall["56"] = 61000;overall["57"] = 70000;overall["58"] = 86000;overall["59"] = 105000;overall["60"] = 140000;overall["61"] = 170000;overall["62"] = 205000;overall["63"] = 250000;overall["64"] = 305000;overall["65"] = 365000;overall["66"] = 435000;overall["67"] = 515000;overall["68"] = 605000;overall["69"] = 710000;overall["70"] = 1200000;overall["71"] = 1600000;overall["72"] = 2100000;overall["73"] = 2700000;overall["74"] = 3800000;overall["75"] = 4500000;overall["76"] = 5200000;overall["77"] = 6000000;overall["78"] = 7000000;overall["79"] = 8500000;overall["80"] = 10000000;overall["81"] = 12000000;overall["82"] = 15000000;overall["83"] = 17500000;overall["84"] = 21000000;overall["85"] = 26000000;overall["86"] = 30000000;overall["87"] = 34000000;overall["88"] = 40000000;overall["89"] = 45000000;overall["90"] = 52000000;overall["91"] = 60000000;overall["92"] = 68000000;overall["93"] = 75000000;overall["94"] = 83000000;overall["95"] = 90000000;overall["96"] = 11000000;overall["97"] = 120000000;overall["98"] = 140000000;overall["99"] = 150000000;overall["100"] = 200000000;

        var posicao = [];
        posicao["PE"] = 15;posicao["ATA"] = 18;posicao["PD"] = 15;posicao["MAE"] = 18;posicao["SA"] = 18;posicao["MAD"] = 18;posicao["MEI"] = 15;posicao["ME"] = 15;posicao["MC"] = 12;posicao["MD"] = 15;posicao["VOL"] = -3;posicao["ADE"] = -8;posicao["LE"] = -8;posicao["ZAG"] = -5;posicao["LD"] = -8;posicao["ADD"] = -8;posicao["GOL"] = -35;

        var goleiro = [];
        goleiro["26"] = "24";goleiro["27"] = "25";goleiro["28"] = "26";goleiro["29"] = "27";goleiro["30"] = "28";goleiro["31"] = "29";goleiro["32"] = "30";goleiro["33"] = "31";goleiro["34"] = "32";goleiro["35"] = "33";goleiro["36"] = "34";goleiro["37"] = "35";goleiro["38"] = "35";goleiro["39"] = "35";goleiro["40"] = "35";goleiro["41"] = "35";goleiro["42"] = "35";goleiro["43"] = "35";goleiro["44"] = "35";goleiro["45"] = "35";goleiro["46"] = "35";goleiro["47"] = "35";goleiro["48"] = "35";goleiro["49"] = "35";goleiro["50"] = "35";

        overall = overall[$("#overall").val()];
        if(overall == null)
            overall = 15000;

        posicao = posicao[$('#posicoes').val()[0]];
        resultado = overall * (((posicao) / 100) + 1);
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
        $("#valor").val(number_format(resultado,2,',','.'));
        return false;
    }
</script>
@endsection