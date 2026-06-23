{{-- resources/views/allow/expired/index.blade.php --}}

<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 ">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 text-center">
            <br>

            <h1 class="text-2xl font-bold mb-2 laos">
                User ຂອງທ່ານໄດ້ຫມົດອາຍຸແລ້ວ : "{{  date('d-m-Y',strtotime(Auth::user()->end_at)) }}" 
            </h1> 
            <p class="text-gray-700 mb-8 laos">
                <label >ກະລຸນາເຂົ້າມາພົວພັນທີ່ຫ້ອງການບໍລິຫານດ່ານ</label> ຂົວມິດຕະພາບ 1  (ຈຸດບໍລິການທ່າບົກນາແລ້ງ) ຫລື ຕິດຕໍ່ພົວພັນເບີໂທ : 020 5838 1616
            </p>

            <!-- <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="px-6 py-2 rounded-md font-semibold
                           bg-red-600 text-white
                           hover:bg-red-700 focus:outline-none
                           focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Logout
                </button>
            </form> -->
        </div>
    </div>
</x-app-layout>