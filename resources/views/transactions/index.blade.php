@extends("layouts.global")

@section("title") Transactions @endsection

@section("content")
<div class="col-md-8">
<h1>Transactions</h1><br>
    {{-- <a class="float-right btn btn-success" href="javascript:void(0)" id="addNewTransaction"> Add Transaction </a><br><br><br> --}}
    <table class="table data-transaction">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer Name</th>
                <th>Book Name</th>
                <th>Lending Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Total Price</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="transactionModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="transactionForm" name="transactionForm" class="form-horizontal">
                    @csrf
                   <input type="hidden" name="transaction_id" id="transaction_id">
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Transaction Id</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="transaction_id_show" name="transaction_id" value="" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">User Id</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="user_id" name="user_id" value="" disabled>
                    </div>
                </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Borrow Date</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="borrow_date" name="borrow_date" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Return Date</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="return_date" name="return_date" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_price" class="col-sm-3 control-label">Total Price</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="total_price" name="total_price" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="status" id="status">
                                <option value="BORROWED">BORROWED</option>
                                <option value="RETURNED">RETURNED</option>
                                <option value="CANCELED">CANCELED</option>
                                <option value="OVERDUE">OVERDUE</option>
                            </select>
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
    
    var table = $('.data-transaction').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('transactions.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , "defaultContent": ""},
            {data: 'user_name', name: 'user_name', "defaultContent": ""},
            {data: 'book_name', name: 'book_name', "defaultContent": ""},
            {data: 'borrow_date', name: 'borrow_date', "defaultContent": ""},
            {data: 'return_date', name: 'return_date', "defaultContent": ""},
            {data: 'status', name: 'status', "defaultContent": ""},
            {data: 'total_price', name: 'total_price', "defaultContent": ""},
            {data: 'action', name: 'action', orderable: false, searchable: false, "defaultContent": ""},
        ]
    });
    
    //edit
    $('body').on('click', '.editTransaction', function () {
      var transaction_id = $(this).data('id');
      $.get("{{ route('transactions.index') }}" +'/' + transaction_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Transaction");
          $('#submit').val("edit-transaction");
          $('#transactionModel').modal('show');
          $('#transaction_id').val(data.id);
          $('#transaction_id_show').val(data.id);
          $('#user_id').val(data.user_id);
          $('#borrow_date').val(data.borrow_date);
          $('#return_date').val(data.return_date);   
          $('#status').val(data.status); 
          $('#total_price').val(data.total_price);               
      })
   });
    
    //create
    $('#submit').click(function (e) {
        e.preventDefault();
    
        $.ajax({
          data: $('#transactionForm').serialize(),
          url: "{{ route('transactions.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#transactionForm').trigger("reset");
              $('#transactionModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });
    
    //delete
    $('body').on('click', '.deleteTransaction', function () {
     
        var transaction_id = $(this).data("id");
        confirm("Are you sure want to delete this transaction?");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('transactions.store') }}"+'/'+transaction_id,
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