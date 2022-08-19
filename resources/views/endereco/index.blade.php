@extends('layout.main')

@section('content')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAUgxBPrGkKz6xNwW6Z1rJh26AqR8ct37A"></script>
<script src="{{ asset('js/gmaps.js') }}"></script>

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

<header class="container" style="padding: 2rem; background-color:white">
    <h2 class="text-center">
        <div>
            <span><i class="fas fa-address-book"></i></span>
        </div>
        <strong>Cadastrar endereço</strong>
    </h2>
</header>

<div class="container" style="padding: 3rem; background-color:white">

    <form action="{{ route('endereco.store') }}" id="form" method="POST">
        @csrf
        @method('POST')

        <div id="accordion2">
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Dados de endereço
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion2">
                    <div class="card-body">
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
                                    <div class="form-group col-md-6">
                                        <label for="lat">Latitude</label>
                                        <input type="text" name="lat" id="lat" class="form-control form-control-lg" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="long">Longitude</label>
                                        <input type="text" name="long" id="long" class="form-control form-control-lg" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" name="complemento" id="complemento" class="form-control form-control-lg" placeholder="Informe o complemento">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ponto_referencia">Ponto de Referência</label>
                                        <input type="text" name="ponto_referencia" class="form-control form-control-lg" placeholder="Informe o ponto de referência">
                                    </div>
                                </div>
                            </div>

                            <div id="location-map"></div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <a onclick="apresentar()" class="btn btn-secondary m-1">Apresentar no mapa A localização CEP</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div id="accordion3">
            <div class="card">
                <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Coordenadas do cliente
                    </button>
                </h5>
                </div>
                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion3">
                    <div class="card-body">
                        <legend>Pontos únicos</legend>
                        <div class="row mb-2" id="pontos1">
                            <div class="col-md-4" id="ponto1" style="border: 0.5px solid #CBCBCB">
                                <div class="col-12"><strong style="color: black">Ponto 1</strong></div>
                                <label class="form-label" for="latitudePonto[]">Latitude (graus decimais)</label>
                                <input type="text" name="latitudePonto[]" id="latPonto1" class="form-control mb-2" required>
                                <label class="form-label" for="longitudePonto[]">Longitude (graus decimais)</label>
                                <input type="text" name="longitudePonto[]" id="longPonto1" class="form-control mb-2" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="descPonto">Descrição</label>
                                <input type="text" name="descPonto" id="descPonto" class="form-control" value="{{ old('descPonto') }}">
                            </div>

                            <div class="col-md-12">
                                <a onclick="adicionar1()" class="btn btn-success btn-pill float-left m-1">Adicionar ponto</a>
                                <a onclick="remover1()" class="btn btn-danger btn-pill float-left m-1">Remover ponto</a>
                                <a onclick="apresentar1()" class="btn btn-secondary float-right m-1">Apresentar no mapa</a>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3" style="height: 300px;">
                            <div id="map1" style="height: 100%;"></div>
                        </div>
                        <hr class="mt-5">
                        <legend>Figuras</legend>
                        <div class="row mb-2" id="pontos2">
                            <div class="col-md-4" id="pontoFigura1" style="border: 0.5px solid #CBCBCB">
                                <div class="col-12"><strong style="color: black">Ponto 1</strong></div>
                                <label class="form-label" for="latitudeFigura[]">Latitude (graus decimais)</label>
                                <input type="text" name="latitudeFigura[]" id="latFigura1" class="form-control mb-2" required>
                                <label class="form-label" for="longitudeFigura[]">Longitude (graus decimais)</label>
                                <input type="text" name="longitudeFigura[]" id="longFigura1" class="form-control mb-2" required>
                            </div>
                            <div class="col-md-4" id="pontoFigura2" style="border: 0.5px solid #CBCBCB">
                                <div class="col-12"><strong style="color: black">Ponto 2</strong></div>
                                <label class="form-label" for="latitudeFigura[]">Latitude (graus decimais)</label>
                                <input type="text" name="latitudeFigura[]" id="latFigura2" class="form-control mb-2" required>
                                <label class="form-label" for="longitudeFigura[]">Longitude (graus decimais)</label>
                                <input type="text" name="longitudeFigura[]" id="longFigura2" class="form-control mb-2" required>
                            </div>
                            <div class="col-md-4" id="pontoFigura3" style="border: 0.5px solid #CBCBCB">
                                <div class="col-12"><strong style="color: black">Ponto 3</strong></div>
                                <label class="form-label" for="latitudeFigura[]">Latitude (graus decimais)</label>
                                <input type="text" name="latitudeFigura[]" id="latFigura3" class="form-control mb-2" required>
                                <label class="form-label" for="longitudeFigura[]">Longitude (graus decimais)</label>
                                <input type="text" name="longitudeFigura[]" id="longFigura3" class="form-control mb-2" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="descFigura">Descrição</label>
                                <input type="text" name="descFigura" id="descFigura" class="form-control" value="{{ old('descFigura') }}">
                            </div>

                            <div class="col-md-12">
                                <a onclick="adicionar2()" class="btn btn-success btn-pill float-left m-1">Adicionar ponto</a>
                                <a onclick="remover2()" class="btn btn-danger btn-pill float-left m-1">Remover ponto</a>
                                <a onclick="apresentar2()" class="btn btn-secondary float-right m-1">Apresentar no mapa</a>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3" style="height: 300px;">
                            <div id="map2" style="height: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <br>
        <div class="container-fluid">
            <button type="submit" style="width: 130px;" class="btn btn-primary p-2">Cadastrar</button>
        </div>
    </form>

</div>

<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{asset('jquery-mask/src/jquery.mask.js')}}"></script>

<script>

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


</script>

@endsection
