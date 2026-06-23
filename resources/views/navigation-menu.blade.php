<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 noprint">
    <style>
        a{
            text-decoration:none;
        }
    </style>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-2 noprint">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo --> 
                <!-- Navigation Links -->
                <div class="  space-x-8 sm:-my-px sm:ml-10 sm:flex laos" >
                     {{-- <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" style="text-decoration:none;font-size: 1.25em!important;">
                        {{ __('ໜ້າຫຼັກ') }}
                    </x-jet-nav-link> --}} 
                    @auth
                    @php $user = auth()->user(); @endphp
                
                    @if ($user->is_admin == 5 && $user->id != 13)
                        <x-jet-nav-link href="{{ route('Enter') }}" :active="request()->routeIs('Enter')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ອອກໃບອະນຸຍາດ') }}
                        </x-jet-nav-link>
                       {{--
                        <x-jet-nav-link href="{{ route('Enter.insurance.index') }}" :active="request()->routeIs('Enter.insurance.index')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຊື້ປະກັນ') }}
                        </x-jet-nav-link>
                        --}}
                        <x-jet-nav-link href="{{ route('tell_car_insurance.create') }}" :active="request()->routeIs('tell_car_insurance.create')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ແຈ້ງປະກັນໄພ') }}
                        </x-jet-nav-link> 
                        <x-jet-nav-link href="{{ route('see_insurance_tell_waiting') }}" :active="request()->routeIs('see_insurance_tell_waiting')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ລາຍການແຈ້ງປະກັນ') }}
                        </x-jet-nav-link> 
                    @endif
@endauth
                    @if(auth()->user()->is_admin=='16') 
                        <x-jet-nav-link href="{{ route('tell_car_insurance.create') }}" :active="request()->routeIs('tell_car_insurance.create')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ແຈ້ງປະກັນໄພ') }}
                        </x-jet-nav-link> 
                        <x-jet-nav-link href="{{ route('see_insurance_tell_waiting') }}" :active="request()->routeIs('see_insurance_tell_waiting')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ລາຍການແຈ້ງປະກັນ') }}
                        </x-jet-nav-link> 
                    @endif
                    @if(auth()->user()->is_admin=='1'  )
                        <x-jet-nav-link href="{{ route('Enter') }}" :active="request()->routeIs('Enter')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ອອກໃບອະນຸຍາດ') }}
                        </x-jet-nav-link> 
                        <x-jet-nav-link href="{{ route('tell_car_insurance.create') }}" :active="request()->routeIs('tell_car_insurance.create')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ແຈ້ງປະກັນໄພ') }}
                        </x-jet-nav-link> 
                        <x-jet-nav-link href="{{ route('EnterList') }}" :active="request()->routeIs('EnterList')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຕິດຕາມເອກະສານ') }}
                        </x-jet-nav-link>
                        @if(session('com_status')=='YES')
                        <x-jet-nav-link href="{{ route('EnterQuotar') }}" :active="request()->routeIs('EnterQuotar')" style="text-decoration:none;font-size: 1em!important;color:blue;">
                            {{ __('ນຳໃຊ້ Quotar') }}
                        </x-jet-nav-link> 
                        <x-jet-nav-link href="{{ route('tell.product') }}" :active="request()->routeIs('tell.product')" style="text-decoration:none;font-size: 1em!important;color:blue;">
                            {{ __('ແຈ້ງ Quotar') }}
                        </x-jet-nav-link> 
                        <x-jet-nav-link href="{{ route('quotar.history') }}" :active="request()->routeIs('quotar.history')" style="text-decoration:none;font-size: 1em!important;color:blue;">
                            {{ __('ຕິດຕາມແຈ້ງໂຄຕ້າ') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('see.quotar') }}" :active="request()->routeIs('see.quotar')" style="text-decoration:none;font-size: 1em!important;color:blue;">
                            {{ __('ເບີ່ງ Quotar') }}
                        </x-jet-nav-link> 
                        @endif
                        <x-jet-nav-link href="{{ route('EnterHistoryList') }}" :active="request()->routeIs('EnterHistoryList')" style="text-decoration:none;font-size: 1em!important;color:blue;">
                            {{ __('ປະຫວັດ') }}
                        </x-jet-nav-link>
                    @endif  
                    @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5')
                        <x-jet-nav-link href="{{ route('seeEnterWaiting') }}" :active="request()->routeIs('seeEnterWaiting')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຈັດການເອກະສານ') }}
                        </x-jet-nav-link> 
                    @endif  
                    @if(auth()->user()->is_admin=='3')
                        <x-jet-nav-link href="{{ route('seeEnterPointing') }}" :active="request()->routeIs('seeEnterPointing')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຈັດການເອກະສານ') }}
                        </x-jet-nav-link> 
                    @endif
                    @if(auth()->user()->is_admin=='4')
                        <x-jet-nav-link href="{{ route('seeEnterSigning') }}" :active="request()->routeIs('seeEnterSigning')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຈັດການເອກະສານ') }}
                        </x-jet-nav-link>  
                    @endif

                    @if(Auth::user()->allow_other=='YES')
                        <x-jet-nav-link href="{{ route('expired.list') }}" :active="request()->routeIs('expired.list')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ລາຍການຫມົດອາຍຸ') }}
                        </x-jet-nav-link>  
                        <x-jet-nav-link href="{{ route('company.profile') }}" :active="request()->routeIs('company.profile')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຍື່ນຂໍອະນຸມັດ') }}
                        </x-jet-nav-link>  
                    @endif

                    @if(auth()->user()->is_admin=='7')
                        <x-jet-nav-link href="{{ route('seeZoneTwo') }}" :active="request()->routeIs('seeZoneTwo')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຈັດການເອກະສານ') }}
                        </x-jet-nav-link>   
                    @endif  
 

                    @if(auth()->user()->is_admin!='1' AND auth()->user()->is_admin!='4' AND auth()->user()->is_admin!='0' )
                    <x-jet-nav-link href="{{ route('Add') }}" :active="request()->routeIs('Add')" style="text-decoration:none;font-size: 1em!important;">
                            {{ __('ຕັ້ງຄ່າ') }}
                    </x-jet-nav-link> 
                    @endif
 
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative laos">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }} 
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            
                             @if (in_array(auth()->user()->is_admin, [4, 5])) 
                                <x-jet-dropdown-link class="session_set" style="text-decoration:none;cursor:pointer"> 
                                    @if (session('command') == 'off') 
                                            {{ __('ເຊັນເອງ') }}  
                                    @else   
                                            {{ __('ເຊັນລະບົບ') }} 
                                    @endif
                                </x-jet-dropdown-link> 
                            @endif
                            @if (auth()->user()->is_admin=='5')
                                <x-jet-dropdown-link href="{{ route('Enter') }}" :active="request()->routeIs('Enter')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ອອກໃບອະນຸຍາດ') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link href="{{ route('Enter.insurance.index') }}" :active="request()->routeIs('Enter.insurance.index')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ຊື້ປະກັນ') }}
                                </x-jet-dropdown-link>
                                
                            @endif
                            
                            @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5') 
                                <x-jet-dropdown-link href="{{ route('ReportIndex') }}" :active="request()->routeIs('ReportIndex')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ລາຍງານ') }}
                                </x-jet-dropdown-link> 
                                <x-jet-dropdown-link href="{{ route('watching_list') }}" :active="request()->routeIs('watching_list')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ເພີ່ມລາຍການອະນຸມັດທະບຽນ') }}
                                </x-jet-dropdown-link> 
                            @endif    
                            @if(Auth::user()->allow_other=='YES')
                                <x-jet-dropdown-link href="{{ route('expired.list') }}" :active="request()->routeIs('expired.list')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ລາຍການຫມົດອາຍຸ') }}
                                </x-jet-dropdown-link>  
                                <x-jet-dropdown-link href="{{ route('company.profile') }}" :active="request()->routeIs('company.profile')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ຍື່ນຂໍອະນຸມັດ') }}
                                </x-jet-dropdown-link>  
                            @endif

                            @if(auth()->user()->is_admin=='7') 
                                <x-jet-dropdown-link href="{{ route('view.quotar') }}" :active="request()->routeIs('view.quotar')" style="text-decoration:none;font-size: 1em!important;">
                                        {{ __('ເພີ່ມລາຍການ') }}
                                </x-jet-dropdown-link>
                                <x-jet-dropdown-link href="{{ route('quotar.tell') }}" :active="request()->routeIs('quotar.tell')" style="text-decoration:none;font-size: 1em!important;">
                                        {{ __('ແຈ້ງໂຄຕ້າ') }}
                                </x-jet-dropdown-link>
                            @endif  
                            
                            
                            <x-jet-dropdown-link href="{{ route('profile.show') }}" style="text-decoration:none;">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}" style="text-decoration:none;">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" style="text-decoration:none;"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden noprint">
        <div class="pt-2 pb-3 space-y-1"> 
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div> 
                </div>
            </div>

            <div class="mt-3 space-y-1">

            @if (in_array(auth()->user()->is_admin, [4, 5]))
                            <x-jet-dropdown-link class="session_set" style="text-decoration:none;cursor:pointer">

                            @if (session('command') == 'off') 
                                    {{ __('ເຊັນເອງ') }}  
                            @else   
                                    {{ __('ເຊັນລະບົບ') }} 
                            @endif
                            </x-jet-dropdown-link> 
                            @endif
                            
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" style="text-decoration:none;">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                                    @if (auth()->user()->is_admin=='5')
                                <x-jet-responsive-nav-link href="{{ route('Enter') }}" :active="request()->routeIs('Enter')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ອອກໃບອະນຸຍາດ') }}
                                </x-jet-responsive-nav-link>
                            @endif
                            
                            @if(auth()->user()->is_admin=='2' || auth()->user()->is_admin=='5') 
                                <x-jet-responsive-nav-link href="{{ route('ReportIndex') }}" :active="request()->routeIs('ReportIndex')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ລາຍງານ') }}
                                </x-jet-responsive-nav-link> 
                                <x-jet-responsive-nav-link href="{{ route('watching_list') }}" :active="request()->routeIs('watching_list')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ເພີ່ມລາຍການອະນຸມັດທະບຽນ') }}
                                </x-jet-responsive-nav-link> 
                            @endif    
                            @if(Auth::user()->allow_other=='YES')
                                <x-jet-responsive-nav-link href="{{ route('expired.list') }}" :active="request()->routeIs('expired.list')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ລາຍການຫມົດອາຍຸ') }}
                                </x-jet-responsive-nav-link>  
                                <x-jet-responsive-nav-link href="{{ route('company.profile') }}" :active="request()->routeIs('company.profile')" style="text-decoration:none;font-size: 1em!important;">
                                    {{ __('ຍື່ນຂໍອະນຸມັດ') }}
                                </x-jet-responsive-nav-link>  
                            @endif

                            @if(auth()->user()->is_admin=='7') 
                                <x-jet-responsive-nav-link href="{{ route('view.quotar') }}" :active="request()->routeIs('view.quotar')" style="text-decoration:none;font-size: 1em!important;">
                                        {{ __('ເພີ່ມລາຍການ') }}
                                </x-jet-responsive-nav-link>
                                <x-jet-responsive-nav-link href="{{ route('quotar.tell') }}" :active="request()->routeIs('quotar.tell')" style="text-decoration:none;font-size: 1em!important;">
                                        {{ __('ແຈ້ງໂຄຕ້າ') }}
                                </x-jet-responsive-nav-link>
                            @endif  

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
