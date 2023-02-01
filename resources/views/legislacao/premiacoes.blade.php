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
    <h2 class="margin-bottom-10">Premiações</h2>
</div>


<div class="templatemo-flex-row flex-content-row">
    <div class="templatemo-content-widget no-padding col-2">
        <div class="panel panel-default table-responsive">
            <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                    <tr>
                        <th colspan="2">Liga</th>
                    </tr>
                    <tr>
                        <th>Conquista</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Campeão</td>
                        <td>€ 32.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Vice-Campeão</td>
                        <td>€ 30.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Terceiro colocado</td>
                        <td>€ 29.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Quarto colocado</td>
                        <td>€ 28.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Quinto colocado</td>
                        <td>€ 27.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Sexto colocado</td>
                        <td>€ 26.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Sétimo colocado</td>
                        <td>€ 25.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Oitavo colocado</td>
                        <td>€ 24.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Nono colocado</td>
                        <td>€ 23.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Décimo colocado</td>
                        <td>€ 22.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Décimo Primeiro colocado</td>
                        <td>€ 21.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Décimo Segundo colocado</td>
                        <td>€ 20.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Artilharia</td>
                        <td>€ 2.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Melhor Jogador</td>
                        <td>€ 2.000.000,00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="templatemo-content-widget no-padding col-2">
        <div class="panel panel-default table-responsive">
            <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                    <tr>
                        <th colspan="2">Copa</th>
                    </tr>
                    <tr>
                        <th>Conquista</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Passar das Quartas de Final</td>
                        <td>€ 8.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Passar das Semifinais</td>
                        <td>€ 4.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Campeão</td>
                        <td>€ 3.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Artilharia</td>
                        <td>€ 2.000.000,00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel panel-default table-responsive">
            <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                    <tr>
                        <th colspan="2">Taça</th>
                    </tr>
                    <tr>
                        <th>Conquista</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Passar das Quartas de Final</td>
                        <td>€ 4.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Passar das Semifinais</td>
                        <td>€ 2.000.000,00</td>
                    </tr>
                    <tr>
                        <td>Campeão</td>
                        <td>€ 1.500.000,00</td>
                    </tr>
                    <tr>
                        <td>Artilharia</td>
                        <td>€ 1.000.000,00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel panel-default table-responsive">
            <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                    <tr>
                        <th colspan="2">SuperCopa</th>
                    </tr>
                    <tr>
                        <th>Conquista</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Campeão</td>
                        <td>€ 2.000.000,00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel panel-default table-responsive">
            <table class="table table-striped table-bordered templatemo-user-table">
                <thead>
                    <tr>
                        <th colspan="2">Patrocínio</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>€ 20.000.000,00 na primeira temporada, adicionando € 2.500.000,00 em cada temporada subsequente.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
