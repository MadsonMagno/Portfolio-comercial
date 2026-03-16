<div class="w-full h-screen px-6 bg-white text-xs">


    <body class="bg-gray-100">
        <div class="container mx-auto py-8 grid-cols-4 grid">

            <div class=" h-screen noprint">



                <ol class="space-y-2 w-72 ">

                    @foreach ($grupos as $key => $grupo)


                        <li class="cursor-pointer" wire:click="setetapa('{{$grupo}}')">
                            <div  class="w-full py-3 px-3 @if($grupo == $etapa) text-red-900 bg-red-200 @else text-gray-400 bg-gray-100  @endif  border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400" role="alert">
                                <div class="flex items-center justify-between">
                                    <span class="sr-only">{{$grupo}}</span>
                                    <h4 class="font-medium">{{$key+1}} {{$grupo}}</h4>
                                </div>
                            </div>
                        </li>



                    @endforeach

                </ol>

            </div>

            <div class="col-span-3 h-screen pprint">

                @if($etapa == 'DADOS CADASTRAIS')
                <div class="">
                    <h3 class="font-bold text-base mb-2">DADOS CADASTRAIS</h3>
                    <div class="space-y-4 flex flex-wrap p-8 rounded-md bg-gray-100">

                        <div class="flex items-center w-full">
                        <label for="nome" class=" w-36">Nome:</label>
                        <input type="text" wire:model="nome" @if($oid) disabled @endif class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                        </div>
                        <div class="flex items-center w-full">
                        <label for="profissional" class=" w-36">Profissional:</label>
                        <input type="text" wire:model="profissional"  @if($oid) disabled @endif class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                        </div>
                        <div class="flex items-center w-full">
                        <label for="convenio" class=" w-36">Convênio:</label>
                        <input type="text" wire:model="convenio"  @if($oid) disabled @endif class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                        </div>
                        <div class="flex items-center w-full">
                        <label for="procedimento" class=" w-36">Procedimento Principal:</label>
                        <div class="flex w-full">
                        <input type="number" wire:model.debounce.500ms="cdprofat"  @if($oid) disabled @endif class="block w-36 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                        <input type="text" wire:model="dsprofat"  @if($oid) disabled @endif  class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                        </div>
                        </div>

                            <div class="flex items-center w-full">
                            <label for="procedimento" class=" w-36">Procedimento(s) Secundário(s):</label>

                            <button type="button" wire:click="addsec" class="bg-green-500  w-8 mr-2   text-white p-2 rounded hover:bg-green-600">+</button>

                            @if(count($secundarios))
                            <div class="flex w-full overflow-y-auto">
                                @foreach($secundarios as $key => $sec)
                                    <input type="number" wire:model.debounce.500ms="secundarios.{{$key}}" class="block w-24 p-2 mr-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                                    <button type="button" wire:click="removesec('{{$key}}')" class=" w-4 mr-2 rounded text-red-500"><i class="fa fa-trash"></i></button>
                                @endforeach
                            </div>
                            @endif
                            </div>


                        <div class="flex items-center w-full">
                        <label for="observacao" class=" w-36">Observação:</label>
                        <textarea wire:model="observacao" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"></textarea>
                        </div>
                        <button type="button" wire:click="getMedias" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 flex-1">Carregar</button>
                    </div>
                </div>
                @endif


                @if($etapa != 'DADOS CADASTRAIS' and $etapa != 'ORÇAMENTO' and $etapa != 'OBSERVAÇÕES')
                <div class="">
                    <div class="flex justify-between">
                        <h3 class="font-bold text-base mb-2">{{$etapa}}</h3>

                        <div>

                            <h3 class="font-bold text-base mb-2">R$ {{ number_format($filtrados->sum('TOTAL'),2,',','.')  }}</h3>

                        </div>

                    </div>

                    <form class="space-y-4 flex flex-wrap p-6 rounded-md bg-gray-100">

                        <table class="min-w-full table-auto">
                            <thead>
                            </thead>

                        <tbody class="text-gray-600 text-sm font-light">

                        <tr>

                            <td>
                                <div class="flex justify-between items-center mx-2">
                                <input type="number" wire:model.debounce.500ms="selecionado.CD_PRO_FAT"  class="block  p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                                <i class="fa fa-search text-gray-500 ml-2 cursor-pointer" wire:click="abrirmodal" ></i>
                                </div>
                            </td>
                            <td >
                                <input type="text" wire:model="selecionado.DS_PRO_FAT"  class="w-72  p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                            </td>
                            <td >
                                <input type="number"  wire:model="selecionado.QTD" class=" text-right w-20  p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                            </td>
                            <td >
                                <input type="number"  wire:model="selecionado.VALOR"  class="block p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                            </td>
                            <td >
                                <input type="number" disabled  wire:model="selecionado.TOTAL"  class="block p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-100 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                            </td>
                            <td>

                                <i wire:click="save" class="fa fa-save ml-2 text-xl cursor-pointer text-green-800"></i>

                            </td>

                        </tr>

                        </tbody>

                        </table>

                    </form>



                    <div class="overflow-x-auto mt-4">

                        <a  href="#" class="focus:outline-none inline-flex justify-center items-center transition-all ease-in duration-100 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-1 py-1 mb-2     border text-slate-500 hover:bg-slate-100 ring-slate-200
                        dark:ring-slate-600 dark:border-slate-500 dark:hover:bg-slate-700
                        dark:ring-offset-slate-800 dark:text-slate-400"
                        wire:click.prevent="agrupar"
                        >

                        <i  class="fa fa-dollar ml-2  cursor-pointer text-blue-900"></i>
                        Agrupar


                        </a>

                        <a  href="#" class="focus:outline-none inline-flex justify-center items-center transition-all ease-in duration-100 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-1 py-1 mb-2     border text-slate-500 hover:bg-slate-100 ring-slate-200
                        dark:ring-slate-600 dark:border-slate-500 dark:hover:bg-slate-700
                        dark:ring-offset-slate-800 dark:text-slate-400"
                        wire:click.prevent="limpar"
                        >

                        <i  class="fa fa-trash ml-2  cursor-pointer text-red-600"></i>
                        Limpar


                        </a>




                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">CÓDIGO</th>
                                    <th class="py-3 px-6 text-left">PROCEDIMENTO</th>
                                    <th class="py-3 px-6 text-left">QTD</th>
                                    <th class="py-3 px-6 text-left">VALOR</th>
                                    <th class="py-3 px-6 text-left">TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($filtrados as $key =>  $f)



                                <tr class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer"  >

                                    <td wire:click.prevent="edit('{{$key}}')" class="py-3 px-6 text-left">{{$f['CD_PRO_FAT']}}</td>
                                    <td wire:click.prevent="edit('{{$key}}')" class="py-3 px-6 text-left">{{$f['DS_PRO_FAT']}}</td>
                                    <td wire:click.prevent="edit('{{$key}}')" class="py-3 px-6 text-left">{{$f['QTD']}}</td>
                                    <td wire:click.prevent="edit('{{$key}}')" class="py-3 px-6 text-left">R$ {{number_format($f['VALOR'],2,',','.')}}</td>
                                    <td wire:click.prevent="edit('{{$key}}')" class="py-3 px-6 text-left">R$ {{number_format($f['TOTAL'],2,',','.')}}</td>

                                    <td>

                                        <i wire:click="remove('{{$key}}')" class="fa fa-xmark ml-2 cursor-pointer text-red-600"></i>
                                    </td>

                                </tr>



                                @endforeach

                            </tbody>
                        </table>
                    </div>


                </div>
                @endif



                @if($etapa == 'ORÇAMENTO')

                <button  onclick="saveorc()" class="noprint p-2 border border-gray-300 hover:bg-red-400 text-red-900 bg-red-200 rounded-lg">SALVAR E IMPRIMIR</button>



                <div class="text-center">
                    <h3 class="font-bold text-base mb-2">PREVISÃO DE DESPESAS HOSPITALARES</h3>
                    <p>OS VALORES ESTÃO SUJEITOS A ALTERAÇÃO CONFORME A EXECUÇÃO DO PROCEDIMENTO</p>
                    <div class="flex justify-between">
                        <h3 class="font-xl font-bold pt-8">DATA: {{ date_format(now(),'d/m/Y H:i:s')}}</h3>
                        <div class="text-right">
                        <h3 class="font-xl font-bold pt-8">PROTOCOLO: {{str_pad($orcamento_id, 8, '0', STR_PAD_LEFT)}}</h3>
                        <h3 class="font-xl">Versão: {{str_pad($versao, 3, '0', STR_PAD_LEFT)}}</h3>
                        </div>

                    </div>

                </div>


                <div class=" mt-2 mb-4">

                    <div class="space-y-2 flex flex-wrap p-4 rounded-md bg-gray-200">

                        <div class="flex items-center w-full">
                        <label for="nome" class="font-bold w-36">Nome:</label>
                        {{$nome}}
                        </div>
                        <div class="flex items-center w-full">
                        <label for="profissional" class="font-bold  w-36">Profissional:</label>
                        {{$profissional}}
                        </div>
                        <div class="flex items-center w-full">
                        <label for="convenio" class="font-bold  w-36">Convênio:</label>
                        {{$convenio}}
                        </div>
                        <div class="flex items-center w-full">
                        <label for="procedimento" class="font-bold  w-36">Procedimento Principal:</label>
                        <div class="flex w-full pl-6">
                        {{$cdprofat}} -
                        {{$dsprofat}}
                        </div>
                        </div>

                        @if(count($secundarios))
                        <div class="flex items-center w-full">

                            <div class="flex items-center w-full">
                            <label for="procedimento" class="font-bold  w-36">Procedimento(s) Secundário(s):</label>
                            <div class="flex w-full pl-6">
                                @foreach($secundarios as $key => $sec)
                                    @if($key == 0)

                                    {{$sec}}

                                    @else

                                    - {{$sec}}

                                    @endif

                                @endforeach
                            </div>

                            </div>
                        </div>
                        @endif


                        <div class="flex items-center w-full">
                        <label for="observacao" class="font-bold  w-36">Observação:</label>
                        {{$observacao}}
                        </div>

                    </div>
                </div>

                <div class="">
                    <div class="flex justify-between">
                        <h3 class="font-bold text-base mb-2">ORÇAMENTO</h3>

                        <div>
                            <h3 class="font-bold text-base mb-2">R$ {{ number_format(collect($orcamento)->sum('TOTAL'),2,',','.')  }}</h3>
                        </div>

                    </div>


                    <div class="overflow-x-auto mt-4">


                        @foreach ($grupos as $o)

                            @if($o != 'DADOS CADASTRAIS' and $o != 'ORÇAMENTO' and $o != 'OBSERVAÇÕES')

                                @if(collect($orcamento)->where('DS_GRU_FAT', $o)->sum('TOTAL') > 0)

                                <h4 class="font-bold  mb-2">{{$o}}</h4>

                                <table class="min-w-full table-auto mb-4">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600  text-xs leading-normal">
                                            <th class="py-2 px-6 w-1/12 text-left">Código</th>
                                            <th class="py-2 px-6 w-6/12 text-left">Procedimento</th>
                                            <th class="py-2 px-6 w-1/12 text-left">Qtd</th>
                                            <th class="py-2 px-6 w-2/12 text-left">Valor</th>
                                            <th class="py-2 px-6 w-2/12 text-left">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach (collect($orcamento)->where('DS_GRU_FAT', $o) as $key =>  $f)


                                        <tr class="border-b border-gray-200 hover:bg-gray-100  cursor-pointer"  >

                                            <td  class="py-1 px-6 text-left">{{$f['CD_PRO_FAT']}}</td>
                                            <td  class="py-1 px-6 text-left lowercase">{{$f['DS_PRO_FAT']}}</td>
                                            <td  class="py-1 px-6 text-left">{{$f['QTD']}}</td>
                                            <td  class="py-1 px-6 text-left">R$ {{number_format($f['VALOR'],2,',','.')}}</td>
                                            <td  class="py-1 px-6 text-left">R$ {{number_format($f['TOTAL'],2,',','.')}}</td>



                                        </tr>



                                        @endforeach

                                    </tbody>
                                </table>

                                @endif

                            @endif


                        @endforeach

                    </div>


                </div>

                <div class="mt-8">
                {!! $obs !!}
                </div>

                @endif

                @if($etapa == 'OBSERVAÇÕES')


                    <textarea rows="10" class="w-full border summernote border-gray-300">
                    {!! $obs !!}
                    </textarea>


                    </a>



                @endif

            </div>


        </div>
    </body>

    @if($modal)
    <div id="default-modal" tabindex="-1"  class="flex overflow-y-auto bg-slate-500 bg-opacity-50 overflow-x-hidden fixed top-0  z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border border-gray-500 rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-2 md:p-2 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Lista de Procedimentos
                    </h3>
                    <button type="button" wire:click="$set('modal', false)" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <input type="text" wire:model="pesquisar" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                    <br>

                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-1 px-6 text-left">CÓDIGO</th>
                                <th class="py-1 px-6 text-left">PROCEDIMENTO</th>
                                <th class="py-1 px-6 text-left"></th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($procedimentos as $key =>  $g)



                            <tr class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer"  >

                                <td wire:click.prevent="edit('{{$key}}')" class="py-1 px-6 text-left">{{$g['CD_PRO_FAT']}}</td>
                                <td wire:click.prevent="edit('{{$key}}')" class="py-1 px-6 text-left">{{$g['DS_PRO_FAT']}}</td>
                                <td wire:click.prevent="setprofat('{{$g['CD_PRO_FAT']}}', '{{$g['DS_PRO_FAT']}}')" class="py-1 px-6 text-left"><i class="fa fa-plus"></i></td>


                            </tr>



                            @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
    @endif

</div>
