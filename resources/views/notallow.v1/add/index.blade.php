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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    @if(auth()->user()->is_admin=='2')
                    <div class="p-6">
                        <div class="flex items-center"> 
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('ComAdd') }}">ເພີ່ມບໍລິສັດ ແລະ ຜຸ້ໃຊ້</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>
                    @endif
                    @if(auth()->user()->is_admin=='3')
                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                
                                <div class="ml-4   text-gray-600 leading-7  ">
                                    <a
                                            href="{{ route('RoadAdd') }}">ເພີ່ມສາຍທາງ</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a
                                    href="{{ route('MainroadAdd') }}">ເພີ່ມປະເພດລົດ</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a
                                        href="{{ route('WheelsAdd') }}">ເພີ່ມປະເພດລໍ້ລົດ</a>

                                        </div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-sm text-gray-500">
                                </div>
    
                            </div>
                        </div>   
                    @endif
                </div>
 
                
            </div>
        </div>
    </div> 
 
</x-app-layout>
