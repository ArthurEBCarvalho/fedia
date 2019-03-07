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

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Ausências</h2>
    <div class="row">
        <div class="col-md-5 col-sm-12 form-group">
            <form role="form" method="get">
                <div class="input-group">
                    <span class="input-group-addon">Tipo: </span>
                    <select class="form-control search-filtro" name="tipo">
                        <option value="mes" @if ($tipo == 'mes') selected @endif>Por Mês</option>
                        <option value="temporada" @if ($tipo == 'temporada') selected @endif>Por Temporada</option>
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-5 col-sm-12 form-group">
            <form role="form" method="get">
                <div class="input-group">
                    <span class="input-group-addon">Usuário: </span>
                    <select class="form-control search-filtro" name="user_id">
                        <option>Todos</option>
                        @foreach($all_users as $id => $nome)
                        <option value="{{$id}}" @if ($user_id == $id) selected @endif>{{$nome}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-2 col-sm-12 form-group">
            <div class="pull-right"><a href="javascript:;" data-toggle="modal" data-target="#modal_times" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Cadastrar Ausências</a></div>
        </div>
    </div>
</div>

@if(count($users))
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>
                        @if($tipo == 'mes')
                        {{date("Y")}}
                        @else
                        {{Session::get('era')->nome}}
                        @endif
                    </th>
                    <?php $tipo == 'mes' ? $colunas = $meses : $colunas = $temporadas_option ?>
                    @foreach($colunas as $nome)
                    <th>{{$nome}}@if($tipo == 'temporada')ª Temporada @endif</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($users as $id => $nome)
                <tr>
                    <td>{{$nome}}</td>
                    @foreach($ausencias[$id] as $qtd)
                    <td>{{$qtd}}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Modals -->
<div class="modal fade" id="modal_times" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {!! Form::open(['route' => 'administracao.users.ausencia_store', 'method' => 'post']) !!}
        <input type="hidden" name="tipo" value="{{$tipo}}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Selecione os usuários ausentes e a data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        {!! Html::decode(Form::label('mes', 'Mês <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                        {!! Form::select('mes', $meses, date("m"), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        {!! Html::decode(Form::label('ano', 'Ano <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                        {!! Form::select('ano', $anos, date("Y"), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        {!! Html::decode(Form::label('temporada_id', 'Temporada <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                        {!! Form::select('temporada_id', $temporadas_option, $temporada->id, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        {!! Html::decode(Form::label('users', 'Usuários <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                        {!! Form::select('users[]', $users, null, ['class' => 'chzn-select form-control', 'multiple' => true]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sim</button>
                <button type="reset" class="btn btn-default" data-dismiss="modal">Não</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection