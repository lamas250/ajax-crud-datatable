$(document).ready(function(){
    $('#job_table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url: rotaListaJobs,
        },
        columns:[
            // { data: 'first_name', name: 'first_name', orderable: false },
            {
                render: function(data, type, row, meta)
                {
                    return row.first_name+' '+row.last_name;
                },
            },
            { data: 'job.job', name: 'job.job',"defaultContent": "---" },
            { data: 'job.detail', name: 'job.detail',"defaultContent": "---"},
            { data: 'action', name: 'action', orderable: false}
        ]
    });

    $('#create_record').click(function(){
        $('.modal-title').text("Add New Record");
        // $('#form_result').hide();
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#formModal').modal('show');
        $('#job').val('');
        $('#detail').val('');
        $('#user_id').val('');
        // $('#user_id').html('');
   });

   $('#sample_form').on('submit', function(event){
    event.preventDefault();
    if($('#action').val() == 'Add')
    {
     $.ajax({
      url: rotaStoreJobs,
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
        $('#job_table').DataTable().ajax.reload();
       }
       $('#form_result').html(html);
      }
     })
    }
   
    if($('#action').val() == "Edit")
    {
     $.ajax({
      url: rotaUpdateJobs,
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
        html = '<div class="alert alert-success" id="alert">' + data.success + '</div>';
        $('#sample_form')[0].reset();
        $('#job_table').DataTable().ajax.reload();
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
     url:"/jobs/"+id+"/edit",
     dataType:"json",
     success:function(html){
      $("#user_id").html($('<option></option>', {value: html.data.id, text: html.data.first_name}));
      $('#job').val(html.data.job.job);
      $('#detail').val(html.data.job.detail);
      $('#hidden_id').val(html.data.id);
      $('.modal-title').text("Edit New Record");
      $('#action_button').val("Edit");
      $('#action').val("Edit");
      $('#formModal').modal('show');
     }
    })
   });

var user_id;

$(document).on('click', '.delete', function(){
 user_id = $(this).attr('id');
 $('#confirmModal').modal('show');
});

$('#ok_button').click(function(){
 $.ajax({
    url:"job/destroy/"+user_id,
  beforeSend:function(){
   $('#ok_button').text('Deleting...');
  },
  success:function(data)
  {
   setTimeout(function(){
    $('#confirmModal').modal('hide');
    $('#job_table').DataTable().ajax.reload();
   }, 2000);
  }
 })
});

});
   
