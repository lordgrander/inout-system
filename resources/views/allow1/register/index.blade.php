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

                <select name="unit_id" id="edit_unit" name="edit_unit" class="form-control">
                    @foreach ($unit as $t)
                    <option value="{{ $t->id }}">&nbsp;&nbsp;{{ $t->name }}&nbsp;&nbsp;</option>
                    @endforeach
                </select>
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
                        <form action="{{ route('com.save.quatar.level2',$com_id) }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <div class="form-group">
                                    <select name="type_id" id="" class="form-control">
                                        @foreach ($type as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </div>&nbsp;
                                <div class="form-group"> 
                                    <select name="unit_id" id="" class="form-control">
                                        @foreach ($unit as $t)
                                        <option value="{{ $t->id }}">&nbsp;&nbsp;{{ $t->name }}&nbsp;&nbsp;</option>
                                        @endforeach
                                    </select>
                                </div>&nbsp;
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

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5 p-2">  
                    <table class="table table-bordered">

                             <tr> 
                                <th colspan="2">ລາຍການ</th>
                                <th class="text-center">ນຳເຂົ້າ</th>
                                <th class="text-center">ສົ່ງອອກ</th>
                                <th class="text-center">ຫົວໜ່ວຍ</th> 
                                <th colspan="2"></th> 
                            </tr> 
                        @foreach ($type as $t)
                            <tr>
                                <td width="25%" colspan="7" class="text-primary">{{ $t->name }}</td>
                            </tr> 
                            @foreach ($list as $l)
                                @if($l->pro_type_id==$t->id)
                                <tr>
                                    <td class=""></td>
                                    <td class="">
                                        <p class=" m-0 p-0">{{ $l->pro_name }}</p> 
                                        {{ date('d-m-Y',strtotime($l->lastupdated_at)) }} 
                                        <small>{{ date('H:i:s',strtotime($l->lastupdated_at)) }}</small>
                                    </td> 
                                    <td class=" text-right">{{ number_format($l->total_in) }}</td>
                                    <td class=" text-right">{{ number_format($l->total_out) }}</td>
                                    <td class=" text-center" width="1%">{{ $l->QuotarHaveUnit->name }}</td> 
                                    <td width="1%" class="text-center"><button class="btn btn-warning btn_edit"
                                                    data-name="{{ $l->pro_name }}"
                                                    data-type="{{ $l->pro_type_id }}"
                                                    data-unit="{{ $l->unit_id }}"
                                                    data-id="{{ $l->id }}"
                                                        >
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" style="fill:#0022ff;"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                                                    </button></td>
                                    
                                    <td width="1%" class="text-center">
                                        @if($l->total_in==0 || $l->total_in<0)
                                            @if($l->total_out==0 || $l->total_out<0)
                                                <button class="btn btn-danger btn_delete"  data-id="{{ $l->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" style="fill:#0022ff;"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                                </button>
                                            @else

                                            @endif
                                        @else
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
                        com_id : {{ $com_id }},
                    }

                    $.ajax({
                        type:"delete",
                        url:"{{ route('com.delete.quatar') }}",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            console.log(response.message)  
                            // window.location.reload();  
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
                        com_id : {{ $com_id }},
                    }

                    $.ajax({
                        type:"post",
                        url:"{{ route('com.edit.quatar.level2') }}",
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
