@extends('template')

@section('content')
<div class="container">
    <h3 align="center">User Job</h3>
    <br>
    <div align="right">
        <button class="btn btn-success btn-sm" name="create_record" id="create_record" type="button">Novo Job</button>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="job_table">
            <thead>
                <tr>
                    <th width="20%">Nome</th>
                    <th width="30%">Trabalho</th>
                    <th width="30%">Detalhes</th>
                    <th width="30%">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8" align="center">Nenhum registro encontrado.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add New Record</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                    @foreach($usersWithoutJob as $value)
                        <option value="{{$value->id}}">{{$value->first_name .' '. $value->last_name}}</option>
                    @endforeach
                </select>
               </div>
              </div>
              <div class="form-group">
               <label class="control-label col-md-4">Job: </label>
               <div class="col-md-8">
                <input type="text" name="job" id="job" class="form-control" />
               </div>
              </div>
              <div class="form-group">
               <label class="control-label col-md-4">Detail: </label>
               <div class="col-md-8">
                <input type="text" name="detail" id="detail" class="form-control"/>
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

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Confirmation</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
               
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                 <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
     </div>

@endsection

@section('scripts')

	<script>
        var rotaListaJobs = "{!! route('jobs.index') !!}"
        var rotaStoreJobs = "{!! route('jobs.store') !!}"
        var rotaUpdateJobs = "{!! route('jobs.update') !!}"

	</script>
    <script src="{{ asset('js/job/index.js') }}"></script>
    <script>
   
    </script>
@endsection