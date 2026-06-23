<x-app-layout>
    <!-- <link  rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> -->
    <style>
         
         .table_display_data
        {  
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important; 
        }
    </style>  
    <style>
        .murphy-pdf-shell{ cursor: grab; }
.murphy-panning{ cursor: grabbing; }
  .murphy-pdf-toolbar{
    display:flex;
    gap:8px;
    align-items:center;
    padding:8px;
    border-bottom:1px solid rgba(0,0,0,.12);
    background:#fff;
    position: sticky;
    top: 0;
    z-index: 2;
  }
  .murphy-pdf-shell{
    height: 70vh;
    overflow: auto;              /* ✅ must be scrollable */
    background: #111;
    -webkit-overflow-scrolling: touch; /* ✅ iOS smooth scroll */
    touch-action: pan-x pan-y;   /* ✅ allow finger panning */
    }
  .murphy-pdf-canvas{
    display:block;
    margin: 10px auto;
    background:#fff;
  }
  .murphy-pdf-btn{
    border:1px solid rgba(0,0,0,.2);
    padding:6px 10px;
    border-radius:10px;
    background:#fff;
    cursor:pointer;
    font-size:12px;
  }
  .murphy-pdf-meta{
    font-size:12px;
    opacity:.75;
  }
</style>
    <style>  
         /* .btn
         {
             border:3px solid!important;
         } */

         .btn-light
         { 
            width:100%;
           text-align:center;
         }
         .btn-light:hover
         {
            background:#ebebeb;
         }
         .table_display_data
        {  
            overflow-x: auto!important;
            /* overflow: auto!important; */
            white-space: nowrap!important; 
            transition: all .25s ease ;
        }
        .btn-outline-dark:hover
        {
            background:#fff!important;
            color:black!important;
        }
        

        .modal {
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

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border-radius: 10px;
            border: #cccccc solid 3px;
            width: 80%; /* Could be more or less, depending on screen size */
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }

        .modal-close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
        .checkbox-columns {
            column-count: 1;
            column-gap: 20px; /* Adjust as needed */
        }
        /* .dream
        { 
            box-shadow: inset 1px 3px 5px #000!important; 
            padding:15px 5px 5px 5px;
             
            border-radius:5px;
        } */

        .btn-outline-info 
        {
            border:solid 3px #1335a1;
            color:#1335a1;
        }

        .btn-outline-info:hover
        {
             background-color:#ebebeb!important; 
             color:#3434334;
             border:solid 3px #5b78d3;
        }



        .btn-outline-danger 
        {
            border:solid 3px #b82433!important;
            color:#b82433;
        }

        .btn-outline-danger:hover
        {
             background-color:#ffd745!important; 
            color:#b82433;
        }


        .sub_stable_font
        {
            font-family: noto_serif_laoregular,roboto!important;
            font-weight: normal;
            font-size:0.90em; 
        }

        .dataTables_length select
        {
            width:100px;
        }
        table        thead        tr        th
        {
            font-weight:normal!important;
            background:#eaeaea!important;
            
        }
         
    </style>

    <style>
        .xdropdown {
        position: relative;
        display: inline-block;
        }

        .xdropdown-content {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 8px 0px;
        border-radius:5px;
        }

        .xdropdown:hover .xdropdown-content {
            display: block;
        }  
        .info-jam {
        text-decoration: none;
        color: black;
        position: relative;
        }
    .info-jam:after {
        content: "";
        display: block;
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #0f42db;
        transform: scaleX(0);
        transform-origin: left;
        transition: all .25s ease;
    }
    .info-jam:hover:after {
        transform: scaleX(1);
    }
    .sub_table,.sub_table tr,.sub_table tr td
    {
        border:0px!important;
        background:white;
    }
    .dataTables_filter,.dataTables_length {
        float: right!important; 
    }
    .dataTables_length select{ 
        height:42px!important; 
        weight:120px!important; 
    }
    .white-thing
    {
       
    } 
    #table_data_display tbody tr td 
    {
        background:white!important;
    }
    .paginate_button
    {
        border:solid black 1px;
        border-radius:4px;
        padding:5px;
        cursor:pointer;
        color:black;
        margin:2px;
    }
    .dataTables_paginate
    {
        float: right!important;
    }
    .paginate_button:hover
    {
       color:#3434343;
    }
    .murphy-break-text{
        word-break: break-word;       /* normal breaking */
        overflow-wrap: anywhere;      /* force break long strings */
        white-space: normal;          /* allow wrapping */
        line-height: 1.45;
        }

        .murphy-break-all{
        word-break: break-all;        /* aggressive break (use carefully) */
        overflow-wrap: anywhere;
        white-space: normal;
        }

        .murphy-break-clamp-2{
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
        }

        
    </style>
<style>
  .murphy-swal-popup{
    padding: 10px !important;
    border-radius: 16px !important;
    overflow: visible !important; /* resizable */
  }

  .murphy-swal-title{
    cursor: move; /* draggable handle */
    user-select: none;
    font-weight: 700;
  }

  
.swal2-html-container{
  overflow: visible !important; /* avoid locking inner scroll */
}

  .murphy-preview-shell{
    width: 100%;
    height: 70vh;              /* base height */
    max-height: 80vh;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,.12);
    background: #fff;
      overflow: visible;

  }

  .murphy-preview-iframe{
    width: 100%;
    height: 100%;
    border: 0;
  }

  .murphy-preview-img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    background: #0b0b0b;
  }

  /* Make jQuery UI resize handle visible */
  .murphy-resizable .ui-resizable-se{
    width: 18px; height: 18px;
    right: 6px; bottom: 6px;
    opacity: .6;
  }
  .murphy-swal-popup
  {
    padding:0px!important;
  }
div:where(.swal2-container) div:where(.swal2-html-container) 
{
    padding:0px!important;
    
}

.swal2-modal
{
        width: 100vw!important
        height: 115%!important;
}
.swal2-close
{
    font-size:25px!important;
}
</style>

<div> 
    <form method="GET" action="{{ route('remark.index.search') }}" class="mb-3">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="" autocomplete="off" class="form-control" style="width:300px;">

            <select name="remark">
                <option value="" {{ request('remark') == '' ? 'selected' : '' }}>All</option>
                <option value="yes" {{ request('remark') == 'yes' ? 'selected' : '' }}>Remark YES</option>
                <option value="no" {{ request('remark') == 'no' ? 'selected' : '' }}>Remark NO</option>
            </select>

            <select name="sort_by">
                <option value="e.enter_number" {{ request('sort_by', 'e.enter_number') == 'e.enter_number' ? 'selected' : '' }}>Enter Number</option>
                <option value="e.date_make" {{ request('sort_by') == 'e.date_make' ? 'selected' : '' }}>Date Make</option>
            </select>

            <select name="sort_dir">
                <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>DESC</option>
                <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>ASC</option>
            </select>

            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('remark.index') }}" class="btn btn-secondary">Clear</a>

        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ເລກທີ່</th>
                <th>ຂໍ້ມູນບໍລິສັດ</th>
                <th>ລາຍການລົດ</th>
                <th>ເສັ້ນທາງ</th>
                <th>ທີ່ຢູ່</th>
            </tr> 
        </thead>
        </tr>
        <tbody>
            @foreach ($beta_enter as $row_enter)
                <tr class="row_fade{{ $row_enter->enter_id }}">
                    <td class="white-thing" style="display:none;">{{ $row_enter->enter_number }}</td> 
                    <td class="white-thing" style="display:none;">
                        {{ $row_enter->com_name }}<br>
                        <small class="sub_stable_font">
                            {{ date('d-m-Y', strtotime($row_enter->date_in)) }}<br>
                            {{ $row_enter->name }}<br>
                            {{ $row_enter->email }}
                        </small>
                        <br> 
                        @php
                            $statusLabels = [
                                'WAITING'  => ['btn-warning', 'ລໍຖ້າກວດ'],
                                'POINTING' => ['btn-primary', 'ຖ້າລະບຸເສັ້ນທາງ'],
                                'SIGNING'  => ['btn-warning', 'ຖ້າເຊັນ'],
                                'SIGNINED' => ['btn-primary', 'ເຊັນແລ້ວ'],
                                'READY'    => ['btn-primary', 'ລໍຖ້າສົ່ງ'],
                                'SUCCESS'  => ['btn-success', 'ສຳເລັດ'],
                                'CANCEL'   => ['btn-danger', 'ຍົກເລີກ'],
                            ];
                            $statusData = $statusLabels[$row_enter->status] ?? null;
                        @endphp

                        @if($statusData)
                            <span class="badge {{ $statusData[0] }}">{{ $statusData[1] }}</span>
                        @else
                            ບໍ່ມີສະຖານະ
                        @endif 
                    </td>

                    <td class="white-thing">
                        <table class="table sub_table sub_stable_font" style="margin:0px;border-radius:5px;">
                            @forelse(($beta_enter_detail[$row_enter->enter_id] ?? collect()) as $row)
                                <tr>
                                    <td><button class="btn btn-outline-primary add-remark" data-enter-detail-id="{{ $row->enter_detail_id }}" data-plate-number="{{ $row->plate_number }}" style="padding:0px 5px;"> Add {{ $row_enter->enter_number }}/{{ $row->plate_number }} </button></td>
                                    <td style="display:none;">{{ $row->plate_number }}</td>
                                    <td style="display:none;">{{ $row->d_name }}</td>
                                    <td style="display:none;">
                                        {{ $row->t_type_name }}
                                        @if($row->rounds != 1 && $row->rounds != '')
                                            - ( {{ $row->rounds }} ຖ້ຽວ )
                                        @endif
                                    </td>
                                    <td style="display:none;">{{ $row->p_import }}</td>
                                    <td style="display:none;">{{ $row->detail }}</td>
                                    <td style="display:none;">{{ $row->weight }}</td> 
                                    <td>
                                        @if($row->remark)
                                           <a href="{{ route('remark.paper', [$row_enter->enter_id, $row->enter_detail_id]) }}" target="_blank">
                                                <button>View paper</button>
                                            </a>
                                        @endif
                                    </td> 
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">ບໍ່ມີລາຍການ</td>
                                </tr>
                            @endforelse
                        </table>
                    </td> 
                    <td class="sub_stable_font white-thing" style="display:none;">
                        <u>{{ $row_enter->main_road_name }}</u><br>
                        @foreach(($beta_enter_road_detail[$row_enter->enter_id] ?? collect()) as $road)
                            - {{ $road->road_name }}<br>
                        @endforeach
                    </td>

                    <td class="sub_stable_font white-thing" style="display:none;max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:normal;" title="{{ $row_enter->lasttails }}">
                        ບ້ານ {{ str_replace('ບ້ານ', '', $row_enter->address) }}<br>
                        ເມືອງ {{ str_replace('ເມືອງ', '', $row_enter->district) }}<br>
                        ແຂວງ {{ str_replace('ແຂວງ', '', $row_enter->province) }}

                        @if($row_enter->lasttails)
                            <div style="width:100%;word-wrap:break-word;display:none;" >
                                <small>( {{ $row_enter->lasttails }} )</small>
                            </div>
                        @endif

                        @if($row_enter->feed_back_msg != '')
                            <br>
                            <div style="width:100%;word-wrap:break-word;color:blue;display:none;">
                                ໝາຍເຫດ : {{ $row_enter->feed_back_msg }}
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> 
</div> 
<br>
    <div class="mt-3 text-center">  
        {{ $beta_enter->links('pagination.custome-pagination') }}
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
<script>
    $(document).on('click', '.add-remark', function (e) {
        e.preventDefault();

        let enterDetailId = $(this).data('enter-detail-id');
        let plateNumber = $(this).data('plate-number');

        alert(enterDetailId + ' - ' + plateNumber);

        $.ajax({
            url: '{{ route("remark.index.add") }}',
            type: 'POST',
            data: {
                enter_detail_id: enterDetailId,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                console.log(response);
                alert(response.success);
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
                alert('Error adding remark');
            }
        });
    });
</script>
</x-app-layout>
