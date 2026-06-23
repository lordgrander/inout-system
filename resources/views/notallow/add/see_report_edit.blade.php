<x-app-layout> 
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
    <div class="py-1 laos">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-12 md:grid-cols-12"> 
                    @if(auth()->user()->is_admin=='5' || auth()->user()->is_admin=='3' )           
                        <center><br>
                            <h5>ລາຍງານສະຖິຕິລົດປະຈຳປີ </h5>
                            <select id="date_pick">
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="0">2025</option>
                            </select>
                            <div style="padding:10px 5px 5px 5px;">
                                <table class="table-bordered table-hover" style="width:50%;">
                                    <tr>
                                        <td class="text-center">ເດືອນ</td>
                                        <td class="text-center">ຈຳນວນຄັນ</td>
                                        <td class="text-center">ໝາຍເຫດ</td>
                                    </tr>
                                    @php($total=0)
                                    @foreach($select AS $r)
                                        <tr>
                                            <td class="text-center">{{ date('m',strtotime($r->created_at)) }}</td>
                                            <td style="text-align:right"><input type="text" value="{{ $r->total_unit }}" class="text_edit" data-id="{{ $r->id }}"> ຄັນ </td>
                                            <td></td>
                                        </tr> 
                                    @endforeach 
                                </table> 
                            </div>
                            <br><br>
                        </center>
                    @endif
                </div>
 
                
            </div>
        </div>
    </div> 
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
            $('#date_pick').change(function() {
                let start = $(this).val();
                window.location.href = '/supreme/report/edit/'+start;
            });
            $('.text_edit').change(function() {
                let id = $(this).attr('data-id');
                let val = $(this).val(); 
                
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                
                let formData = new FormData();
                formData.append('id', id);
                formData.append('val', val); 
     
                $.ajax({
                    url: '{{ route('Freport.update') }}', 
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) { 
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error if necessary
                    }
                });
            });
 SelectElement("date_pick",    "{{ $start }}");  

          function SelectElement(id, valueToSelect)
          {    
              var element = document.getElementById(id);
              element.value = valueToSelect;
          }
</script>
</x-app-layout>
