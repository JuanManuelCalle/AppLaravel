@extends('layouts.app')

@section('titulo')
    Pagina principal
@endsection

@section('contenido')

    <x-listar-post :posts="$posts" /> {{-- Asi se le pasa variables al component --}}

    {{-- <x-listar-post>
        <x-slot:titulo> Con esto creamos un slot personalizado 
            <header>Esto es un header</header>
        </x-slot:titulo>
        <h1>Mostrando desde slots</h1>
    </x-listar-post> --}}

    {{-- Para usar esto tenemos que crear el componente con php artisan make:component NombreComponent y luego en el blade se pondra todo el contenido a renderizar
        Esta etiqueta siempre sera la misma <x-Nombre-Component />   --}}

        {{-- Cuando hacemos el cierre <x-Nombre-COmponent /> este indicara que no soporta slots pero si en vez de hacer ese cierrre hacemos un cierre <x-Nombre-Component> </x-Nombre-Component> 
            Este indica que usaremos los slots --}}

    {{-- @forelse ($posts as $post)
        <h1>{{ $post->titulo }}</h1>
    @empty
        <p>No hay posts</p>
    @endforelse --}} {{-- Esta es otra manera de mostrar le contenido es lo mismo que el if con el foreach  --}}

@endsection