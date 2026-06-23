<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight laos">
            {{ __('ຄົ້ນຫາເອກະສານຕາມຮອບວັນທີ') }}
        </h2>
    </x-slot>

    <div class="py-12 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <table>
                            <tr>
                                <td width="5%"> 
                                    <svg viewBox="0 0 70 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        class="block h-12 w-auto"> 
                                            
                                        <path
                                            d="M11.395 44.428C4.557 40.198 0 32.632 0 24 0 10.745 10.745 0 24 0a23.891 23.891 0 0113.997 4.502c-.2 17.907-11.097 33.245-26.602 39.926z"
                                            fill="#6875F5"></path>
                                        <path
                                            d="M14.134 45.885A23.914 23.914 0 0024 48c13.255 0 24-10.745 24-24 0-3.516-.756-6.856-2.115-9.866-4.659 15.143-16.608 27.092-31.75 31.751z"
                                            fill="#6875F5"></path>
                                    </svg> 
                                </td>
                                <td><br>
                                    <h4><b class="laob">ລາຍງານເອກະສານ :</b>
                                    <form action="{{route('doc_search')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="date" name="start" class="form-control"><br>
                                            <input type="date" name="end" class="form-control"><br>
                                            <select name="type"  style="font-size:19px;" class="form-control">
                                                <option value="in">ເຂົ້າ</option>
                                                <option value="out">ອອກ</option>
                                            </select><br>
                                            <select  aria-label="Default select example" name="inout" style="font-size:19px;" class="form-control">
                                                <option value="">ທັງໝົດ</option>
                                                    @php($i=1)
                                                    @foreach($databigtype as $rowx) 
                                                        <option value="{{ $rowx->id }}">{{$rowx->name}}</option>  
                                                    @endforeach
                                            </select><br>
                                            <input type="submit" class="form-control btn-outline-danger" value="Search">
                                        </form>
                                    </h4>
                                </td>
                            </tr>
                        </table>
                        
                    </div>

                    <div class="mt-8 text-2xl">
                        <!-- ::R -->
                    </div>

                    <div class="mt-6 text-gray-500">
                         
                    </div>
                </div>   
            </div>
        </div>
    </div>
</x-app-layout>
