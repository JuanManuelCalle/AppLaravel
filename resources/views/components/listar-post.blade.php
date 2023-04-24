<div>

    @if($posts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        @foreach ($posts as $post ) {{-- Recordar hacemos el foreach para mostrar y luego del as le ponemos una variable que es como el alias para mostrar --}}
            <div class="">
                <a href="{{ route('post.show', ['post' => $post, 'user' => $post->user]) }}"> {{-- Para redireccionar a una vista mas detallada --}}
                    <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                </a>
            </div>
        @endforeach
    </div>
    <div class="my-10">
        {{ $posts->links('pagination::tailwind') }} {{-- ESTO SOLO SE PONE EN EL CASO DE QUE DIGAMOS EN ELL CONTROLADOR SEA PAGINATE Y NO GET SI ES PAGINATE NOS PAGINA TODO Y NOS HACE EL GET IGUALMENTE --}}
    </div>
    @else
    <p class="text-center">No hay posts, sigue a alguien para empezar a verlos</p>
    @endif


    {{-- {{ $titulo }} Si queremos darle un slot personalizado debemos crear la etiqueta <x-slot:Nombre> </x-slot:Nombre> asi creamos el component personalizado --}}
   {{-- <h1>{{ $slot }}</h1> Si vamos a mostrar el slot siempre se usa $slot --}}
</div>
