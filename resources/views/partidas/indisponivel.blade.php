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
    <h2 class="margin-bottom-10">Cartões e Lesões</h2>
    <div class="row">
        @if(Auth::user()->isAdmin())
        <form role="form" method="get">
            <div class="col-md-6 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Time: </span>
                    <select class="form-control search-filtro" name="time">
                        <option>Todos</option>
                        @foreach($times as $id => $t)
                        <option value="{{$t->id}}" @if ($time == $t->id) selected @endif>{{$t->nome}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Selecionar</button>
                    </span>
                </div>
            </div>
        </form>
        @endif
        <form role="form" method="get">
            <div class="col-md-6 col-sm-12 form-group">
                <div class="input-group">
                    <span class="input-group-addon">Temporada: </span>
                    <select class="form-control search-filtro" name="temporada">
                        @foreach($temporadas as $t)
                        <option value="{{$t->id}}" @if ($t->numero == $temporada->numero) selected @endif>{{$t->numero}}</option>
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

@if(count($indisponiveis))
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th colspan="2">Time</th>
                    <th>Cartões</th>
                    <th>Lesões</th>
                </tr>
            </thead>
            <tbody>
                @foreach($indisponiveis as $time_id => $array)
                <tr>
                    <td align="center">{!! Html::image('images/times/'.$array['escudo'], $array['nome'], ['class' => 'time_img']) !!}</td>
                    <td>{{$array['nome']}}</td>
                    <td>
                        @foreach($array['amarelo'] as $value)
                        <p>{{$value}}</p>
                        @endforeach
                        @foreach($array['vermelho'] as $value)
                        <p>{{$value}}</p>
                        @endforeach
                    </td>
                    <td>
                        @foreach($array['lesao'] as $value)
                        <p>{{$value}}</p>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhum jogador com cartão ou lesionado encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif
@endsection
