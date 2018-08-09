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
            {!! Form::select('posicoes[]', ['GOL' => 'GOL','ADD' => 'ADD','LD' => 'LD','ZAG' => 'ZAG','LE' => 'LE','ADE' => 'ADE','VOL' => 'VOL','MD' => 'MD','MC' => 'MC','ME' => 'ME','MEI' => 'MEI','MAD' => 'MAD','SA' => 'SA','MAE' => 'MAE','PD' => 'PD','ATA' => 'ATA','PE' => 'PE'], null, ['class' => 'chzn-select form-control', 'multiple' => true]) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('valor', 'Valor <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
            @if($method == 'post') {!! Form::text('valor', NULL, ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!} @else {!! Form::text('valor', number_format($transferencium->valor,2,',','.'), ['class' => 'form-control','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']) !!} @endif
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
        $('.jogador_id').find('option').remove();
        for(var index in $jogadores[$(this).val()])
            $('.jogador_id').append("<option value='"+$jogadores[$(this).val()][index]['id']+"'>"+$jogadores[$(this).val()][index]['nome']+"</option>");
        $('.jogador_id').trigger("liszt:updated");
    });
</script>
@endsection