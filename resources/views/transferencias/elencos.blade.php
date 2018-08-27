@extends('template')

@section('content')

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Elencos</h2>
    <div class="row">
        <form role="form" method="get">
            <div class="col-md-12 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Time: </span>
                    <select class="form-control search-filtro" name="time">
                        <option>Todos</option>
                        @foreach($options as $option)
                        <option value="{{$option->id}}" @if ($time == $option->id) selected @endif>{{$option->nome}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="templatemo-content-widget no-padding">
            @foreach($times as $t)
            <div class="panel panel-default table-responsive">
                <div class="panel-heading" role="tab" id="heading{{$t->id}}">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$t->id}}" aria-expanded="true" aria-controls="collapse{{$t->id}}">
                            <table>
                                <tr>
                                    <td width="100" align="center">{!! Html::image('images/times/'.$t->escudo, $t->nome, ['class' => 'time_img']) !!}</td>
                                    <td><h4>{{$t->nome}}</h4></td>
                                </tr>
                            </table>
                        </a>
                    </h4>
                </div>
                <div id="collapse{{$t->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$t->id}}">
                    <div class="panel-body">
                        <table class="table table-bordered templatemo-user-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Posições</th>
                                    <th>Idade</th>
                                    <th>Overall</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registros[$t->id] as $posicao => $jogadores)
                                <tr>
                                    <th colspan="6">{{$posicao}}</th>
                                </tr>
                                @foreach($jogadores as $jogador)
                                <tr>
                                    <td>{{$jogador->nome}}</td>
                                    <td>{{str_replace('|',' ',$jogador->posicoes)}}</td>
                                    <td>{{$jogador->idade}}</td>
                                    <td>{{$jogador->overall}}</td>
                                    <td>€ {{number_format($jogador->valor,2,',','.')}}</td>
                                    @if($t->id == Auth::user()->time()->id)
                                    <td width="140">{!! Form::select('status', ['Negociável','Inegociável','À Venda'], $jogador->status, ['class' => 'form-control status', 'style' => 'width:120px;', 'data-id' => $jogador->id]) !!}</td>
                                    @else
                                    <?php if($jogador->status == '0'){$color = "#888";}elseif($jogador->status == '1'){$color = 'red';}else{$color = 'green';} ?>
                                    <td width="140" style="color:{{$color}}">{{$jogador->getStatus()}}</td>
                                    @endif
                                </tr>
                                @endforeach    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style type="text/css">
    .table tbody th {
        text-align: center;
        background-color: #f0f0f0;
    }
    .templatemo-content-widget.no-padding { box-shadow: 0px 0px 0px 0px; }
    .panel { margin-bottom: 0; }
    .panel-heading h4 { font-weight: bold; }
</style>
<script type="text/javascript">
    $(".status").change(function(){
        $.ajax({
            type: "GET",
            url: "/elencos_atualiza_status",
            dataType: "html",
            data: "id=" + $(this).attr('data-id') + "&status=" + $(this).val()
        });
    });

    $('.panel.panel-default.table-responsive').each(function( index ) {
        $(this).find('.panel-heading').width($(this).find('.table').width()+3);
    });
    
    // $('.collapse').on('shown.bs.collapse', function () {
        // $(this).width($(this).find('.table').width());
    // });

    // $('.collapse').on('hidden.bs.collapse', function () {
        // $tamanho = $(this).parent().width();
        // alert($tamanho);
    //     $(this).width($(this).parent().width());
    //     $(this).parent().find('.panel-heading').width($(this).width());
    // });
</script>
@endsection
