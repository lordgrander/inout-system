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
    border: blue solid 3px;
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
    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p> 
             
                <input type="text" class="form-control" id="edit_name" name="edit_name">
                <br>
                <select name="type_id" id="edit_type" name="edit_type" class="form-control">
                    @foreach ($type as $t)
                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
                <br>
<!-- 
                <select name="unit_id" id="edit_unit" name="edit_unit" class="form-control">
                    @foreach ($unit as $t)
                    <option value="{{ $t->id }}">&nbsp;&nbsp;{{ $t->name }}&nbsp;&nbsp;</option>
                    @endforeach
                </select> -->
<br><br><br>
                <button id="btn_start_edit" class="btn btn-primary w-100" data-id="">ແກ້ໄຂ</button>
            
        </div>
    </div>
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> 
                    <div class="">
                        <br>
                        <center>
                            <h4>ເພີ່ມລາຍການ</h4>
                        </center>
                        <form action="{{ route('com.save.quatar') }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <div class="form-group">
                                    <select name="type_id" id="" class="form-control">
                                        @foreach ($type as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </div>&nbsp;
                                <!-- <div class="form-group"> 
                                    <select name="unit_id" id="" class="form-control">
                                        @foreach ($unit as $t)
                                        <option value="{{ $t->id }}">&nbsp;&nbsp;{{ $t->name }}&nbsp;&nbsp;</option>
                                        @endforeach
                                    </select>
                                </div>&nbsp; -->
                                <div class="form-group">
                                    <input name="product_name" type="text" class="form-control" placeholder="ປ້ອນຊື່">
                                </div>
                                &nbsp;
                                <button class="btn btn-primary ">ບັນທຶກ</button>
                            </div>
                        </form>
                    </div>
                    <div class="m-5"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">  
                    <div class="p-4 border-bottom">
                        <form action="{{ route('view.quotar.export') }}" method="GET">
                            <div class="d-flex flex-wrap align-items-center">
                                <strong class="mr-3 mb-2">Export Excel:</strong>
                                <label class="mr-3 mb-2">
                                    <input type="checkbox" id="export_all_columns" checked>
                                    ເລືອກທັງໝົດ
                                </label>
                                <label class="mr-3 mb-2">
                                    <input type="checkbox" class="export-column" name="columns[]" value="id" checked>
                                    ID
                                </label>
                                <label class="mr-3 mb-2">
                                    <input type="checkbox" class="export-column" name="columns[]" value="name" checked>
                                    ລາຍການ
                                </label>
                                <label class="mr-3 mb-2">
                                    <input type="checkbox" class="export-column" name="columns[]" value="pro_type_id" checked>
                                    ລະຫັດປະເພດ
                                </label>
                                <label class="mr-3 mb-2">
                                    <input type="checkbox" class="export-column" name="columns[]" value="type_name" checked>
                                    ປະເພດ
                                </label>
                                <button type="submit" class="btn btn-success mb-2">ດາວໂຫຼດ</button>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered">

                             <tr>
                                <td></td>
                                <td>ລາຍການ</td> 
                            </tr> 
                        @foreach ($type as $t)
                            <tr>
                                <td width="25%" colspan="7">{{ $t->name }}</td>
                            </tr> 
                            @foreach ($list as $p)
                                @if($p->pro_type_id==$t->id)
                                <tr>
                                    <td class="text-primary"></td>
                                    <td class="text-primary">{{ $p->name }}</td>  
                                    <td width="1%"><button class="btn btn-warning btn_edit"
                                                    data-name="{{ $p->name }}"
                                                    data-type="{{ $p->pro_type_id }}" 
                                                    data-id="{{ $p->id }}" >ແກ້ໄຂ</button></td>
                                    <td width="1%">
                                        @if($t->total_in==0 || $t->total_in<0)
                                            @if($t->total_out==0 || $t->total_out<0)
                                                <button class="btn btn-danger btn_delete"  data-id="{{ $p->id }}">ລືບ</button>
                                            @endif
                                        @endif 
                                    </td>
                                </tr> 
                                @endif
                            @endforeach
                        @endforeach
                    </table>
                </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>
    


    $(document).ready(function() {
       
    });

    $(document).ready(function() {
        $('#export_all_columns').on('change', function () {
            $('.export-column').prop('checked', $(this).is(':checked'));
        });

        $('.export-column').on('change', function () {
            $('#export_all_columns').prop('checked', $('.export-column:not(:checked)').length === 0);
        });

        $('.btn_delete').on('click', function (e) {
            if(confirm('ລືບ?'))
            {
                let id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let data = {
                        id : id, 
                    }

                    $.ajax({
                        type:"delete",
                        url:"{{ route('com.delete.quatar') }}",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            window.location.reload();  
                        },
                        complete: function() {
                            // me.data('requestRunning', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(errorThrown=='Payload Too Large')
                            { 
                                // let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                                return false;
                            }
                        }
                    })
            }

        });
        $('#btn_start_edit').on('click', function (e) {

            let name = $('#edit_name').val();
            let type = $('#edit_type').val();
            let unit = $('#edit_unit').val();
            let id = $(this).attr('data-id');


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let data = {
                        id : id,
                        name : name,
                        type : type,
                        unit : unit, 
                    }

                    $.ajax({
                        type:"post",
                        url:"{{ route('com.edit.quatar') }}",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            window.location.reload();  
                        },
                        complete: function() {
                            // me.data('requestRunning', false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(errorThrown=='Payload Too Large')
                            { 
                                // let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                                return false;
                            }
                        }
                    })
        });
        $('.btn_edit').on('click', function (e) {
            $("#modal").css("display", "block");
            let name = $(this).attr('data-name');
            let type = $(this).attr('data-type');
            let unit = $(this).attr('data-unit');
            let id = $(this).attr('data-id');

            $('#edit_name').val(name); 
            $('#btn_start_edit').attr('data-id',id); 
            SelectElement("edit_type",    type);  
            SelectElement("edit_unit",    unit);   
        });
        // When the modal button is clicked 
        // When the user clicks anywhere outside of the modal, close it
        $(window).click(function(event) {
        if (event.target == $("#modal")[0]) {
            $("#modal").css("display", "none");
        }
        }); 
        // When the close button is clicked
        $("#modal-close").click(function() {
        // Hide the modal
        $("#modal").css("display", "none");
        });
    });


          function SelectElement(id, valueToSelect)
          {    
              var element = document.getElementById(id);
              element.value = valueToSelect;
          }

</script>
</x-app-layout>
