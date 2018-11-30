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
    <h2 class="margin-bottom-10">Eras</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" @if ($filtro == "nome") selected @endif>Nome</option>
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
                <div class="pull-right"><a href="{{ route('administracao.eras.create') }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo {{substr_replace("Eras", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($eras->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=nome" class="white-text templatemo-sort-by">Nome <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=nome',Request::fullUrl())}} @if($param == 'nome')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($eras as $era)
                <tr>
                    <td>{{$era->nome}}</td>
                    <td class="small" align="center" alt="Editar Era">
                        <a href="{{ route('administracao.eras.edit', $era->id) }}">
                            {!! Html::image("images/icons/edit.png", "Editar Era") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Era">
                        <a onclick="confirm_delete('{{ route('administracao.eras.destroy', $era->id) }}')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image("images/icons/delete.png", "Deletar Era") !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$eras->firstItem()}}</strong> ao <strong>{{$eras->lastItem()}}</strong> de um total de <strong>{{$eras->total()}}</strong> registros</p>
    {!! $eras->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma {{substr_replace("Eras", "", -1)}} encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif
@endsection
