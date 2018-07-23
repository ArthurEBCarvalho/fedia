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
    <h2 class="margin-bottom-10">Histórico Financeiro do {{Auth::user()->time()->nome}}</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="descricao" @if ($filtro == "descricao") selected @endif>Descrição</option>
                        <option value="valor" @if ($filtro == "valor") selected @endif>Valor</option>
                        <option value="operacao" @if ($filtro == "operacao") selected @endif>Operação</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>


@if($financeiros->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=descricao" class="white-text templatemo-sort-by">Descricao <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'descricao',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'descricao') !== false)active @endif">Descricao <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=descricao',Request::fullUrl())}} @if($param == 'descricao')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'descricao') !== false)active @endif">Descricao <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=operacao" class="white-text templatemo-sort-by">Operacao <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'operacao',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'operacao') !== false)active @endif">Operacao <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=operacao',Request::fullUrl())}} @if($param == 'operacao')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'operacao') !== false)active @endif">Operacao <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=valor" class="white-text templatemo-sort-by">Valor <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'valor',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'valor') !== false)active @endif">Valor <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=valor',Request::fullUrl())}} @if($param == 'valor')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'valor') !== false)active @endif">Valor <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                </tr>
            </thead>

            <tbody>
            <tr class="linha_total">
                <td colspan="2">Total: </td>
                <td align="right">{{number_format($total,2,',','.')}}</td>
            </tr>
                @foreach($financeiros as $financeiro)
                <tr style="color: @if($financeiro->operacao == 0) green @else red @endif;">
                    <td align="center">{{$financeiro->descricao}}</td>
                    <td align="center">@if($financeiro->operacao == 1) Saída @else Entrada @endif</td>
                    <td align="right">{{number_format($financeiro->valor,2,',','.')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$financeiros->firstItem()}}</strong> ao <strong>{{$financeiros->lastItem()}}</strong> de um total de <strong>{{$financeiros->total()}}</strong> registros</p>
    {!! $financeiros->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhum {{substr_replace("Financeiros", "", -1)}} encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif
@endsection
