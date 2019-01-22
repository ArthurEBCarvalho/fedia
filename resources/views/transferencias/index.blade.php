@extends('template')

@section('content')
@if (Session::has('message'))
<div class="templatemo-content-widget {{$color}}-bg">
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
                @if(isset($params['order']))
                <input type="hidden" name="order" value="{{$params['order']}}">
                @endif
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
        @if(Auth::user()->isAdmin())
        <div class="col-md-4 col-sm-12 form-group">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('transferencias.create') }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Nova {{substr_replace("Transferências", "", -1)}}</a></div>
            </div>
        </div>
        @endif
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
                    @if($param == 'data')
                    <?php $url = str_replace('order=data','order=data desc',Request::fullUrl()); ?>
                    @else
                    <?php $url = Request::fullUrl(); ?>
                    @endif
                    <th><a href="{{str_replace('order='.$param,'order=data',$url)}}" class="white-text templatemo-sort-by @if(strpos($param,'data') !== false)active @endif">Data <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=jogador" class="white-text templatemo-sort-by">Jogador <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'jogador',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'jogador') !== false)active @endif">Jogador <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if($param == 'jogador')
                    <?php $url = str_replace('order=jogador','order=jogador desc',Request::fullUrl()); ?>
                    @else
                    <?php $url = Request::fullUrl(); ?>
                    @endif
                    <th><a href="{{str_replace('order='.$param,'order=jogador',$url)}}" class="white-text templatemo-sort-by @if(strpos($param,'jogador') !== false)active @endif">Jogador <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=valor" class="white-text templatemo-sort-by">Valor <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'valor',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'valor') !== false)active @endif">Valor <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if($param == 'valor')
                    <?php $url = str_replace('order=valor','order=valor desc',Request::fullUrl()); ?>
                    @else
                    <?php $url = Request::fullUrl(); ?>
                    @endif
                    <th><a href="{{str_replace('order='.$param,'order=valor',$url)}}" class="white-text templatemo-sort-by @if(strpos($param,'valor') !== false)active @endif">Valor <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=time1" class="white-text templatemo-sort-by">Origem <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'time1',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'time1') !== false)active @endif">Origem <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if($param == 'time1')
                    <?php $url = str_replace('order=time1','order=time1 desc',Request::fullUrl()); ?>
                    @else
                    <?php $url = Request::fullUrl(); ?>
                    @endif
                    <th><a href="{{str_replace('order='.$param,'order=time1',$url)}}" class="white-text templatemo-sort-by @if(strpos($param,'time1') !== false)active @endif">Origem <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=time2" class="white-text templatemo-sort-by">Destino <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'time2',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'time2') !== false)active @endif">Destino <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if($param == 'time2')
                    <?php $url = str_replace('order=time2','order=time2 desc',Request::fullUrl()); ?>
                    @else
                    <?php $url = Request::fullUrl(); ?>
                    @endif
                    <th><a href="{{str_replace('order='.$param,'order=time2',$url)}}" class="white-text templatemo-sort-by @if(strpos($param,'time2') !== false)active @endif">Destino <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(Auth::user()->isAdmin())<th></th>@endif
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
                    @if(Auth::user()->isAdmin())
                    <td class="small" align="center" alt="Deletar Transferência">
                        <a onclick="confirm_delete('{{ route('transferencias.destroy', $transferencium->id) }}')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image("images/icons/delete.png", "Deletar Transferência") !!}
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$transferencias->firstItem()}}</strong> ao <strong>{{$transferencias->lastItem()}}</strong> de um total de <strong>{{$transferencias->total()}}</strong> registros</p>
    {!! $transferencias->appends($params)->render() !!}
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
