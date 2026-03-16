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
                                {{$sec}} /

                                @endforeach
                            </div>

                            </div>
                        </div>
                        @endif

                        <div class="flex items-center w-full">
                            <label for="data" class="font-bold  w-36">Data:</label>
                            {{ date_format($data,'d/m/Y')}}
                        </div>
                        <div class="flex items-center w-full">
                        <label for="observacao" class="font-bold  w-36">Observação:</label>
                        {{$observacao}}
                        </div>

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



                    <div class="overflow-x-auto mt-4">



                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">CÓDIGO</th>
                                    <th class="py-3 px-6 text-left">PROCEDIMENTO</th>
                                    <th class="py-3 px-6 text-left">QTD</th>
                                    <th class="py-3 px-6 text-left">VALOR</th>
                                    <th class="py-3 px-6 text-left">TOTAL</th>

                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($filtrados as $key =>  $f)



                                <tr class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer"  >

                                    <td  class="py-3 px-6 text-left">{{$f['CD_PRO_FAT']}}</td>
                                    <td  class="py-3 px-6 text-left">{{$f['DS_PRO_FAT']}}</td>
                                    <td  class="py-3 px-6 text-left">{{$f['QTD']}}</td>
                                    <td  class="py-3 px-6 text-left">R$ {{number_format($f['VALOR'],2,',','.')}}</td>
                                    <td  class="py-3 px-6 text-left">R$ {{number_format($f['TOTAL'],2,',','.')}}</td>



                                </tr>



                                @endforeach

                            </tbody>
                        </table>
                    </div>


                </div>
                @endif



                @if($etapa == 'ORÇAMENTO')

                <button onclick="window.print()" class="noprint p-2 border border-gray-300 hover:bg-red-400 bg-red-200 text-red-700 rounded-lg">IMPRIMIR</button>


                <div class="text-center">
                    <h3 class="font-bold text-base mb-2">PREVISÃO DE DESPESAS HOSPITALARES</h3>
                    <p class="text-xs">OS VALORES ESTÃO SUJEITOS A ALTERAÇÃO CONFORME A EXECUÇÃO DO PROCEDIMENTO</p>
                    <div class="flex justify-between">
                    <h3 class=" font-bold pt-8">DATA: {{ date_format($data,'d/m/Y H:i')}}</h3>
                    <div class="text-right">
                        <h3 class=" font-bold pt-8">PROTOCOLO: {{str_pad($protocolo, 8, '0', STR_PAD_LEFT)}}</h3>
                        <h3 class="font-xl">Versão: {{str_pad($versao, 3, '0', STR_PAD_LEFT)}}</h3>
                    </div>

                    </div>
                </div>


                <div class=" my-4">

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


                    <div class="overflow-x-auto mt-1">


                        @foreach ($grupos as $o)

                            @if($o != 'DADOS CADASTRAIS' and $o != 'ORÇAMENTO' and $o != 'OBSERVAÇÕES')

                                @if(collect($orcamento)->where('DS_GRU_FAT', $o)->sum('TOTAL') > 0)

                                <h4 class="font-bold  mb-1">{{$o}}</h4>

                                <table class="min-w-full table-auto mb-4">
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600  text-xs leading-normal">
                                            <th class="py-1 px-6 w-1/12 text-left">Código</th>
                                            <th class="py-1 px-6 w-6/12 text-left">Procedimento</th>
                                            <th class="py-1 px-6 w-1/12 text-left">Qtd</th>
                                            <th class="py-1 px-6 w-2/12 text-left">Valor</th>
                                            <th class="py-1 px-6 w-2/12 text-left">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-xs font-light">
                                        @foreach (collect($orcamento)->where('DS_GRU_FAT', $o) as $key =>  $f)


                                        <tr class="border-b border-gray-200 hover:bg-gray-100  cursor-pointer"  >

                                            <td  class="py-1 px-6 text-left">{{$f['CD_PRO_FAT']}}</td>
                                            <td  class="py-1 px-6 text-left lowercase">{{$f['DS_PRO_FAT']}}</td>
                                            <td  class="py-1 px-6 text-left">{{$f['QTD']}}</td>
                                            <td  class="py-1 px-6 text-left items-center">R$ {{number_format($f['VALOR'],2,',','.')}}</td>
                                            <td  class="py-1 px-6 text-left items-center">R$ {{number_format($f['TOTAL'],2,',','.')}}</td>



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



</div>
