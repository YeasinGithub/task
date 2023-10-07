<!DOCTYPE html>
<html>
<head>
	<title>laravel crud</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
	<div class="container">

        @if (Session::has('success'))
            <div class="alert alert-success">
                <div>
                    <p>{{ Session::get('success') }}</p>
                </div>
            </div>
        @endif

		<div class="row">
			<div class="card">
				<a href="{{route('students.create')}}" class="btn btn-sm btn-success col-md-1">Add New</a><br>
				<table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Name</th>
				      <th scope="col">Image</th>
				      <th scope="col">achieve_number</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>

                  @foreach($students as $student)
                      <tr>
				      <td>{{$student->id}}</td>
				      <td>{{$student->name}}</td>


				      <td><img src="{{asset($student->image)}}" style="width: 100px; height: 60px;"></td>
                        <td>{{$student->result_sum_achieve_number}}</td>
                        <td>
				      	<a href="{{route('students.edit', $student->id)}}" class="btn btn-sm btn-success">Edit</a> |

                            <form action="{{ route('students.destroy',$student->id ) }}" method="POST" onsubmit="return confirm('{{ 'Are you sure to delete?' }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-danger btn-sm text-white" title="Delete" type="submit"> Delete</button>
                            </form>


                        </td>
				    </tr>
                  @endforeach

				  </tbody>
				</table>
                {!! $students->withQueryString()->links() !!}

            </div>
		</div>
	</div>
</body>
</html>
