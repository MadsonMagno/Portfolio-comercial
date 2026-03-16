<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reintegração Pedido</title>
    <!-- Inclua o link para o CSS do Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles

    <wireui:scripts />
    <script src="//unpkg.com/alpinejs" defer></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basic.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-white h-screen flex items-center justify-center">
    {{-- {{ $slot }} --}}

    @livewire('remember')

    @livewireScripts

    <script>

        window.addEventListener('message', () => {
            Swal.fire({
            title: 'Error!',
            text: 'Não foi encontrado nenhum pedido com o número informado!',
            icon: 'error',
            confirmButtonText: 'OK'
            })
        })


    </script>


</body>

</html>
