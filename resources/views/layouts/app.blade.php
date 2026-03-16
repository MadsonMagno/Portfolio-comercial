<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles

        <wireui:scripts />
        <script src="//unpkg.com/alpinejs" defer></script>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/basic.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css">


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

        <style>
            @media print {
               .noprint {
                  display: none;
               }
               .pprint {
                 grid-column: span 4 / span 4 !important;
               }
            }

            input:disabled {
                background-color: #E6E6E6;
            }
        </style>

    </head>
    <body class="font-sans antialiased" id="content">
        <div class="min-h-screen bg-gray-100">
            {{-- @include('layouts.navigation') --}}

            <!-- Page Heading -->
            <header class="bg-white shadow">

                    {{ $header }}

            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @livewireScripts

        <script>

            window.addEventListener('message', () => {
                Swal.fire({
                title: 'Contas Localizadas',
                text: 'Carregado itens com valores médios',
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: "#3085d6",
                })
            })

            window.addEventListener('fail', () => {
                Swal.fire({
                title: 'Nenhuma conta Localizada',
                text: 'Informar os valores manualmente',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: "red",
                })
            })


            window.addEventListener('summernote', () => {

                $('.summernote').summernote('destroy');
                $('.summernote').summernote();

                $('.summernote').on('summernote.blur', function() {

                    var t = $('.summernote').summernote('code');

                    Livewire.emit('summernote', t);
                });

            })

            window.addEventListener('generatePDF', () => {
                window.print();

            });

            function saveorc(){
                Swal.fire({
                title: "Confirma?",
                text: "Após salvar não será mais possível fazer alterações. Se necessário gere um novo orçamento!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim, Gerar Orçamento!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('gerarorcamento');
                }
                });

            }





        </script>


    </body>
</html>
