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
        @if(Auth::user()->isAdmin())
        <div class="col-md-4">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('partidas.temporada_store') }}" type="button" class="btn btn-success" onClick="return confirm('Deseja realmente cadastrar a temporada {{$temporadas->count()+1}}?')"><i class="fa fa-plus"></i> Cadastrar Nova {{substr_replace("Temporadas", "", -1)}}</a></div>
            </div>
        </div>
        @endif
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
                    @if(Auth::user()->isAdmin())<th></th>@endif
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
                    @if(Auth::user()->isAdmin())
                    <td class="small" align="center" alt="Upload de Fotos">
                        <a href="javascript:;" onClick="$('#id_temporada').val({{$temporada->id}})" data-toggle="modal" data-target="#modal_fotos">{!! Html::image('images/icons/up.png', 'Upload de Fotos') !!}</a>
                    </td>
                    @endif
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
                <h2>Nenhuma {{substr_replace("Temporadas", "", -1)}} encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <div class="iso-section">
        <ul class="filter-wrapper clearfix">
            <li><a href="#" data-filter="*" class="selected opc-main-bg">Todas</a></li>
            @foreach($temporadas as $temporada)
            <li><a href="#" class="opc-main-bg" data-filter=".temporada{{$temporada->id}}">{{$temporada->numero}}ª Temporada</a></li>
            @endforeach
        </ul>
        <div class="iso-box-section">
            <div class="iso-box-wrapper col4-iso-box">
                @foreach($temporadas as $temporada)
                @foreach(explode('|',$temporada->fotos) as $foto)
                <?php if(blank($foto)){continue;} ?>
                <div class="iso-box temporada{{$temporada->id}} col-md-3 col-sm-6 col-xs-6">
                    <a href="images/temporadas/{{$temporada->id}}/{{$foto}}" data-lightbox-gallery="portfolio-all">{!! Html::image("images/temporadas/$temporada->id/$foto", $foto) !!}</a>
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal_fotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'partidas.temporada_fotos', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload de Fotos</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_temporada" name="id">
                {!! Form::file('images[]', ['class' => 'filestyle', 'multiple' => true, 'data-placeholder' => 'Selecione as fotos para importar']) !!}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sim</button>
                <button type="reset" class="btn btn-default" data-dismiss="modal">Não</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<style type="text/css">
    .iso-box-section img { max-width: 100%; }

    .filter-wrapper {
        width: 100%;
        margin: 0 0 24px 0;
        overflow: hidden;
        text-align: center;
    }

    .iso-section ul li {
        list-style: none;
    }

    .filter-wrapper li {
        display: inline-block;
        margin: 4px;
    }

    .filter-wrapper li a {
        color: #999999;
        font-weight: bold;
        padding: 8px 17px;
        display: block;
        text-decoration: none;
        transition: all 0.4s ease-in-out;
        -webkit-transition: all 0.4s ease-in-out;
        -moz-transition: all 0.4s ease-in-out;
        -ms-transition: all 0.4s ease-in-out;
    }

    .filter-wrapper li a.selected,
    .filter-wrapper li a:focus,
    .filter-wrapper li a:hover {
        background: #4682B4;
        border-color: transparent;
        color: #ffffff;
    }

    /* ISOTOPE BOX CSS */
    .iso-box-section {
        width: 100%;
    }
    .iso-box-wrapper {
        width: 100%;
        padding: 0;
        clear: both;
        position: relative;
    }
    .iso-box {
        position: relative;
        min-height: 50px;
        float: left;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .iso-box > a {
        display: block;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .iso-box > a {
        display: block;
        width: 100%;
        height: 100%;
        max-width: 400px;
        overflow: hidden;
        float: left;
        padding: 0 20px 20px 0;
    }
    .fluid-img {
        width: 100%;
        display: block;
    }
</style>

<link href="/css/nivo-lightbox.css" rel="stylesheet">
<link href="css/nivo_themes/default/default.css" rel="stylesheet">
<script src="/js/isotope.js"></script>
<script src="/js/nivo-lightbox.min.js"></script>
<script src="/js/imagesloaded.min.js"></script>
<script type="text/javascript">
    // NIVO LIGHTBOX
    $('.iso-box-section a').nivoLightbox({
        effect: 'fadeScale',
    });

    // ISOTOPE FILTER
    jQuery(document).ready(function($){

        if ( $('.iso-box-wrapper').length > 0 ) { 

            var $container  = $('.iso-box-wrapper'), 
            $imgs       = $('.iso-box img');



            $container.imagesLoaded(function () {

                $container.isotope({
                    layoutMode: 'fitRows',
                    itemSelector: '.iso-box'
                });

                $imgs.load(function(){
                    $container.isotope('reLayout');
                })

            });

        //filter items on button click

        $('.filter-wrapper li a').click(function(){
            /************* Arthur ***************/

            // Change data-lightbox-gallery to the selected system or all systems
            if($(this).attr('data-filter') == '*')
                $('.iso-box > a').attr('data-lightbox-gallery','portfolio-all');
            else {
                $.each(['temporada1'], function( index, value ) {
                    $(".iso-box."+value).each(function( i ) {
                        $(this).find('a').attr('data-lightbox-gallery','portfolio-'+value);
                    });
                });

            }

            /************* Arthur ***************/


            var $this = $(this), filterValue = $this.attr('data-filter');

            $container.isotope({ 
                filter: filterValue,
                animationOptions: { 
                    duration: 750, 
                    easing: 'linear', 
                    queue: false, 
                }                
            });             

            // don't proceed if already selected 

            if ( $this.hasClass('selected') ) { 
                return false; 
            }

            var filter_wrapper = $this.closest('.filter-wrapper');
            filter_wrapper.find('.selected').removeClass('selected');
            $this.addClass('selected');

            return false;
        }); 

    }

});
</script>

@endsection
