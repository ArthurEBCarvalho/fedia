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
        <h2 class="margin-bottom-10">Artilharia</h2>
        <div class="row">
            {!! Form::open(['action' => ('ArtilhariaController@index'), 'id' => 'form-filtro', 'method' => 'GET']) !!}
                <div id="filtro-basico">
                    <div class="col-md-2">
                        <div class="input-group">
                            {!! Form::label('temporada', 'Temporada:') !!}
                            {!! Form::number('temporada', isset($temporada->numero) ? $temporada->numero : null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            {!! Form::label('competicao', 'Competição:') !!}
                            {!! Form::select('competicao', ['0' => 'Todas', 'Liga' => 'Liga', 'Copa' => 'Copa'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            {!! Form::label('time', 'Time:') !!}
                            {!! Form::select('time', $times, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group" style="margin-top: 24px">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-search" aria-hidden="true"></span></button>
                            </span>
                            <span class="input-group-btn">
                                <a href="{{url('artilharia')}}" class="btn btn-primary btn-flat"><i class="fa fa-eraser"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    @if($jogadores->count())
        <div class="templatemo-content-widget no-padding">
            <div class="panel panel-default table-responsive">
                <table class="table table-striped table-bordered templatemo-user-table">
                    <thead>
                        <th>Nome</th>
                        <th>Time</th>
                        <th>Posição</th>
                        <th>Idade</th>
                        <th>Overall</th>
                        <th>Gols</th>
                    </thead>

                    <tbody>
                    @foreach($jogadores as $jogador)
                        <tr>
                            <td>{{$jogador->nome}}</td>
                            <td>{{$jogador->nome_time}}</td>
                            <td>{{str_replace('|',' ',$jogador->posicoes)}}</td>
                            <td>{{$jogador->idade}}</td>
                            <td>{{$jogador->overall}}</td>
                            <td>{{$jogador->gols}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination-wrap">
            <p class="text_pagination pull-left">Exibindo do <strong>{{$jogadores->firstItem()}}</strong> ao <strong>{{$jogadores->lastItem()}}</strong> de um total de <strong>{{$jogadores->total()}}</strong> registros</p>
            {!! $jogadores->render() !!}
        </div>
    @else
        <div class="templatemo-content-widget no-padding">
            <div class="templatemo-content-widget yellow-bg">
                <i class="fa fa-times"></i>
                <div class="media">
                    <div class="media-body">
                        <h2>Nenhum {{substr_replace("Jogadores", "", -1)}} encontrado!</h2>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
