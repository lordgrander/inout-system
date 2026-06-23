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
 
    <div id="modal">
        <div id="modal-content">
            <p class="laob display_msg"></p> 
        </div>
    </div>
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
     

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class=" items-center"> 
                                <input type="text" class="form-control" id="name"> 
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div> 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                        <button class="btn btn-outline-dark" id="add_new">save</button>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                               
                            </div> 
                        </div>
                    </div>  
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
                    <div class="p-6">
                        <div class=" items-center">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No.</td>
                                    <td>Name</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tbody id="build">
                                    @php($count=1)
                                    @foreach ($beta_main_road as $row)
                                        <tr id="display_{{ $row->main_road_id }}" style="display:">
                                            <td width="1%">{{ $count }}</td>
                                            <td>
                                                <p id="display_name_{{ $row->main_road_id }}" data-name="{{ $row->main_road_name }}">{{ $row->main_road_name }}</p> 
                                            </td>
                                            <td width="5%"><button data-index="{{ $row->main_road_id }}"  class="edit btn btn-outline-dark" >Edit</button></td>
                                            <td width="5%"><button data-index="{{ $row->main_road_id }}"  class="btn_del btn btn-outline-dark text-danger">Delete</button></td>
                                        </tr>

                                        <tr id="input_{{ $row->main_road_id }}" style="display:none;">
                                            <td width="1%">{{ $count++ }}</td>
                                            <td> 
                                                <input type="text" id="input_name_{{ $row->main_road_id }}" value="{{ $row->main_road_name }}" class="form-control" autocomplete="off">
                                            </td>
                                            <td width="5%"><button data-index="{{ $row->main_road_id }}"  class="edit_save btn btn-outline-dark" style="color:lime;">Update</button></td>
                                            <td width="5%"><button data-index="{{ $row->main_road_id }}"  class="edit_cancel btn btn-outline-dark " style="color:red;">Cancel</button></td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div> 
                        </div>
                    </div>  
                </div>

 
 
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>
    var name = '';
    $('#build').on('click','.edit', function (e) {

        let index = $(this).attr("data-index"); 

        $("#display_"+index).css("display", "none");
        $("#input_"+index).css("display", "");
  
        $('#input_name_'+ index).focus().select();
 
    });


    $('#build').on('click','.edit_cancel', function (e) {
        let index = $(this).attr("data-index"); 
        let name = $('#display_name_'+index).attr('data-name');

        $('#display_name_'+index).html(name);  

        $('#input_name_'+index).val(name); 
        
        $("#input_"+index).css("display", "none");
        $("#display_"+index).css("display", "");
 

    });


    $('#build').on('click','.edit_save', function (e) {
    
        let index = $(this).attr("data-index"); 
        let name  = $('#display_name_'+index).attr('data-name');


        let name_edit = $('#input_name_'+index).val(); 

        $('#display_name_'+index).html(name_edit);  

        $("#input_"+index).css("display", "none");
        $("#display_"+index).css("display", "");

        let msg = 'Update succesfully !';

        e.preventDefault();   
        var data = {
                        "id" : index, 
                        "name_edit" : name_edit,
                        "name_old" : name,
                    }

 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/mainroad/update",
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
                    url:"/add/mainroad/del",
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
                    } 
        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:"post",
                        url:"/add/mainroad/store",
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
</script>
</x-app-layout>
