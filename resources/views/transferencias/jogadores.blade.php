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
    <h2 class="margin-bottom-10">Jogadores</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="jogadors.nome" @if ($filtro == "jogadors.nome") selected @endif>Nome</option>
                        <option value="jogadors.posicao" @if ($filtro == "jogadors.posicao") selected @endif>Posição</option>
                        <option value="jogadors.idade" @if ($filtro == "jogadors.idade") selected @endif>Idade</option>
                        <option value="jogadors.overall" @if ($filtro == "jogadors.overall") selected @endif>Overall</option>
                        <option value="jogadors.valor" @if ($filtro == "jogadors.valor") selected @endif>Valor</option>
                        <option value="times.nome" @if ($filtro == "times.nome") selected @endif>Time</option>
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


@if($jogadores->count())
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

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=posicao" class="white-text templatemo-sort-by">Posição <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'posicao',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'posicao') !== false)active @endif">Posição <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=posicao',Request::fullUrl())}} @if($param == 'posicao')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'posicao') !== false)active @endif">Posição <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=idade" class="white-text templatemo-sort-by">Idade <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'idade',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'idade') !== false)active @endif">Idade <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=idade',Request::fullUrl())}} @if($param == 'idade')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'idade') !== false)active @endif">Idade <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=overall" class="white-text templatemo-sort-by">Overall <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'overall',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'overall') !== false)active @endif">Overall <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=overall',Request::fullUrl())}} @if($param == 'overall')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'overall') !== false)active @endif">Overall <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=status" class="white-text templatemo-sort-by">Status <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'status',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'status') !== false)active @endif">Status <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=status',Request::fullUrl())}} @if($param == 'status')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'status') !== false)active @endif">Status <span class="fa fa-caret-{{$caret}}"></span></a></th>
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
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=time" class="white-text templatemo-sort-by">Time <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'time',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'time') !== false)active @endif">Time <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=time',Request::fullUrl())}} @if($param == 'time')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'time') !== false)active @endif">Time <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                </tr>
            </thead>

            <tbody>
                @foreach($jogadores as $jogador)
                <tr>
                    <td>{{$jogador->nome}}</td>
                    <td>{{str_replace('|',' ',$jogador->posicoes)}}</td>
                    <td>{{$jogador->idade}}</td>
                    <td>{{$jogador->overall}}</td>
                    <?php if($jogador->status == '0'){$color = "#888";}elseif($jogador->status == '1'){$color = 'red';}else{$color = 'green';} ?>
                    <td align="center" width="140" style="color:{{$color}}">{{$STATUS[$jogador->status]}}</td>
                    <td align="right">€ {{number_format($jogador->valor,2,',','.')}}</td>
                    <td>{{$jogador->time}}</td>
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
