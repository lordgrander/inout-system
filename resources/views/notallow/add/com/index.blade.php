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
    td
    { 
        padding:2px 0px 0px 2px!important;
    }
    button
    {
        font-size:14px!important;
        padding:5px!important;
    }
    p
  {
    padding:0px!important;
    margin:4px!important;
  }
</style> 
    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p> 
        </div>
    </div>
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">  
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-4 md:grid-cols-4">
                    <div class="p-2">
                        <div class="d-flex justify-content-between items-center" style="gap:10px;"> 
                             @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5') 
                                <input type="text" class="form-control" id="name" placeholder="ຊື່ບໍລິສັດ">  <br>
                                <input type="text" class="form-control" id="owner_name" placeholder="ຊື່ເຈົ້າຂອງບໍລິສັດ"> <br>
                                <input type="text" class="form-control" id="owner_phone" placeholder="ເບີໂທບໍລິສັດ">  
                                <button class="btn btn-primary" id="add_new">ເພີ່ມ</button>
                            @endif
                        </div> 
                    </div> 
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
                    <div class="p-2">
                        <div class=" items-center">

                            <!-- <form action="{{ route('com.search') }}" method="GET">
                                @csrf
                                <input type="text" class="form-control text_search" name="text_search" placeholder="ຄົ້ນຫາດ້ວຍຊື່ ບໍລິສັດ ຫຼື ເຈົ້າຂອງ ຫຼື ເບີໂທ"> 
                            </form> -->

                            <input
                                type="text"
                                class="form-control text_search"
                                placeholder="ຄົ້ນຫາດ້ວຍຊື່ ບໍລິສັດ ຫຼື ເຈົ້າຂອງ ຫຼື ເບີໂທ"
                                />

                                <div class="mt-2" id="searchMeta" style="font-size:12px; opacity:.7;"></div>
                            <br>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">ບໍລິສັດ</th>
                                    <th class="text-center">ເຈົ້າຂອງ</th>
                                    <th class="text-center">ເບີໂທ</th>
                                    <th class="text-center">ໂຄຕ້າ</th>
                                    <th class="text-center"></th>
                                    <th class="text-center">ບ່ອນອີງ</th>
                                    <th class="text-center">ແກ້ໄຂ</th>
                                    <th class="text-center">ລຶບ</th>
                                </tr>
                                <tbody id="build">
                                    @php($count = ($beta_company_group->currentPage() - 1) * $beta_company_group->perPage() + 1)
                                    @foreach ($beta_company_group as $row)
                                        <tr id="display_{{ $row->com_id }}" style="display:">
                                            <td width="2%" class="text-center">{{ $count }}</td>
                                            <td>
                                                <a href="{{ url('/add/com/'. $row->com_id .'/user') }}" style="color:blue;"><p id="display_name_{{ $row->com_id }}" data-name="{{ $row->com_name }}">{{ $row->com_name }}</p> </a>
                                            </td>
                                            <td>
                                                <p id="display_owner_name_{{ $row->com_id }}" data-name="{{ $row->com_owner }}">{{ $row->com_owner }}</p> 
                                            </td>
                                            <td class="text-right">
                                                <p id="display_owner_phone_{{ $row->com_id }}" data-name="{{ $row->com_phone }}">{{ $row->com_phone }}&nbsp;&nbsp;&nbsp;</p> 
                                            </td>
                                            <td class="text-center">
                                                <button class="{{ $row->com_id }} change_status btn @if($row->com_status=='YES') btn-primary @else btn-danger @endif" data-now="{{ $row->com_status }}" data-id="{{ $row->com_id }}" data-name="{{ $row->com_phone  }}">
                                                    @if($row->com_status=='YES')
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-flash-outline eva-animation eva-icon-hover-zoom" fill="white"><g data-name="Layer 2"><g data-name="flash"><rect width="24" height="24" opacity="0"></rect><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44zM6.87 12.8H12a1 1 0 0 1 .74.33 1 1 0 0 1 .25.78l-.45 4.15 4.59-6.86H12a1 1 0 0 1-1-1.11l.45-4.15z"></path></g></g></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-flash-off-outline eva-animation eva-icon-hover-zoom" fill="white"><g data-name="Layer 2"><g data-name="flash-off"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-16-16a1 1 0 0 0-1.42 1.42l16 16a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path><path d="M12.54 18.06l.27-2.42L10 12.8H6.87l1.24-1.86L6.67 9.5l-2.5 3.74A1 1 0 0 0 5 14.8h5.89l-.77 7.09a1 1 0 0 0 .65 1.05 1 1 0 0 0 .34.06 1 1 0 0 0 .83-.44l3.12-4.67-1.44-1.44z"></path><path d="M11.46 5.94l-.27 2.42L14 11.2h3.1l-1.24 1.86 1.44 1.44 2.5-3.74A1 1 0 0 0 19 9.2h-5.89l.77-7.09a1 1 0 0 0-.65-1 1 1 0 0 0-1.17.38L8.94 6.11l1.44 1.44z"></path></g></g></svg>
                                                    @endif
                                                </button> 
                                            </td>
                                            <td class="text-center"> 
                                                @if($row->com_status=='YES') 
                                                    <a href="{{ route('view.quotar.list', $row->com_id) }}"><button class="btn btn-primary">ເບີ່ງ Quotar</button></a> 
                                                @else 
                                                @endif 
                                            </td>
                                            <td class="text-center">
                                                <button class="view_subject btn  " id="{{ $row->com_id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-flag-outline eva-animation eva-icon-hover-zoom" fill="blue"><g data-name="Layer 2"><g data-name="flag"><polyline points="24 24 0 24 0 0" opacity="0"></polyline><path d="M19.27 4.68a1.79 1.79 0 0 0-1.6-.25 7.53 7.53 0 0 1-2.17.28 8.54 8.54 0 0 1-3.13-.78A10.15 10.15 0 0 0 8.5 3c-2.89 0-4 1-4.2 1.14a1 1 0 0 0-.3.72V20a1 1 0 0 0 2 0v-4.3a6.28 6.28 0 0 1 2.5-.41 8.54 8.54 0 0 1 3.13.78 10.15 10.15 0 0 0 3.87.93 7.66 7.66 0 0 0 3.5-.7 1.74 1.74 0 0 0 1-1.55V6.11a1.77 1.77 0 0 0-.73-1.43zM18 14.59a6.32 6.32 0 0 1-2.5.41 8.36 8.36 0 0 1-3.13-.79 10.34 10.34 0 0 0-3.87-.92 9.51 9.51 0 0 0-2.5.29V5.42A6.13 6.13 0 0 1 8.5 5a8.36 8.36 0 0 1 3.13.79 10.34 10.34 0 0 0 3.87.92 9.41 9.41 0 0 0 2.5-.3z"></path></g></g></svg>
                                                </button>
                                            </td>
                                            <td class="text-center" width="5%"><button data-index="{{ $row->com_id }}"  class="edit btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-settings-outline" fill="blue"><g data-name="Layer 2"><g data-name="settings"><rect width="24" height="24" opacity="0"></rect><path d="M8.61 22a2.25 2.25 0 0 1-1.35-.46L5.19 20a2.37 2.37 0 0 1-.49-3.22 2.06 2.06 0 0 0 .23-1.86l-.06-.16a1.83 1.83 0 0 0-1.12-1.22h-.16a2.34 2.34 0 0 1-1.48-2.94L2.93 8a2.18 2.18 0 0 1 1.12-1.41 2.14 2.14 0 0 1 1.68-.12 1.93 1.93 0 0 0 1.78-.29l.13-.1a1.94 1.94 0 0 0 .73-1.51v-.24A2.32 2.32 0 0 1 10.66 2h2.55a2.26 2.26 0 0 1 1.6.67 2.37 2.37 0 0 1 .68 1.68v.28a1.76 1.76 0 0 0 .69 1.43l.11.08a1.74 1.74 0 0 0 1.59.26l.34-.11A2.26 2.26 0 0 1 21.1 7.8l.79 2.52a2.36 2.36 0 0 1-1.46 2.93l-.2.07A1.89 1.89 0 0 0 19 14.6a2 2 0 0 0 .25 1.65l.26.38a2.38 2.38 0 0 1-.5 3.23L17 21.41a2.24 2.24 0 0 1-3.22-.53l-.12-.17a1.75 1.75 0 0 0-1.5-.78 1.8 1.8 0 0 0-1.43.77l-.23.33A2.25 2.25 0 0 1 9 22a2 2 0 0 1-.39 0zM4.4 11.62a3.83 3.83 0 0 1 2.38 2.5v.12a4 4 0 0 1-.46 3.62.38.38 0 0 0 0 .51L8.47 20a.25.25 0 0 0 .37-.07l.23-.33a3.77 3.77 0 0 1 6.2 0l.12.18a.3.3 0 0 0 .18.12.25.25 0 0 0 .19-.05l2.06-1.56a.36.36 0 0 0 .07-.49l-.26-.38A4 4 0 0 1 17.1 14a3.92 3.92 0 0 1 2.49-2.61l.2-.07a.34.34 0 0 0 .19-.44l-.78-2.49a.35.35 0 0 0-.2-.19.21.21 0 0 0-.19 0l-.34.11a3.74 3.74 0 0 1-3.43-.57L15 7.65a3.76 3.76 0 0 1-1.49-3v-.31a.37.37 0 0 0-.1-.26.31.31 0 0 0-.21-.08h-2.54a.31.31 0 0 0-.29.33v.25a3.9 3.9 0 0 1-1.52 3.09l-.13.1a3.91 3.91 0 0 1-3.63.59.22.22 0 0 0-.14 0 .28.28 0 0 0-.12.15L4 11.12a.36.36 0 0 0 .22.45z" data-name="&lt;Group&gt;"></path><path d="M12 15.5a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5zm0-5a1.5 1.5 0 1 0 1.5 1.5 1.5 1.5 0 0 0-1.5-1.5z"></path></g></g></svg>
                                            </button></td>
                                            <td class="text-center" width="5%"><button data-index="{{ $row->com_id }}"  class="btn_del btn    text-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" class="eva eva-close-circle-outline" fill="red"><g data-name="Layer 2"><g data-name="close-circle"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M14.71 9.29a1 1 0 0 0-1.42 0L12 10.59l-1.29-1.3a1 1 0 0 0-1.42 1.42l1.3 1.29-1.3 1.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l1.29-1.3 1.29 1.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42L13.41 12l1.3-1.29a1 1 0 0 0 0-1.42z"></path></g></g></svg>
                                            </button></td>
                                        </tr>

                                        <tr id="input_{{ $row->com_id }}" style="display:none;">
                                            <td width="1%">{{ $count++ }}</td>
                                            <td> 
                                                <input type="text" id="input_name_{{ $row->com_id }}" value="{{ $row->com_name }}" class="form-control" autocomplete="off">
                                            </td> 
                                            <td> 
                                                <input type="text" id="input_owner_name_{{ $row->com_id }}" value="{{ $row->com_owner }}" class="form-control" autocomplete="off">
                                            </td>
                                            <td> 
                                                <input type="text" id="input_owner_phone_{{ $row->com_id }}" value="{{ $row->com_phone }}" class="form-control" autocomplete="off">
                                            </td>
                                            <td width="5%"><button data-index="{{ $row->com_id }}"  class="edit_save btn  btn-outline-dark" style="color:lime;">ແກ້ໄຂ</button></td>
                                            <td width="5%"><button data-index="{{ $row->com_id }}"  class="edit_cancel btn  btn-outline-dark " style="color:red;">ຍົກເລີກ</button></td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>

                        <div class="ml-12" id="pagingBox">
                            <div class="mt-2 text-sm text-gray-500">
                                {{ $beta_company_group->links('pagination.custome-pagination') }}
                            </div>
                        </div>
                    </div>  
                </div> 
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    var name = '';
    var owner_name = '';
    $('#build').on('click','.edit', function (e) {

        let index = $(this).attr("data-index"); 

        $("#display_"+index).css("display", "none");
        $("#input_"+index).css("display", "");
  
        $('#input_name_'+ index).focus().select();
 
    });


    $('#build').on('click','.edit_cancel', function (e) {
        let index = $(this).attr("data-index"); 
        let name = $('#display_name_'+index).attr('data-name');
        let owner_name = $('#display_owner_name_'+index).attr('data-name');
        let come_phone = $('#display_owner_phone_'+index).attr('data-name');

        $('#display_name_'+index).html(name);  
        $('#display_owner_name_'+index).html(owner_name);  
        $('#display_owner_phone_'+index).html(come_phone);  

        $('#input_name_'+index).val(name); 
        $('#input_owner_name_'+index).val(owner_name); 
        $('#input_owner_phone_'+index).val(come_phone); 
        

        $("#input_"+index).css("display", "none");
        $("#display_"+index).css("display", "");
 

    });


    $('#build').on('click', '.view_subject', function (e) {
        let id = $(this).attr('id');
        let box = null;

        Swal.fire({
            title: "ຈັດການບ່ອນອີງ", 
            html: `
            <div class="d-flex justify-content-center">
                <div >
                    <textarea placeholder='ປ້ອນບ່ອນອີງ' id="text_subject" style="font-size:15px;"></textarea> 
                </div>
                &nbsp;&nbsp;
                <button class="btn btn-primary add-subject" id='${id}' style="height:30px;">ເພີ່ມ</button>
            </div>
                
                
                <table class="table table-bordered mt-2">
                <tbody id="display_subject_${id}"></tbody>
                </table>
            `,
            width: '50%',
            showCloseButton: false,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: ` ປິດ`
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let data = {
            id : id
        }
        $.ajax({
            type:"post",
            url:"{{ route('com.subject.list') }}",
            data:(data),
            dataType:"json", 
            success: function(response){ 
                const $tbody = $(`#display_subject_${id}`);
                $tbody.empty();

                if (response.status !== 200) {
                    $tbody.append(`<tr><td colspan="3">Not found</td></tr>`);
                    return;
                }

                let data = response.data;

                // If controller returned a single object, normalize to array
                if (!Array.isArray(data)) {
                    data = data ? [data] : [];
                }

                if (data.length === 0) {
                    $tbody.append(`<tr><td colspan="3">No subjects</td></tr>`);
                    return;
                }

                let rows = '';
                let count = 1;

                data.forEach(item => {
                    // adjust field names to your real columns
                    rows += `
                    <tr id="row_${item.id}">
                        <td width="2%">${count++}</td>
                        <td>${item.subject ?? ''}</td>
                        <td width="1%">
                            <button class="delete_subject btn  btn-outline-danger" data-delete="${item.id}" data-id="${item.com_id}" style="padding:5px!important;">X</button>
                        </td>
                    </tr>
                    `;
                });

                $tbody.append(rows);
            },
            complete: function() { 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if(errorThrown=='Payload Too Large')
                {  
                    return false;
                }
            }
        });
    });

    $('#build').on('click', '.change_status', function (e) {  
        let now = $(this).attr('data-now');
        let id = $(this).attr('data-id'); 

        var str = 'ຕ້ອງການປ່ຽນໃຫ້ນຳໃຊ້ Quotar ແມ່ນບໍ່?';
        if(now=='NO')
        {
            str = 'ຕ້ອງການຍົກເລີກ Quotar ແມ່ນບໍ່?';
        }

        if(confirm(str))
        {
            
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let data = {
                        id : id
                    }

                    $.ajax({
                        type:"post",
                        url:"{{ route('com.change.quotar') }}",
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
    $('#build').on('click','.edit_save', function (e) {
    
        let index = $(this).attr("data-index"); 
        let name  = $('#display_name_'+index).attr('data-name');        
        let owner_name = $('#display_owner_name_'+index).attr('data-name');
        let come_phone = $('#display_owner_phone_'+index).attr('data-name');



        let name_edit = $('#input_name_'+index).val(); 
        let owner_name_edit = $('#input_owner_name_'+index).val(); 
        let owner_phone_edit = $('#input_owner_phone_'+index).val(); 

        $('#display_name_'+index).html(name_edit);  
        $('#display_owner_name_'+index).html(owner_name_edit);  
        $('#display_owner_phone_'+index).html(owner_phone_edit);  

        $("#input_"+index).css("display", "none");
        $("#display_"+index).css("display", "");

        let msg = 'Update succesfully !';

        e.preventDefault();   
        var data = {
                        "id" : index, 
                        "name_edit" : name_edit,
                        "owner_name_edit" : owner_name_edit,
                        "owner_phone_edit" : owner_phone_edit,
                        "name_old" : name,
                    }

 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/com/update",
                        data:(data),
                        dataType:"json", 
                        success: function(response){ 
                            // console.log(response.message)  
                            // window.location.reload(); 
                            $('#display_name_'+index).attr('data-name',name_edit);
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
    })




    $('#build').on('click','.btn_del', function (e) {
    
        var result = confirm("Do you want to proceed?");
    if (result != true) {
        return false
    }
    let index = $(this).attr("data-index");  
    e.preventDefault();   
    var data = {
                    "id" : index, 
                }


    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:"post",
                    url:"/add/com/del",
                    data:(data),
                    dataType:"json", 
                    success: function(response){ 
                        // console.log(response.message)  
                        window.location.reload(); 
                      
                    },
                    complete: function() {
                        // me.data('requestRunning', false);
                        window.location.reload(); 
                         
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if(errorThrown=='Payload Too Large')
                        { 
                            // let dumx = "ຂະໜາດ File ລວມ ມີຂະໜາດເກີນ 1.5Mb"; 
                            return false;
                        }
                    }
                })
})

    $('#add_new').on('click', function (e) {     
        $('#add_new').prop('disabled', true); 
        
        e.preventDefault();   
        var data = {
                        "name" : $('#name').val(),  
                        "owner_name" : $('#owner_name').val(),  
                        "owner_phone" : $('#owner_phone').val(),  
                    } 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/com/store",
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
    })

   

    function validateSQL(str) {
        // remove potentially harmful characters using a regular expression
        str = str.replace(/[^a-zA-Z0-9ก-๙ກ-໛\s]/gi, '');
        // return the sanitized string
        return str;
    }

    function showAlert(msg) {
        // Create the link
        var link = document.createElement("a");
        link.href = "https://www.example.com";
        link.innerHTML = "Click here to visit example.com";

        // Add the link to the alert message
        var message = "Please click on the link: " + link.outerHTML;
        $('.display_msg').html(msg);
        $("#modal").css("display", "block");
    }
 
    $(document).on("click",".add-subject",function() {
        const id = $(this).attr('id');
        const text_subject = $('#text_subject').val()?.trim();
        if (!text_subject) return;

        $.ajax({
            type: "post",
            url: "{{ route('com.subject.add') }}",
            data: { id, text_subject },
            dataType: "json",
            success: function (response) {
            // accept 200 or 201
            if (String(response.status) !== '200' && String(response.status) !== '201') {
                toast('Could not add subject'); // optional
                return;
            }

            $('#text_subject').val("");

            // Prefer the item payload { id, subject }
            const item = Array.isArray(response.data) ? response.data[0] : response.data;
            if (!item) return;

            const $container = $(Swal.getHtmlContainer());
            const $tbody = $container.find(`#display_subject_${id}`);
           

            // compute next index based on existing rows
            const nextIndex = $tbody.find('tr').length + 1;


            const row = `
                <tr id="row_${response.delete}">
                <td width="2%">${nextIndex}</td>
                <td>${text_subject}</td>
                <td width="1%">
                    <button class="delete_subject btn btn-outline-danger" data-delete="${response.delete}" data-id="${response.id}" style="padding:5px!important;">X</button>
                </td>
                </tr>
            `;

            $tbody.append(row);
            $('#text_subject').val(''); // clear input
            },
            error: function(_, __, err) {
            console.error(err);
            }
        });
    });

    $(document).on("click",".delete_subject",function(){
        let id = $(this).attr('data-id');
        let deletex = $(this).attr('data-delete');


        $.ajax({
            type: "post",
            url: "{{ route('com.subject.delete') }}",
            data: { id, deletex },
            dataType: "json",
            success: function (response) {
             $('#row_'+deletex).fadeOut('slow');
            },
            error: function(_, __, err) {
            console.error(err);
            }
        });
    });



    $(document).ready(function() {
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


    (function () {
  const $input = $('.text_search');
  const $tbody = $('#build');
  const $paging = $('#pagingBox');
  const $meta = $('#searchMeta');

  let timer = null;
  let lastXhr = null;

  // Debounce helper (so it doesn't spam server every keystroke)
  function debounce(fn, wait) {
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => fn.apply(this, args), wait);
    };
  }

  function escapeHtml(str) {
    return String(str ?? '')
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  function buildRow(item, index) {
    const id = item.com_id;
    const name = escapeHtml(item.com_name);
    const owner = escapeHtml(item.com_owner);
    const phone = escapeHtml(item.com_phone);
    const status = (item.com_status || 'NO').toUpperCase();

    const statusBtnClass = status === 'YES' ? 'btn-primary' : 'btn-danger';
    const quotarBtn = status === 'YES'
      ? `<a href="/quotar/list/${id}"><button class="btn btn-primary">ເບີ່ງ Quotar</button></a>`
      : ``;

    return `
      <tr id="display_${id}">
        <td width="2%" class="text-center">${index}</td>
        <td>
          <a href="/add/com/${id}/user" style="color:blue;">
            <p id="display_name_${id}" data-name="${name}">${name}</p>
          </a>
        </td>
        <td>
          <p id="display_owner_name_${id}" data-name="${owner}">${owner}</p>
        </td>
        <td class="text-right">
          <p id="display_owner_phone_${id}" data-name="${phone}">${phone}&nbsp;&nbsp;&nbsp;</p>
        </td>

        <td class="text-center">
          <button
            class="${id} change_status btn ${statusBtnClass}"
            data-now="${status}"
            data-id="${id}"
            data-name="${phone}"
          >
            ${status === 'YES'
              ? `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44z"/></svg>`
              : `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M20.71 19.29l-16-16a1 1 0 0 0-1.42 1.42l16 16a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"/><path d="M12.54 18.06l.27-2.42L10 12.8H6.87l1.24-1.86L6.67 9.5l-2.5 3.74A1 1 0 0 0 5 14.8h5.89l-.77 7.09a1 1 0 0 0 .65 1.05 1 1 0 0 0 .34.06 1 1 0 0 0 .83-.44l3.12-4.67-1.44-1.44z"/></svg>`
            }
          </button>
        </td>

        <td class="text-center">${quotarBtn}</td>

        <td class="text-center">
          <button class="view_subject btn" id="${id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="blue"><path d="M19.27 4.68a1.79 1.79 0 0 0-1.6-.25 7.53 7.53 0 0 1-2.17.28 8.54 8.54 0 0 1-3.13-.78A10.15 10.15 0 0 0 8.5 3c-2.89 0-4 1-4.2 1.14a1 1 0 0 0-.3.72V20a1 1 0 0 0 2 0v-4.3a6.28 6.28 0 0 1 2.5-.41 8.54 8.54 0 0 1 3.13.78 10.15 10.15 0 0 0 3.87.93 7.66 7.66 0 0 0 3.5-.7 1.74 1.74 0 0 0 1-1.55V6.11a1.77 1.77 0 0 0-.73-1.43z"/></svg>
          </button>
        </td>

        <td class="text-center" width="5%">
          <button data-index="${id}" class="edit btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="blue"><path d="M8.61 22a2.25 2.25 0 0 1-1.35-.46L5.19 20a2.37 2.37 0 0 1-.49-3.22 2.06 2.06 0 0 0 .23-1.86l-.06-.16a1.83 1.83 0 0 0-1.12-1.22h-.16a2.34 2.34 0 0 1-1.48-2.94L2.93 8a2.18 2.18 0 0 1 1.12-1.41 2.14 2.14 0 0 1 1.68-.12 1.93 1.93 0 0 0 1.78-.29l.13-.1a1.94 1.94 0 0 0 .73-1.51v-.24A2.32 2.32 0 0 1 10.66 2h2.55a2.26 2.26 0 0 1 1.6.67 2.37 2.37 0 0 1 .68 1.68v.28a1.76 1.76 0 0 0 .69 1.43l.11.08a1.74 1.74 0 0 0 1.59.26l.34-.11A2.26 2.26 0 0 1 21.1 7.8l.79 2.52a2.36 2.36 0 0 1-1.46 2.93l-.2.07A1.89 1.89 0 0 0 19 14.6a2 2 0 0 0 .25 1.65l.26.38a2.38 2.38 0 0 1-.5 3.23L17 21.41a2.24 2.24 0 0 1-3.22-.53l-.12-.17a1.75 1.75 0 0 0-1.5-.78 1.8 1.8 0 0 0-1.43.77l-.23.33A2.25 2.25 0 0 1 9 22z"/></svg>
          </button>
        </td>

        <td class="text-center" width="5%">
          <button data-index="${id}" class="btn_del btn text-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="red"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M14.71 9.29a1 1 0 0 0-1.42 0L12 10.59l-1.29-1.3a1 1 0 0 0-1.42 1.42l1.3 1.29-1.3 1.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l1.29-1.3 1.29 1.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42L13.41 12l1.3-1.29a1 1 0 0 0 0-1.42z"/></svg>
          </button>
        </td>
      </tr>

      <tr id="input_${id}" style="display:none;">
        <td width="1%">${index}</td>
        <td><input type="text" id="input_name_${id}" value="${name}" class="form-control" autocomplete="off"></td>
        <td><input type="text" id="input_owner_name_${id}" value="${owner}" class="form-control" autocomplete="off"></td>
        <td><input type="text" id="input_owner_phone_${id}" value="${phone}" class="form-control" autocomplete="off"></td>
        <td width="5%"><button data-index="${id}" class="edit_save btn btn-outline-dark" style="color:lime;">ແກ້ໄຂ</button></td>
        <td width="5%"><button data-index="${id}" class="edit_cancel btn btn-outline-dark" style="color:red;">ຍົກເລີກ</button></td>
      </tr>
    `;
  }

  function render(items) {
    if (!items || items.length === 0) {
      $tbody.html(`<tr><td colspan="9" class="text-center">No results</td></tr>`);
      return;
    }
    let html = '';
    let i = 1;
    items.forEach(item => { html += buildRow(item, i++); });
    $tbody.html(html);
  }

  const runSearch = debounce(function () {
    const q = ($input.val() || '').trim();

    // show/hide pagination
    if (q.length > 0) $paging.hide();
    else $paging.show();

    // abort previous request
    if (lastXhr) lastXhr.abort();

    $meta.text(q ? 'Searching…' : '');

    lastXhr = $.ajax({
      type: "GET",
      url: "{{ route('com.search.json') }}",
      data: { q },
      dataType: "json",
      success: function (res) {
        if (!res || res.ok !== true) {
          $tbody.html(`<tr><td colspan="9" class="text-center">Error</td></tr>`);
          return;
        }
        render(res.items);
        $meta.text(q ? `Found ${res.items.length} result(s)` : '');
      },
      error: function (xhr) {
        if (xhr.statusText === 'abort') return;
        $tbody.html(`<tr><td colspan="9" class="text-center">Request failed</td></tr>`);
      }
    });
  }, 250);

  // live typing
  $input.on('input', runSearch);

  // bonus: press ESC to clear search and restore paging
  $input.on('keydown', function (e) {
    if (e.key === 'Escape') {
      $input.val('');
      $meta.text('');
      $paging.show();
      // optional: reload page to restore original paginated dataset
      // window.location.reload();
    }
  });
})();
</script>
</x-app-layout>
