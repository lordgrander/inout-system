<x-app-layout>
     
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
                    <div class="p-6">
                        <div class="flex items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <table>
                                    <tr>
                                        <td colspan="ເລືອກວັນທີເພື່ອລາຍງານ"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            ເລີ່ມ
                                            <input type="date" class="form-control" id="start">
                                        </td>
                                        <td>
                                            ຫາ
                                            <input type="date" class="form-control" id="end">
                                        </td>
                                        <td>&nbsp;.
                                            <button  class="btn btn-outline-dark report form-control">ລາຍງານ</button>
                                        </td>
                                    </tr>
                                </table>
                                
                                
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div> 
                </div>
 
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 mt-3">
                    <div class="p-6">
                        <div class="flex items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <table>
                                    <tr>
                                        <td colspan="ເລືອກວັນທີເພື່ອລາຍງານ"></td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            <input type="text" class="form-control" id="enter_number">
                                        </td> 
                                        <td> 
                                            <button  class="btn btn-outline-dark search form-control">ຄົ້ນຫາເລກທີ່</button>
                                        </td>
                                    </tr>
                                </table>
                                
                                
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div> 
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 mt-3">
                    <div class="p-6">
                        <div class="flex items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                <table>
                                    <tr>
                                        <td colspan="ເລືອກວັນທີເພື່ອລາຍງານ"></td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            <input type="text" class="form-control" id="start_enter_number">
                                        </td> 
                                        <td> 
                                            <input type="text" class="form-control" id="end_enter_number">
                                        </td> 
                                        <td> 
                                            <button  class="btn btn-outline-dark search_enter_number form-control">ກອງເລກທີ່</button>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <table class="table table-bordered" id="table-data">
                                    <thead>
                                        <tr>
                                            <th>ເລກທີ່</th>
                                            <th>ວັນທີ</th>
                                            <th>ເບີ່ງຂໍ້ມູນ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="build"></tbody>
                                </table>
                                
                                
                            </div>
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
 
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;
            var yyyy = today.getFullYear();

            if(dd<10) {
                dd='0'+dd
            } 

            if(mm<10) {
                mm='0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;
            $("input[type='date']").val(today); 

            $('.report').on('click',function(){
                let start = $('#start').val();
                let end   = $('#end').val();

                window.location.href = ('/report/'+start+'/'+end+'');
            })


            $('.search').on('click',function(){
                let enter_number = $('#enter_number').val();  
                window.location.href = ('/search/'+enter_number);
            })

            $('.search_enter_number').on('click',function(){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let data = {
                            'start' : $('#start_enter_number').val(),
                            'end'   : $('#end_enter_number').val() 
                }
                $.ajax({
                    url: '/fetch_search',
                    type: 'post',
                    data:(data),
                    dataType: 'json',
                    success: function(data) {
                        $("#build").empty();
                        $.each(data.data, function (key, value) {
                            var enter_id = value.enter_id;
                            $("#build").append('<tr>\
                                <td>'+value.enter_number+'</td>\
                                <td>'+value.date_make+'</td>\
                                <td><a href="{{ url("/see/enter/list/view") }}/'+ enter_id +'" target="_BLANK">View</a></td>\
                            </tr>');
                        });


                    }
                });
            })

            
        });
    </script>
</x-app-layout>
