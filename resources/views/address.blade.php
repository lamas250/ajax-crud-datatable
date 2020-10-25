@extends('template')

@section('content')
<div class="container">
    <h3 align="center">User Address</h3>
    <br>
    <div align="right">
        <button class="btn btn-success">Novo</button>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="address_table">
            <thead>
                <tr>
                    <th width="10%">Nome</th>
                    <th width="35%">Cidade</th>
                    <th width="35%">CEP</th>
                    <th width="30%">Ações</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection

@section('scripts')

<script>
$(document).ready(function(){

$('#address_table').DataTable({
    
    processing: true,
    serverSide: true,
    ajax:{
        url: "{{ route('address.index') }}",
    },
    columns:[
        { data: 'first_name', name: 'first_name', orderable: false },
        { data: 'address.city', name: 'address.city' },
        { data: 'address.zipcode', name: 'address.zipcode'},
        { data: 'action', name: 'action', orderable: false}
    ]
    });
});
</script>

@endsection