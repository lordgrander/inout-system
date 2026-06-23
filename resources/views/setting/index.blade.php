<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight laos">
            {{ __('ຕັ້ງຄ່າ') }}
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
                                    <h4><b class="laob">ຕັ້ງຄ່າ</b>
                                         
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

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('Bigtypex') }}">ເພີ່ມປະເພດເອກະສານ</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                            </div>
 
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                                <path
                                 d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path> 
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                        href="{{ route('user') }}">ເພີ່ມຜູ້ໃຊ້ລະບົບ</a></div>
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
