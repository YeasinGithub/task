$(function(){
  $("#student").submit(function(e){
  alert('ok');
   e.preventDefault();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

      $.ajax({
        url: '/student/result/save',
        type: "POST",
        data: $('#student').serialize(),
        success: (response) => {
      location.reload();
        },
      });
  });


      function kgtotalfind(){
        var sum = 0;
          $('.achieve_number').each(function()
          {
           var valu=0;
      if($(this).val()=='' || isNaN($(this).val())){
            valu=0;
      }
      else{
        valu=$(this).val();
      }
              sum += parseFloat(valu);
          });
          /*alert(sum);*/
            $('#kg').val(sum);

      }

          function escapeHtml(unsafe) {


                return unsafe.toString()
                    .replace(/&/g, "&amp")
                    .replace(/</g, "&lt")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot")
                    .replace(/'/g, "&#039")
                    .replace(/\n/g, ' ');
            }

      $(document).on("keyup", ".achieve_number", function(arg){

            var id=$(this).attr('id');
            var number=id.split('achieve_number')[1];
            var achieve_number=$('#achieve_number'+number).val();
            

      if(achieve_number=='' || isNaN(achieve_number)){
           $('#kg'+number).val(0);
      }
      else{
       /*var total=Number(achieve_number) * Number(total_number);
            $('#total_taka'+number).val(total);*/
      }
           
            kgtotalfind();
        
        });



//add new input field, and remove input field
$(document).ready(function(){
  var i = 0;
$('#add_new').click(function(){
  /*alert('ok');*/
  ++i;

  $('#mainbody').append('<tr><td><select class="form-control" id="subject_id"  name="addmore[0][subject_id]"><option'+
    'disabled="disabled" selected="selected">select subject</option>'+
    '@foreach($subjects as $subject)' +
                    '<option value="{{ $subject->id }} "> '{{$subject->subject_name}}'</option>' +
                    '@endforeach' +

    '</select></td><td><input class="achieve_number col-sm col-form-label" type="text" name="addmore['+i+'][achieve_number]" id="achieve_number'+i+'" required ></td><td><button type="button" name="remove" id="remove" value="remove" class="btn btn-sm btn-danger">remove</button></td></tr>');

  $('#mainbody').on('click', '#remove', function(){
      $(this).closest('tr').remove();
      kgtotalfind();
  });




});

});




});//all top