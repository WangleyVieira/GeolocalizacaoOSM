@extends('layout.main')

@section('content')


@include('errors.alerts')
@include('errors.errors')

<div class="card">
    <div class="card-body">
        <form method="POST" action="#">
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
                    <input type="file">
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
{{--
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{asset('jquery-mask/src/jquery.mask.js')}}"></script> --}}

{{-- cliente_id: 58810866-9a80-4cdd-ae02-6ec27077747f --}}

@endsection
