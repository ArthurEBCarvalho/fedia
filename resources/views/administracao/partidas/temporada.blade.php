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
    <h2 class="margin-bottom-10">Temporadas</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="numero" @if ($filtro == "numero") selected @endif>Número</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
            <div class="pull-right"><a href="{{ route('administracao.partidas.temporada_store') }}" type="button" class="btn btn-success" onClick="return confirm('Deseja realmente cadastrar a temporada {{$temporadas->count()+1}}?')"><i class="fa fa-plus"></i> Cadastrar Nova {{substr_replace("Temporadas", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($temporadas->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=numero" class="white-text templatemo-sort-by">Número <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'numero',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'numero') !== false)active @endif">Número <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=numero',Request::fullUrl())}} @if($param == 'numero')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'numero') !== false)active @endif">Número <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif
                    <th>Campeão da Liga FEDIA</th>
                    <th>Vice Campeão da Liga FEDIA</th>
                    <th>Terceiro Lugar da Liga FEDIA</th>
                    <th>Artilheiro da Liga FEDIA</th>
                    <th>Campeão da Copa FEDIA</th>
                    <th>Vice Campeão da Copa FEDIA</th>
                    <th>Artilheiro da Copa FEDIA</th>
                </tr>
            </thead>

            <tbody>
                @foreach($temporadas as $temporada)
                <tr>
                    <td width="125">{{$temporada->numero}}ª Temporada</td>
                    <td>{{@$temporada->liga1()->nome}}</td>
                    <td>{{@$temporada->liga2()->nome}}</td>
                    <td>{{@$temporada->liga3()->nome}}</td>
                    <td>{{join(', ',@$temporada->artilheiro_liga())}}</td>
                    <td>{{@$temporada->copa1()->nome}}</td>
                    <td>{{@$temporada->copa2()->nome}}</td>
                    <td>{{join(', ',@$temporada->artilheiro_copa())}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$temporadas->firstItem()}}</strong> ao <strong>{{$temporadas->lastItem()}}</strong> de um total de <strong>{{$temporadas->total()}}</strong> registros</p>
    {!! $temporadas->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma {{substr_replace("Temporadas", "", -1)}} encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif
@endsection
