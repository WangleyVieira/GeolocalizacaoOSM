<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Cadastro de endereço</title>
    <link rel="shortcut icon" type="svg" href="{{ asset('image/layer-group-solid.svg') }}" style="color: #4a88eb">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.0/r-2.2.9/rr-1.2.8/datatables.min.css"/>
    <link href="{{asset('select2-4.1.0/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('select2-bootstrap/dist/select2-bootstrap.css')}}"/>
    <script src="{{ asset('js/jquery.js') }}"></script>

    {{-- scripts e links do mapa --}}
    <script src='https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.js'></script>
    <link href='https://unpkg.com/maplibre-gl@latest/dist/maplibre-gl.css' rel='stylesheet' />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>

    {{-- style referente ao mapa --}}
    <style>
        .error{
            color:red
        }

        #map{
            background: #fff;
            border: none;
            height: 540px;
            width: 100%;

            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
          }
    </style>
</head>

<div class="wrapper">
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="">
                <i class="fas fa-layer-group pt-2"></i>
                <span class="align-middle mr-3" style="font-size: .999rem;">Cadastro de Endereços</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Páginas
                </li>

                <li class="sidebar-item {{ Route::current()->uri == 'home' ? 'active' : null }}">
                    <a href="{{ route('home') }}" class="sidebar-link">
                        <i class="fas fa-user"></i>
                        Dados do Usuário
                    </a>
                </li>

                <li class="sidebar-item {{ Route::current()->uri == 'endereco' ? 'active' : null }}">
                    <a href="{{ route('endereco.index') }}" class="sidebar-link">
                        <i class="fas fa-map"></i>
                        Endereço
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            @if (Auth::check())
                <a class="sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
            @endif

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">

                    <a href="#">
                        <span class="glyphicon glyphicon-log-out"></span>
                    </a>
                    @if (Auth::guest())
                        <li>
                            <a class="btn btn-primary" style="color: white" href="{{ route('login') }}"
                                id="messagesDropdown" data-bs-toggle="dropdown">
                                <span>Login</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-toggle="dropdown">
                                <i class="fas fa-cog"></i>
                                <span class="text-dark"></span>
                            </a>
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-toggle="dropdown">
                                <span class="avatar"> {{ auth()->user()->name }}</span>
                                <span class="text-dark"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>


        <main class="content">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-left">
                    </div>
                    <div class="col-6 text-right">
                        <p class="mb-0">
                            &copy; 2022 - <a href="" class="text-muted">Cadastro de endereços</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('jquery-mask/dist/jquery.mask.min.js')}}"></script>
<script src="{{ url('js/fontawesome.js') }}"></script>
<script src="{{ url('js/bootstrap.js') }}"></script>
<script src="{{ url('js/functions.js') }}"></script>
<script src="{{ url('js/prevent_multiple_submits.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.0/r-2.2.9/rr-1.2.8/datatables.min.js"></script>
<script src="{{asset('select2-4.1.0/dist/js/select2.min.js')}}"></script>
{{--
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

    var map = L.map('map').setView([-20.46818922, -54.61853027], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


    function apresentar(){

        lati = $('#lat').val();
        long = $('#long').val();

        if (lati == '' || long == '') {
            alert('CEP não localizado, informar latitude e longitude para localizar.')
            return;
        }

        var marker = L.marker([endereco, bairro, cidade, numero]).addTo(map)
            .bindPopup('Geolocalização do CEP')
            .openPopup();
    }

    $(document).ready(function() {
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


</script> --}}
@yield('scripts')
</html>
