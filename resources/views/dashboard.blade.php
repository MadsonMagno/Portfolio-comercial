<x-app-layout>
    <x-slot name="header" >

        <div class="flex justify-between">

            <img src="{{asset('logo.png')}}" class="h-12 ml-8 mt-2">

            <div class="flex  justify-center items-center noprint">
                <a href="{{route('dashboard')}}" class="mr-4 p-2 noprint border-b text-gray-500 border-gray-300 "><i class="fa fa-plus"></i> Novo</a>
                <a href="{{route('lista')}}"  class="mr-4 p-2 noprint border-b text-gray-500 border-gray-300 "><i class="fa fa-list"></i> Consultar</a>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mr-8 mt-2 noprint">
                @csrf

                <x-button :href="route('logout')" class="bg-red-200 text-red-700"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                Sair
                </x-button>
            </form>

        </div>


    </x-slot>


    @if(Route::is('dashboard'))
        @livewire('remember')
    @else
        @livewire('visualizar')
    @endif




</x-app-layout>
