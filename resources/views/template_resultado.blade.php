<!-- Modal Store -->
<div class="modal fade" id="modal_store" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'partidas.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <input type="hidden" id="partida_id" name="partida_id">
            <input type="hidden" id="campeonato" name="campeonato">
            <input type="hidden" id="temporada" name="temporada" value="{{@$temporada}}">
            <input type="hidden" id="rodada" name="rodada">
            @if(Request::is('partidas_time*'))
            <input type="hidden" id="view" name="view" value="partidas.partidas">
            @else
            <input type="hidden" id="view" name="view" value="partidas.index">
            @endif
            @if(Request::is('amistosos*'))
            <input type="hidden" id="tipo" name="tipo" value="{{$tipo}}">
            @endif
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered templatemo-user-table">
                    <thead>
                        <tr>
                            <th colspan="8" class="body-title"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('resultado1', 0, ['class' => 'form-control resultado','required' => 'true', 'min' => 0]) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('resultado2', 0, ['class' => 'form-control resultado','required' => 'true', 'min' => 0]) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <thead class="penaltis">
                        <tr>
                            <th colspan="8">Penaltis</th>
                        </tr>
                    </thead>
                    <tbody class="penaltis">
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('penalti1', null, ['class' => 'form-control', 'min' => 0]) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('penalti2', null, ['class' => 'form-control', 'min' => 0]) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Gols</th>
                            <th></th>
                            <th colspan="3">Gols</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{!! Form::select('gols_jogador1[]', [], null, ['class' => 'chzn-select time1 form-control store']) !!}</td>
                            <td>{!! Form::number('gols_qtd1[]', 1, ['class' => 'form-control gols','placeholder' => 'Qtd']) !!}</td>
                            <td></td>
                            <td>{!! Form::number('gols_qtd2[]', 1, ['class' => 'form-control gols','placeholder' => 'Qtd']) !!}</td>
                            <td colspan="2">{!! Form::select('gols_jogador2[]', [], null, ['class' => 'chzn-select time2 form-control store']) !!}</td>
                            <td>{!! Html::image('images/icons/plus.png', 'add_linha', ['class' => 'add_linha', 'onClick' => 'add_linha(this)']) !!}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Cartões</th>
                            <th></th>
                            <th colspan="3">Cartões</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{!! Form::select('cartoes_jogador1[]', [], null, ['class' => 'chzn-select time1 form-control store']) !!}</td>
                            <td>{!! Form::select('cartoes_cor1[]', ['Amarelo','Vermelho'], null, ['class' => 'form-control', 'style' => 'padding:0;']) !!}</td>
                            <td></td>
                            <td>{!! Form::select('cartoes_cor2[]', ['Amarelo','Vermelho'], null, ['class' => 'form-control', 'style' => 'padding:0;']) !!}</td>
                            <td colspan="2">{!! Form::select('cartoes_jogador2[]', [], null, ['class' => 'chzn-select time2 form-control store']) !!}</td>
                            <td>{!! Html::image('images/icons/plus.png', 'add_linha', ['class' => 'add_linha', 'onClick' => 'add_linha(this)']) !!}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Lesões</th>
                            <th></th>
                            <th colspan="3">Lesões</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">{!! Form::select('lesoes_jogador1[]', [], null, ['class' => 'chzn-select time1 lesao form-control store']) !!}</td>
                            <td>{!! Form::select('lesoes_tipo1[]', ['Band-Aid','Ambulância'], null, ['class' => 'form-control', 'style' => 'padding:0;']) !!}</td>
                            <td></td>
                            <td>{!! Form::select('lesoes_tipo2[]', ['Band-Aid','Ambulância'], null, ['class' => 'form-control', 'style' => 'padding:0;']) !!}</td>
                            <td colspan="2">{!! Form::select('lesoes_jogador2[]', [], null, ['class' => 'chzn-select time2 lesao form-control store']) !!}</td>
                            <td>{!! Html::image('images/icons/plus.png', 'add_linha', ['class' => 'add_linha', 'onClick' => 'add_linha(this)']) !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Fechar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Cadastrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Modal Show -->
<div class="modal fade" id="modal_show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered templatemo-user-table">
                    <thead>
                        <tr>
                            <th colspan="8" class="body-title"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('resultado1', 0, ['class' => 'form-control resultado','disabled' => 'true', 'id' => 'resultado1', 'min' => 0]) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('resultado2', 0, ['class' => 'form-control resultado','disabled' => 'true', 'id' => 'resultado2', 'min' => 0]) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                        </tr>
                    </tbody>
                    <thead class="penaltis">
                        <tr>
                            <th colspan="8">Penaltis</th>
                        </tr>
                    </thead>
                    <tbody class="penaltis">
                        <tr>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_1']) !!}</td>
                            <td class="time_1" width="25%" align="right"></td>
                            <td width="17%" align="center">{!! Form::number('penalti1', null, ['class' => 'form-control', 'id' => 'penalti1', 'disabled' => 'true']) !!}</td>
                            <td width="6%" align="center">X</td>
                            <td width="17%" align="center">{!! Form::number('penalti2', null, ['class' => 'form-control', 'id' => 'penalti2', 'disabled' => 'true']) !!}</td>
                            <td class="time_2" width="25%" align="left"></td>
                            <td width="5%" align="center">{!! Html::image("#", '', ['class' => 'time_img img_2']) !!}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Gols</th>
                            <th></th>
                            <th colspan="3">Gols</th>
                        </tr>
                    </thead>
                    <tbody id="gols">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Cartões</th>
                            <th></th>
                            <th colspan="3">Cartões</th>
                        </tr>
                    </thead>
                    <tbody id="cartoes">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Lesões</th>
                            <th></th>
                            <th colspan="3">Lesões</th>
                        </tr>
                    </thead>
                    <tbody id="lesoes">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .add_linha {
        cursor: pointer;
    }

    .chzn-container, .chzn-drop, .chzn-search input { width: 100% !important; }

    #modal_store, #modal_show { overflow-y:scroll;overflow-x:scroll; }
    @media screen and (max-width: 992px) {
        #modal_store .modal-content, #modal_show .modal-content { width: 685px; }
        #modal_store table, #modal_show table { width: 640px; }
    }
    #modal_store input, #modal_show input { min-width: 60px; }
</style>
<script type="text/javascript">
    $img_path = "images/times/image.png";
    $(".penaltis").hide();

    $jogadores = [];
    $nomes = [];
    $gols = [];
    $cartoes = [];
    $lesoes = [];
    $cor = ['Amarelo','Vermelho'];

    <?php 
    foreach($jogadores as $time_id => $list){
        echo 'if(!$jogadores[\''.$time_id.'\']){$jogadores[\''.$time_id.'\'] = [];}';
        foreach ($list as $key => $value){
            echo '$jogadores[\''.$time_id.'\'].push({\'id\': '.$value->id.', \'nome\': \''.$value->nome.'\'});';
            echo '$nomes['.$value->id.'] = \''.$value->nome.'\';';
        }
    }

    foreach($gols as $value){
        echo 'if(!$gols[\''.$value->partida_id.'_'.$value->time_id.'\']){$gols[\''.$value->partida_id.'_'.$value->time_id.'\'] = [];}';
        echo '$gols[\''.$value->partida_id.'_'.$value->time_id.'\'].push({\'jogador\': '.$value->jogador_id.', \'time\': '.$value->time_id.', \'quantidade\': '.$value->quantidade.'});';
    }
    foreach($cartoes as $value){
        echo 'if(!$cartoes[\''.$value->partida_id.'_'.$value->time_id.'\']){$cartoes[\''.$value->partida_id.'_'.$value->time_id.'\'] = [];}';
        echo '$cartoes[\''.$value->partida_id.'_'.$value->time_id.'\'].push({\'jogador\': '.$value->jogador_id.', \'time\': '.$value->time_id.', \'cor\': '.$value->cor.'});';
    }
    foreach($lesoes as $value){
        echo 'if(!$lesoes[\''.$value->partida_id.'_'.$value->time_id.'\']){$lesoes[\''.$value->partida_id.'_'.$value->time_id.'\'] = [];}';
        echo '$lesoes[\''.$value->partida_id.'_'.$value->time_id.'\'].push({\'jogador\': '.$value->jogador_id.', \'time\': '.$value->time_id.', \'rodadas\': '.$value->rodadas.'});';
    }
    ?>

    function resultado(id,img1,time1,img2,time2,id1,id2,resultado1,resultado2,penalti1,penalti2,campeonato,ordem,rodada,tipo,time12,time22){
        if(campeonato == "Amistoso"){
            $("#modal_store form").attr('action','{{Request::root()}}/amistosos/'+id);
            $("#modal_store form").append('<input name="_method" type="hidden" value="PUT">');
            $("#modal_store").find('.modal-title').html('Cadastrar Resultado de {{get_tipo($tipo)}}');
            $("#modal_show").find('.modal-title').html('Visualizar Resultado de {{get_tipo($tipo)}}');
            @if(@$tipo != 1)
            $(".penaltis").show();
            @endif
            $("#modal_store .body-title").html('Amistoso');
            $("#modal_show .body-title").html('Amistoso');
        } else {
            $("#modal_store form").attr('action','{{Request::root()}}/partidas');
            if(campeonato == "Copa" && (rodada == "Volta" || ordem == 6))
                $(".penaltis").show();
            else
                $(".penaltis").hide();
        }
        $("#partida_id").val(id);
        $("#campeonato").val(campeonato);
        $(".resultado").val(0);
        $(".gols").val(0);
        $array = $img_path.split('/');
        $array[$array.length-1] = img1;
        $(".img_1").attr('src',"{{Request::root()}}/"+$array.join('/'));
        $(".time_1").html(time1);
        $array = $img_path.split('/');
        $array[$array.length-1] = img2;
        $(".img_2").attr('src',"{{Request::root()}}/"+$array.join('/'));
        $(".time_2").html(time2);
        if(!['',null].includes(time12) && !['',null].includes(time22)){
            $(".time_1").html($(".time_1").html()+" e "+time12);
            $(".time_2").html($(".time_2").html()+" e "+time22);
        }
        if(tipo == 'show'){
            if(campeonato == 'Copa'){
                $("#modal_show").find('.modal-title').html('Visualizar Resultado da Copa FEDIA');
                if([0,1,2,3].includes(ordem))
                    $message = 'Quartas de Final'+' - '+rodada;
                else if([4,5].includes(ordem))
                    $message = 'Semi-Final'+' - '+rodada;
                else
                    $message = 'Final';
                $("#modal_show").find('.body-title').html($message);
            } else if(campeonato == 'Liga') {
                $("#modal_show").find('.modal-title').html('Visualizar Resultado da Liga FEDIA');
                $("#modal_show").find('.body-title').html('Rodada '+rodada);
            }
            $("#modal_show").find('tbody#gols').html('');
            $("#modal_show").find('tbody#cartoes').html('');
            $("#modal_show").find('tbody#lesoes').html('');
            $("#modal_show").find('input#resultado1').val(resultado1);
            $("#modal_show").find('input#resultado2').val(resultado2);
            $("#modal_show").find('input#penalti1').val(penalti1);
            $("#modal_show").find('input#penalti2').val(penalti2);
            // gols
            $row = '';
            if(typeof $gols[id+'_'+id1] !== 'undefined'){$tamanho1 = $gols[id+'_'+id1].length;}else{$tamanho1 = 0;}
            if(typeof $gols[id+'_'+id2] !== 'undefined'){$tamanho2 = $gols[id+'_'+id2].length;}else{$tamanho2 = 0;}
            if($tamanho1 > $tamanho2)
                $maior = $tamanho1;
            else
                $maior = $tamanho2;
            for (var index = 0; index < $maior; index++) {
                if(typeof $gols[id+'_'+id1] !== 'undefined' && typeof $gols[id+'_'+id1][index] !== 'undefined'){
                    $jogador1 = $nomes[$gols[id+'_'+id1][index]['jogador']];
                    $qtd1 = $gols[id+'_'+id1][index]['quantidade'];
                } else {
                    $jogador1 = '';
                    $qtd1 = '';
                }
                if(typeof $gols[id+'_'+id2] !== 'undefined' && typeof $gols[id+'_'+id2][index] !== 'undefined'){
                    $jogador2 = $nomes[$gols[id+'_'+id2][index]['jogador']];
                    $qtd2 = $gols[id+'_'+id2][index]['quantidade'];
                } else {
                    $jogador2 = '';
                    $qtd2 = '';
                }
                $row += '<tr><td colspan="2">'+$jogador1+'</td><td>'+$qtd1+'</td><td></td><td colspan="2">'+$jogador2+'</td><td>'+$qtd2+'</td></tr>';
            }
            $("#modal_show").find('tbody#gols').append($row);
            // cartões
            $row = '';
            if(typeof $cartoes[id+'_'+id1] !== 'undefined'){$tamanho1 = $cartoes[id+'_'+id1].length;}else{$tamanho1 = 0;}
            if(typeof $cartoes[id+'_'+id2] !== 'undefined'){$tamanho2 = $cartoes[id+'_'+id2].length;}else{$tamanho2 = 0;}
            if($tamanho1 > $tamanho2)
                $maior = $tamanho1;
            else
                $maior = $tamanho2;
            for (var index = 0; index < $maior; index++) {
                if(typeof $cartoes[id+'_'+id1] !== 'undefined' && typeof $cartoes[id+'_'+id1][index] !== 'undefined'){
                    $jogador1 = $nomes[$cartoes[id+'_'+id1][index]['jogador']];
                    $cor1 = $cor[$cartoes[id+'_'+id1][index]['cor']];
                } else {
                    $jogador1 = '';
                    $cor1 = '';
                }
                if(typeof $cartoes[id+'_'+id2] !== 'undefined' && typeof $cartoes[id+'_'+id2][index] !== 'undefined'){
                    $jogador2 = $nomes[$cartoes[id+'_'+id2][index]['jogador']];
                    $cor2 = $cor[$cartoes[id+'_'+id2][index]['cor']];
                } else {
                    $jogador2 = '';
                    $cor2 = '';
                }
                $row += '<tr><td colspan="2">'+$jogador1+'</td><td>'+$cor1+'</td><td></td><td colspan="2">'+$jogador2+'</td><td>'+$cor2+'</td></tr>';
            }
            $("#modal_show").find('tbody#cartoes').append($row);
            // lesões
            $row = '';
            if(typeof $lesoes[id+'_'+id1] !== 'undefined'){$tamanho1 = $lesoes[id+'_'+id1].length;}else{$tamanho1 = 0;}
            if(typeof $lesoes[id+'_'+id2] !== 'undefined'){$tamanho2 = $lesoes[id+'_'+id2].length;}else{$tamanho2 = 0;}
            if($tamanho1 > $tamanho2)
                $maior = $tamanho1;
            else
                $maior = $tamanho2;
            for (var index = 0; index < $maior; index++) {
                if(typeof $lesoes[id+'_'+id1] !== 'undefined' && typeof $lesoes[id+'_'+id1][index] !== 'undefined'){
                    $jogador1 = $nomes[$lesoes[id+'_'+id1][index]['jogador']];
                    $qtd1 = ', '+ $lesoes[id+'_'+id1][index]['rodadas']+' rodada(s)';
                } else {
                    $jogador1 = '';
                    $qtd1 = '';
                }
                if(typeof $lesoes[id+'_'+id2] !== 'undefined' && typeof $lesoes[id+'_'+id2][index] !== 'undefined'){
                    $jogador2 = $nomes[$lesoes[id+'_'+id2][index]['jogador']];
                    $qtd2 = ', '+$lesoes[id+'_'+id2][index]['rodadas']+' rodada(s)';
                } else {
                    $jogador2 = '';
                    $qtd2 = '';
                }
                $row += '<tr><td colspan="3">'+$jogador1+$qtd1+'</td><td></td><td colspan="3">'+$jogador2+$qtd2+'</td></tr>';
            }
            $("#modal_show").find('tbody#lesoes').append($row);
        } else {
            $("#modal_store").find('#rodada').val(rodada);
            if(campeonato == 'Copa'){
                $("#modal_store").find('.modal-title').html('Cadastrar Resultado da Copa FEDIA');
                if([0,1,2,3].includes(ordem))
                    $message = 'Quartas de Final'+' - '+rodada;
                else if([4,5].includes(ordem))
                    $message = 'Semi-Final'+' - '+rodada;
                else
                    $message = 'Final';
                $("#modal_store").find('.body-title').html($message);
            } else if(campeonato == 'Liga') {
                $("#modal_store").find('.modal-title').html('Cadastrar Resultado da Liga FEDIA');
                $("#modal_store").find('.body-title').html('Rodada '+rodada);
            }
            $("#modal_store").find('select.chzn-select > option').remove();
            $("#modal_store").find('select.time1').each(function( index ) {
                $(this).append("<option value=''>Nenhum</option>");
                for(var index in $jogadores[id1])
                    $(this).append("<option value='"+$jogadores[id1][index]['id']+"'>"+$jogadores[id1][index]['nome']+"</option>");
                $(this).trigger("liszt:updated");
            });
            $("#modal_store").find('select.time2').each(function( index ) {
                $(this).append("<option value=''>Nenhum</option>");
                for(var index in $jogadores[id2])
                    $(this).append("<option value='"+$jogadores[id2][index]['id']+"'>"+$jogadores[id2][index]['nome']+"</option>");
                $(this).trigger("liszt:updated");
            });
        }
    }

    function add_linha(elemento){
        $linha = $(elemento).parent().parent().clone();
        $($linha).find('input[type=text]').val('');
        $($linha).find('input[type=number]').val('0');
        $(elemento).parent().parent().after($linha);
        $size = $(elemento).parent().parent().parent().find('tr').size();
        // Restaura chzn-select
        $($linha).find('select.time1').attr('id',$($linha).find('select').attr('id')+"_1_"+$size);
        $($linha).find('select.time2').attr('id',$($linha).find('select').attr('id')+"_2_"+$size);
        $($linha).find('.chzn-container').remove();
        $($linha).find('.chzn-select').show();
        $($linha).find('.chzn-select').removeClass('chzn-done');
        $($linha).find('.chzn-select').chosen();
    }
</script>