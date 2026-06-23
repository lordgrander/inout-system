<x-app-layout>

<style>
    .btn-danger
    {
        background:#ff4859!important;
    }
</style>
<style>
  #modal {
    display: none; /* Hide the modal by default */
    position: fixed; /* Make the modal stay in the same spot */
    z-index: 1; /* Place the modal on top of everything else */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  #modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border-radius: 10px;
    border: #f46767 solid 3px;
    width: 80%; /* Could be more or less, depending on screen size */
  }

  #modal-close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  #modal-close:hover,
  #modal-close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
  
</style>
<style>
    a{
        text-decoration:none;
        color:black;
    }
    .btn-outline-dark:hover
    {
        background:#e9eaeb;
        color:black;
    }
</style>   
<div class="p-5">
    <center>

        <input type="text" class="form-control" id="watching_number" placeholder="ປ້ອນທະບຽນ" style="width:50%;" autocomplete="off"> 
        <table class="table table-bordered table-hover" style="width:50%;">
            @php($count=1)
            @foreach($watching_list AS $row)
                <tr id="row_{{ $row->id }}">
                    <td class="text-center" width="5%">{{ $count++ }}</td>
                    <td class="text-center">{{ $row->watching_normal }}</td>
                    <td class="text-center">{{ $row->watching_number }}</td>
                    <td width="15%" class="text-center">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                    <td width="5%">
                        <button class="btn btn-outline-danger btn-delete" id="{{ $row->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#EA3323"><path d="M0 0h24v24H0z" fill="none"/><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    </center>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>



    $(document).ready(function() {  
        $(document).on("click",".btn-delete",function(){
            let id = $(this).attr('id');    

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                type: "post",
                url: "{{ route('watching.delete') }}",
                data: { id },
                dataType: "json",
                success: function (response) {
                $('#row_'+id).fadeOut('slow');
                },
                error: function(_, __, err) {
                console.error(err);
                }
            });
        });

        $(document).on("keypress", "#watching_number", function (e) {
            // 1️⃣ Check if the pressed key is Enter
            if (e.which === 13 || e.key === "Enter") {
                e.preventDefault(); // prevent form submit (optional)

                // 2️⃣ Get the value
                let watching_number = $(this).val().trim();

                // 3️⃣ Optional: guard clause if empty
                if (!watching_number) return;

                // 4️⃣ Ajax call


                $.ajax({
                    type: "post",
                    url: "{{ route('watching.add') }}",
                    data: { watching_number },
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        // e.g. reload or update list dynamically
                        window.location.reload();
                    },
                    error: function (_, __, err) {
                        console.error("AJAX error:", err);
                    },
                });
            }
        });

    });
</script>
</x-app-layout>
