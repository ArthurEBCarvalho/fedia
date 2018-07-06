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
    <h2 class="margin-bottom-10">Transferências</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="data" @if ($filtro == "data") selected @endif>Data</option>
                        <option value="jogador" @if ($filtro == "jogador") selected @endif>Jogador</option>
                        <option value="valor" @if ($filtro == "valor") selected @endif>Valor</option>
                        <option value="time1" @if ($filtro == "time1") selected @endif>De</option>
                        <option value="time2" @if ($filtro == "time2") selected @endif>Para</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4 col-sm-12 form-group">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('administracao.transferencias.create') }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Nova {{substr_replace("Transferências", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($transferencias->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=data" class="white-text templatemo-sort-by">Data <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'data',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'data') !== false)active @endif">Data <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=data',Request::fullUrl())}} @if($param == 'data')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'data') !== false)active @endif">Data <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=jogador" class="white-text templatemo-sort-by">Jogador <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'jogador',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'jogador') !== false)active @endif">Jogador <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=jogador',Request::fullUrl())}} @if($param == 'jogador')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'jogador') !== false)active @endif">Jogador <span class="fa fa-caret-{{$caret}}"></span></a></th>
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

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=time1" class="white-text templatemo-sort-by">Origem <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'time1',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'time1') !== false)active @endif">Origem <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=time1',Request::fullUrl())}} @if($param == 'time1')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'time1') !== false)active @endif">Origem <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=time2" class="white-text templatemo-sort-by">Destino <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'time2',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'time2') !== false)active @endif">Destino <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=time2',Request::fullUrl())}} @if($param == 'time2')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'time2') !== false)active @endif">Destino <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($transferencias as $transferencium)
                <tr>
                    <td>{{date_format(date_create_from_format('Y-m-d H:s:i', $transferencium->created_at), 'd/m/Y')}}</td>
                    <td>{{$transferencium->jogador}}</td>
                    <td>€ {{number_format($transferencium->valor,2,',','.')}}</td>
                    <td>{{$transferencium->time1}}</td>
                    <td>{{$transferencium->time2}}</td>
                    <td class="small" align="center" alt="Editar Transferencium">
                        <a href="{{ route('administracao.transferencias.edit', $transferencium->id) }}">
                            {!! Html::image("images/icons/edit.png", "Editar Transferencium") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Transferencium">
                        <a onclick="confirm_delete('{{ route('administracao.transferencias.destroy', $transferencium->id) }}')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image("images/icons/delete.png", "Deletar Transferencium") !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$transferencias->firstItem()}}</strong> ao <strong>{{$transferencias->lastItem()}}</strong> de um total de <strong>{{$transferencias->total()}}</strong> registros</p>
    {!! $transferencias->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma {{substr_replace("Transferências", "", -1)}} encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif
@endsection
