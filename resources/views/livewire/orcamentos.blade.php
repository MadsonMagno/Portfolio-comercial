<div class="bg-white">

    <div class="p-8">

        <div class="flex justify-between">

        <input tye="text" class="block w-64 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" placeholder="Pesquisar" wire:model="search">

        <div>
        <input type="date" wire:model="data_ini" class="p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
        <input type="date" wire:model="data_fim" class="p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">

        </div>

        </div>


        <table class="min-w-full table-auto mb-8 mt-4">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-2 px-6 text-left">NÚMERO</th>
                    <th class="py-2 px-6 text-left">DATA</th>
                    <th class="py-2 px-6 text-left">USUÁRIO</th>
                    <th class="py-2 px-6 text-left">PACIENTE</th>
                    <th class="py-2 px-6 text-left">PROFISSIONAL</th>
                    <th class="py-2 px-6 text-left">CONVÊNIO</th>
                    <th class="py-2 px-6 text-left">PRCEDIMENTO</th>
                    <th class="py-2 px-6 text-left">VALOR</th>
                    <th class="py-2 px-6 text-left">DUPLICAR</th>

                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($orcamentos as   $f)



                <tr class="border-b border-gray-200 hover:bg-gray-100"  >

                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                         {{str_pad($f->protocolo, 6, '0', STR_PAD_LEFT)}} - {{$f->versao}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        {{ date_format($f->created_at,'d/m/Y H:i')}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        {{$f->user->name}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        {{$f->nome}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        {{$f->profissional}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        {{$f->convenio}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        {{$f->cdprofat}}
                        </a>
                    </td>
                    <td  class="py-2 px-6 text-left">
                        <a href="{{route('visualizar', $f->id)}}" >
                        R$ {{number_format($f['valor'],2,',','.')}}
                        </a>
                    </td>

                    <td   class="py-2 px-6 text-center">
                        <a href="{{route('dashboard', ['id' => $f->id])}}" >
                            <i class="fa fa-copy text-gray-400 mr-2"></i>
                        </a>
                    </td>

                </tr>


                @endforeach

            </tbody>
        </table>


        {{$orcamentos->links()}}

    </div>
</div>
