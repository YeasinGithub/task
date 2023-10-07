<!DOCTYPE html>
<html>
<head>
	<title>Student</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body><br>
<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            <div>
                <p>{{ Session::get('error') }}</p>
            </div>
        </div>
    @endif
	<div class="row">
		<div class="card">
			<form method="post" action="{{route('students.store')}}"   enctype="multipart/form-data">
				@csrf
				<h4 class="text-center">Student From</h4>
				<div class="form-group">
				<label for="exampleInputEmail1">Name</label>
				<input type="text" name="name" class="form-control" placeholder="Enter Name">
				</div><br>
				<div class="form-group">
				<label for="image">Image</label>
				<input type="file" class="form-control" name="image">
				</div>

                <br>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col " >Number</th>
                        <th scope="col"><button id="add_new" type="button" name="add_new" class="btn btn-sm btn-success"> +</button></th>
                    </tr>
                    </thead>
                    <tbody id="mainbody">

                    <tr>
                        <td>
                            <select class="form-control" id="subject_id"  name="addmore[0][subject_id]">
                                <option disabled="disabled" selected="selected">select subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                                @endforeach

                            </select>
                        </td>
                        <td>

                            <input class="achieve_number form-control" type="number" name="addmore[0][achieve_number]" id="achieve_number" required placeholder="Number">

                        </td>
                        <td></td>

                    </tr>
                    </tbody>





                </table>

				<button type="submit" class="btn btn-primary">Submit</button>  |
                <a href="{{route('students.index')}}" class="btn  btn-success">Back</a>

            </form>
		</div>
	</div>
</div>
<script type="text/javascript">

    $( document ).ready(function() {

        var i = 0;
        $('#add_new').click(function(){
            /*alert('ok');*/
            ++i;

            $('#mainbody').append('<tr><td><select required class="form-control" id="subject_id"  name="addmore['+i+'][subject_id]">'+

                '<option selected disabled  value="">Select subject</option>' +
                '@foreach($subjects as $subject)' +
                '<option value="{{ $subject->id }} "> {{$subject->subject_name}}</option>' +
                '@endforeach' +

                '</select></td><td><input class="achieve_number form-control" type="number" name="addmore['+i+'][achieve_number]" id="achieve_number'+i+'" required ></td><td><button type="button" name="remove" id="remove" value="remove" class="btn btn-sm btn-danger">remove</button></td></tr>');

            $('#mainbody').on('click', '#remove', function(){
                $(this).closest('tr').remove();

            });




        });

    });




</script>
</body>
</html>
