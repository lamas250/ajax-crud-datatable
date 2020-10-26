@extends('template')

@section('content')
<div class="container">
    <h3 align="center">User Address</h3>
    <br>
    <div align="right">
        <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Novo</button>
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

<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Add New Record</h4>
           </div>
           <div class="modal-body">
            <span id="form_result"></span>
            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
             @csrf
             <div class="form-group">
               <label class="control-label col-md-4" >Usuario: </label>
               <div class="col-md-8">
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Selecione ..</option>
                    @foreach($usersWithoutAddress as $value)
                        <option value="{{$value->id}}">{{$value->first_name .' '. $value->last_name}}</option>
                    @endforeach
                </select>
               </div>
              </div>
              <div class="form-group">
               <label class="control-label col-md-4">Cidade: </label>
               <div class="col-md-8">
                <input type="text" name="city" id="city" class="form-control" />
               </div>
              </div>
              <div class="form-group">
               <label class="control-label col-md-4">CEP: </label>
               <div class="col-md-8">
                <input type="text" name="zipcode" id="zipcode" class="form-control"/>
               </div>
              </div>
              <br />
              <div class="form-group" align="center">
               <input type="hidden" name="action" id="action" />
               <input type="hidden" name="hidden_id" id="hidden_id" />
               <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
              </div>
            </form>
           </div>
        </div>
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

$('#create_record').click(function(){
 $('.modal-title').text("Add New Record");
       $('#action_button').val("Add");
       $('#action').val("Add");
       $('#formModal').modal('show');
       $('#city').val('');
       $('#zipcode').val('');
});

$('#sample_form').on('submit', function(event){
 event.preventDefault();
 if($('#action').val() == 'Add')
 {
  $.ajax({
   url:"{{ route('address.store') }}",
   method:"POST",
   data: new FormData(this),
   contentType: false,
   cache:false,
   processData: false,
   dataType:"json",
   success:function(data)
   {
    var html = '';
    if(data.errors)
    {
     html = '<div class="alert alert-danger">';
     for(var count = 0; count < data.errors.length; count++)
     {
      html += '<p>' + data.errors[count] + '</p>';
     }
     html += '</div>';
    }
    if(data.success)
    {
     html = '<div class="alert alert-success">' + data.success + '</div>';
     $('#sample_form')[0].reset();
     $('#address_table').DataTable().ajax.reload();
    }
    $('#form_result').html(html);
   }
  })
 }

 if($('#action').val() == "Edit")
 {
  $.ajax({
   url:"{{ route('address.update') }}",
   method:"POST",
   data:new FormData(this),
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   success:function(data)
   {
    var html = '';
    if(data.errors)
    {
     html = '<div class="alert alert-danger">';
     for(var count = 0; count < data.errors.length; count++)
     {
      html += '<p>' + data.errors[count] + '</p>';
     }
     html += '</div>';
    }
    if(data.success)
    {
     html = '<div class="alert alert-success">' + data.success + '</div>';
     $('#sample_form')[0].reset();
     $('#address_table').DataTable().ajax.reload();
    }
    $('#form_result').html(html);
   }
  });
 }
});

$(document).on('click', '.edit', function(){
 var id = $(this).attr('id');
 $('#form_result').html('');
 $.ajax({
  url:"/address/"+id+"/edit",
  dataType:"json",
  success:function(html){
   $("#user_id").html($('<option></option>', {value: html.data.id, text: html.data.first_name}));
   $('#city').val(html.data.address.city);
   $('#zipcode').val(html.data.address.zipcode);
   $('#hidden_id').val(html.data.id);
   $('.modal-title').text("Edit New Record");
   $('#action_button').val("Edit");
   $('#action').val("Edit");
   $('#formModal').modal('show');
  }
 })
});

});
</script>

@endsection