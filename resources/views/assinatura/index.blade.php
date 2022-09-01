@extends('layout.main')

@section('content')


@include('errors.alerts')
@include('errors.errors')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('anexos.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="form-label">Descrição*</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="file" name="anexo" id="anexo">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary m-1">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="datatable-responsive">
                <thead>
                    <tr>
                        <th scope="">#</th>
                        <th scope="col">Descricao</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Cadastrado por</th>
                        {{-- <th scope="col">Solicitar Assinatura</th> --}}
                        <th scope="col">Data de cadastro</th>
                        <th scope="col">Data de atualização</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anexos as $anexo)
                        <tr>
                            <td>{{ $anexo->id }}</td>
                            <td>{{ $anexo->descricao }}</td>
                            <td>
                                <a href="{{route('anexos.getFile', $anexo->id)}}" class="link">{{ $anexo->nome_original }}</a>
                            </td>
                            <td>{{ $anexo->cad_usuario->name }}</td>
                            {{-- <td>
                                <a href="" class="btn btn-primary"><i class="align-middle me-2 fas fa-fw fa-check"></i></a>
                            </td> --}}
                            <td>{{ $anexo->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $anexo->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- cliente_id: 58810866-9a80-4cdd-ae02-6ec27077747f --}}

@endsection
