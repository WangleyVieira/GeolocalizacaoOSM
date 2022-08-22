@extends('layout.main')

@section('content')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

<script src='https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js'></script>
<link href='https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css' rel='stylesheet' />

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin=""/>

<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>


<style>
    .error{
        color:red
    }

    #location-map{
        background: #fff;
        border: none;
        height: 540px;
        width: 100%;

        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
      }
</style>
@include('errors.alerts')
@include('errors.errors')

{{-- <header class="container" style="padding: 2rem; background-color:white">
    <h2 class="text-center">
        <div>
            <span><i class="fas fa-address-book"></i></span>
        </div>
        <strong>Cadastrar endereço</strong>
    </h2>
</header> --}}

<div class="col-12">

    <form action="{{ route('endereco.store') }}" id="form" method="POST">
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-body">

            <h5>Dados Pessoais</h5>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="form-label">Nome</label>
                    <input class="form-control form-control-lg" type="text" name="nome" id="nome" placeholder="Informe seu nome" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">CPF</label>
                    <input class="cpf form-control form-control-lg" type="text" name="cpf" id="cpf" placeholder="Informe seu CPF" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control form-control-lg" type="email" name="email" placeholder="Informe um email válido" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="telefone_contato1">Telefone (Celular)</label>
                    <input type="text" name="telefone_contato1" id="telefone_contato1" value="" class="form-control form-control-lg">
                </div>
            </div>
            <br>
            <hr>
            <h5>Dados de endereço</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control form-control-lg" placeholder="Informe o CEP">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="endereco">Endereço (Rua/Avenida)</label>
                            <input type="text" name="endereco" id="endereco" class="form-control form-control-lg" placeholder="Informe o endereço">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control form-control-lg" placeholder="Informe a cidade">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="uf">UF</label>
                            <input type="text" name="uf" id="uf" class="form-control form-control-lg" placeholder="Informe a UF">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" id="numero" class="form-control form-control-lg" placeholder="Informe o número">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-control form-control-lg" placeholder="Informe o bairro">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control form-control-lg" placeholder="Informe o complemento">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ponto_referencia">Ponto de Referência</label>
                            <input type="text" name="ponto_referencia" class="form-control form-control-lg" placeholder="Informe o ponto de referência">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="lat">Latitude</label>
                            <input type="text" name="lat" id="lat" class="form-control form-control-lg">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="long">Longitude</label>
                            <input type="text" name="long" id="long" class="form-control form-control-lg">
                        </div>
                    </div>
                </div>

                <div id="location-map"></div>

            </div>
        </div>
        <div class="col-md-12">
            <a onclick="apresentar()" class="btn btn-secondary m-1">Apresentar no mapa</a>
            <button type="submit" class="btn btn-primary m-1">Cadastrar</button>
        </div>
        <br>
    </form>

    <div id="accordion3">
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Listagem
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="datatable-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contato</th>
                                    <th scope="col">CEP</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Cidade</th>
                                    <th scope="col">UF</th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Bairro</th>
                                    <th scope="col">Complemento</th>
                                    <th scope="col">Ponto de referência</th>
                                    <th scope="col">Geolocalização</th>
                                    <th scope="col">Cadastrado Por</th>
                                    <th scope="col">Ver mapa</th>
                                    <th scope="col">Alterar</th>
                                    <th scope="col">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enderecos as $end)
                                <tr>
                                    <td>{{ $end->id }}</td>
                                    <td>{{ $end->nome }}</td>
                                    <td>{{ $end->cpf }}</td>
                                    <td>{{ $end->email }}</td>
                                    <td>{{ $end->telefone }}</td>
                                    <td>{{ $end->cep != null ? $end->cep : 'não informado' }}</td>
                                    <td>{{ $end->endereco != null ? $end->endereco : 'não informado' }}</td>
                                    <td>{{ $end->cidade != null ? $end->cidade : 'não informado' }}</td>
                                    <td>{{ $end->uf != null ? $end->uf : 'não informado' }}</td>
                                    <td>{{ $end->numero != null ? $end->numero : 'não informado' }}</td>
                                    <td>{{ $end->bairro != null ? $end->bairro : 'não informado' }}</td>
                                    <td>{{ $end->complemento != null ? $end->complemento : 'não informado' }}</td>
                                    <td>{{ $end->ponto_referencia != null ? $end->ponto_referencia : 'não informado' }}</td>
                                    <td>
                                        Latitude: {{ $end->lat != null ? $end->lat : 'não informado' }}<br>
                                        Longitude: {{ $end->long != null ? $end->long : 'não informado' }}
                                    </td>
                                    <td>{{ isset($end->cadastradoPorUsuario) ? $end->user->name : 'nativo do sistema' }}</td>
                                    <td>
                                        <a onclick="apresentar2({{ $end->id }})" class="btn btn-secondary m-1"><i class="align-middle me-2 fas fa-fw fa-map-marked"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('endereco.edit', $end->id) }}" class="btn btn-warning"><i class="align-middle me-2 fas fa-fw fa-pen"></i></a>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#dangerModal{{ $end->id }}" class="btn btn-danger m-1"><i class="align-middle me-2 fas fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                                {{-- modal de delete --}}
                                <div class="modal fade" id="dangerModal{{ $end->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <form action="{{ route('endereco.destroy', $end->id) }}" method="POST" id="delete_form">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tem certeza?</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="motivo" class="form-label">Motivo</label>
                                                            <input type="text" class="form-control" name="motivo" id="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{asset('jquery-mask/src/jquery.mask.js')}}"></script>

<script>

    $('.cpf').mask('000.000.000-00');
    $('#telefone_contato1').mask('(00) 0 0000-0000');
    //script relacionado ao CEP
    $('#cep').mask('00.000-000');

    $('#cep').on('change', function(){
        var cep = $(this).val().replace(/[.-]/g,"");
        // console.log('CEP: ', cep);
        // console.log('Quantidade de caracteres: ', cep.length);
        if (cep.length != 8){
            $("#endereco").val('');
            $("#complemento").val('');
            $("#bairro").val('');
            $("#cidade").val('');
            $("#uf").val('');
            alert('CEP INVÁLIDO!');
        }
        else{
            $.ajax({
                //O campo URL diz o caminho de onde virá os dados
                //É importante concatenar o valor digitado no CEP

                // url: 'https://viacep.com.br/ws/'+cep+'/json/',

                url: 'https://brasilapi.com.br/api/cep/v2/'+cep,
                //Aqui você deve preencher o tipo de dados que será lido,
                //no caso, estamos lendo JSON.
                dataType: 'json',
                //SUCESS é referente a função que será executada caso
                //ele consiga ler a fonte de dados com sucesso.
                //O parâmetro dentro da função se refere ao nome da variável
                //que você vai dar para ler esse objeto.
                success: function(resposta){
                    //Agora basta definir os valores que você deseja preencher
                    //automaticamente nos campos acima.
                    $("#endereco").val(resposta.street);
                    // $("#complemento").val(resposta.complemento);
                    $("#bairro").val(resposta.neighborhood);
                    $("#cidade").val(resposta.city);
                    $("#uf").val(resposta.state);
                    $("#lat").val(resposta.location.coordinates.latitude);
                    $("#long").val(resposta.location.coordinates.longitude);
                    //Vamos incluir para que o Número seja focado automaticamente
                    //melhorando a experiência do usuário
                    if (resposta.logradouro != null && resposta.logradouro != ""){
                        $("#numero").focus();
                    }
                    else{
                        $("#endereco").focus();
                    }

                },
                error: function(resposta){
                    //Agora basta definir os valores que você deseja preencher
                    //automaticamente nos campos acima.
                    alert("Erro, CEP inválido");
                    $("#endereco").val('');
                    $("#complemento").val('');
                    $("#bairro").val('');
                    $("#cidade").val('');
                    $("#uf").val('');
                    $("#lat").val('');
                    $("#long").val('');
                    //Vamos incluir para que o Número seja focado automaticamente
                    //melhorando a experiência do usuário
                    $("#cep").focus();
                },
            });
        }
    });


    //obtenção geolocalização por cep
    var map = L.map('location-map').setView([-20.46818922, -54.61853027], 17);
      mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
      L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: 'Map data &copy; ' + mapLink,
          maxZoom: 5,
        }).addTo(map);
        // var marker = L.marker([-20.46818922, -54.61853027]).addTo(map);

    function apresentar(){

        lati = $('#lat').val();
        long = $('#long').val();

        var marker = L.marker([lati, long], 10).addTo(map);

        // var marker = L.marker([lati, long], 10).addTo(map).setCenter(lati, long);

        // marker.setCenter(lati, long);
        // map.maxZoom(5);

        // console.log(marker);

    }

    $(document).ready(function() {
        // $.noConflict();

        // $('.select2').select2({
        //     language: {
        //         noResults: function() {
        //             return "Nenhum resultado encontrado";
        //         }
        //     },
        //     closeOnSelect: true,
        //     width: '100%',
        // });

        $('#datatable-responsive').dataTable({
            "order": [[ 0, "asc" ]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "searchable": false,
                    "visible": false
                }
            ],
            "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros por página",
                "sZeroRecords": "Nenhum registro encontrado",
                "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Pesquisar: ",
                "oPaginate": {
                    "sFirst": "Início",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                }
            },
        });
    });


</script>

@endsection
