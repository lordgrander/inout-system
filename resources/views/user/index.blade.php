<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight laos">
            {{ __('ລາຍການຜູ້ໃຊ້') }}
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
                                    <h4><b class="laob">ຂໍ້ມູນຜູ້ໃຊ້ລະບົບ</b>
                                         
                                    </h4>
                                    <form method="POST" action="{{ url('') }}">
                                        <input type="hidden" name="_token" value="bhAVr7KeksS9L6SGHiub7c7vfTRTbzyNTE17DaaR">
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700" for="name">
                                            Name
                                        </label>
                                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus" autocomplete="name">
                                        </div>

                                        <div class="mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="email">
                                            Email
                                        </label>
                                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="email" type="email" name="email" required="required">
                                        </div>


                                        <div class="mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="email">
                                            <b>ສິດທິຜູ້ໃຊ້</b>
                                        </label>
                                            <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="is_admin"   name="is_admin" required="required">
                                                <option value="admin">Admin</option>
                                                <option value="normal">Normal</option>
                                            </select>
                                        </div>
                                        

                                        <div class="mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="password">
                                            Password
                                        </label>
                                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="new-password">
                                        </div>

                                        <div class="mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="password_confirmation">
                                            Confirm Password
                                        </label>
                                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="password_confirmation" type="password" name="password_confirmation" required="required" autocomplete="new-password">
                                        </div>

                                        
                                        <div class="flex items-center justify-end mt-4"> 

                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">
                                            ບັນທຶກ
                                        </button>
                                        </div>
                                    </form>
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>

                         <!-- // @  table -->
                         <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="5%">#</th>
                                            <th scope="col">ຊື່ຜູ້ໃຊ້ 
                                        </tr>
                                    </thead>
                                    <tbody> 
                                <!-- // ::g  Code -->
                                        @php($i=1)
                                        @foreach($user as $row)
                                            <tr>
                                                <th scope="row" >
                                                    {{  $i++  }}
                                                    
                                                </th>
                                                <td><span class="badge" style="background-color:{{$row->color }}; ">&nbsp;</span>
                                                    <a href="{{ url('/document/in/view/'. $row->id)}}">{{ $row->name}}</a>
                                                </td>  
                                            </tr>
                                        @endforeach

                                <!-- // ::g  EndCode -->
                                    </tbody>
                                </table> 

                                <!-- // ::g  Code -->
                                    {{$user->links()}}
                                <!-- // ::g  EndCode -->
        </div>
        </div>
        </div>
        </div>
    </div>
</x-app-layout>
