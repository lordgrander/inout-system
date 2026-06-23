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
            column-count: 3;
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
    th
    {
        text-align:center;
    }

    .object
    {
        border-radius:5px;
        background:#d0d0d0;
        margin-top:5px;
        padding:5px;
    }
    
    </style>
   
    
    <div class="py-1 laos">
        <div class="max-w-12xl mx-auto sm:px-12 lg:px-12 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1 ">
                   
                    <div class="p-1">
                        <div class="dream  items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"> 
                                <div class=""> 
                                   @foreach ($typex as $t)
                                       <p >{{ $t->name }}</p>
                                       <table class="table table-striped">
                                            @foreach ($t->proHaveType as $p) 
                                                @if(count($p->proHaveQ)>0)
                                                    <tr>
                                                        <td width="30%"></td>
                                                        <td class="text-primary"><b>{{$p->name}} 
                                                        </b> : </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td> 
                                                        <td>
                                                            <table class="table table-bordered">
                                                                @foreach ($p->proHaveQ as $pp)
                                                                    @if($pp->dHaveQ->status=='SUCCESS' && $pp->dHaveQ->com_id==Auth::user()->com_id)
                                                                        <tr> 
                                                                            <td width="25%">{{ $pp->name }}</td> 
                                                                            <td width="25%">{{ number_format($pp->weight) }} Kg</td>  
                                                                            <td>USAGE  </td>
                                                                        </tr>
                                                                    @else 

                                                                    @endif
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                       </table>
                                   @endforeach
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
        </div> 
    </div> 
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> 
 
</x-app-layout>
