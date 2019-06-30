@extends('layouts.global')

@section('title') Books @endsection 

@section('content')
<div class="col-md-8">
    <!-- @if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
    @endif  -->
    <h1>Books</h1>
    <a class="float-right btn btn-success" href="javascript:void(0)" id="addNewBook"> Add Book </a><br><br><br>
    <table class="table data-book">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="bookModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="bookForm" name="bookForm" class="form-horizontal">
                    @csrf
                   <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Author</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="author" name="author" placeholder="Enter Author" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Daily Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" value="" maxlength="50" required="">
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="submit" value="create">Submit
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function() {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-book').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('books.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , "defaultContent": ""},
            {data: 'title', name: 'title', "defaultContent": ""},
            {data: 'author', name: 'author', "defaultContent": ""},
            {data: 'price', name: 'price', "defaultContent": ""},
            {data: 'action', name: 'action', orderable: false, searchable: false, "defaultContent": ""},
        ]
    });
     
    $('#addNewBook').click(function () {
        $('#submit').val("create-book");
        $('#book_id').val('');
        $('#bookForm').trigger("reset");
        $('#modelHeading').html("Create New Book");
        $('#bookModel').modal('show');
    });
    
    //edit
    $('body').on('click', '.editUser', function () {
      var book_id = $(this).data('id');
      $.get("{{ route('books.index') }}" +'/' + book_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Book");
          $('#submit').val("edit-book");
          $('#bookModel').modal('show');
          $('#book_id').val(data.id);
          $('#title').val(data.title);
          $('#author').val(data.author);
          $('#price').val(data.price);       
      })
   });
    
    //create
    $('#submit').click(function (e) {
        e.preventDefault();
    
        $.ajax({
          data: $('#bookForm').serialize(),
          url: "{{ route('books.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#bookForm').trigger("reset");
              $('#bookModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });
    
    //delete
    $('body').on('click', '.deleteUser', function () {
     
        var user_id = $(this).data("id");
        confirm("Are you sure want to delete this user?");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('books.store') }}"+'/'+user_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>

@endsection