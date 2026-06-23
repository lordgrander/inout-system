<x-app-layout>
   <style>
       a
       {
           text-decoration:none!important;
           color:#696767!important;
           cursor:pointer;
       }
   </style>
    <div class="py-12 laos">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 
                @if(auth()->user()->is_admin=='2' OR auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <!--   -->
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('seeEnterWaiting') }}">ເອກະສານລໍຖ້າຄັດກອງ ( <asd class="text-danger">{{ $count_amount }}</asd> ) </a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                        href="{{ route('seeEnterPointing') }}">ເອກະສານລໍຖ້າລະບຸປາຍທາງ</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>  
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('seeEnterSigned') }}">ເອກະສານລໍຖ້າສົ່ງໃຫ້ບໍລິສັດ ( <asd class="text-danger">{{ $count_amount_signined }}</asd> ) </a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                             
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>  
                </div>
                @endif

                @if(auth()->user()->is_admin=='3' OR auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('seeEnterPointing') }}">ເອກະສານລໍຖ້າລະບຸປາຍທາງ ( <asd class="text-danger">{{ $count_amount_pointing }}</asd> ) </a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                        href="{{ route('seeEnterSigning') }}">ເອກະສານລໍຖ້າລົງລາຍເຊັນ</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>  
                </div>
                @endif

                @if(auth()->user()->is_admin=='4' OR auth()->user()->is_admin=='5')
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('seeEnterSigning') }}">ເອກະສານລໍຖ້າລົງລາຍເຊັນ ( <asd class="text-danger">{{ $count_amount_signing }}</asd> ) </a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                        href="{{ route('seeEnterSussess') }}">ເອກະສານເຊັນສຳເລັດ</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>  
                </div>
                @endif
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('seeEnterall') }}">ລາຍການເອກະສານທັງໝົດ</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div> 
                    <div class="p-6">
                        <div class="flex items-center">
                             
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('seeEnterCancel') }}">ເອກະສານທີ່ຖືກຍົກເລີກ ( <asd class="text-danger">{{ $count_amount_cancel }}</asd> ) </a></div>
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
 
 
</x-app-layout>
