@extends('layouts.app')

@section('content')
<!-- Contenedor principal -->
<div class="container">
    <!-- Título de la página con el término de búsqueda -->
    <h1>Resultados de Búsqueda para "{{ $query }}"</h1>
    <!-- Fila para mostrar los productos -->
    <div class="row">
        <!-- Iterar sobre los productos y mostrar cada uno -->
        @foreach($products as $product)
            <!-- Columna para cada producto -->
            <div class="col-md-4 mb-4">
                <!-- Tarjeta para mostrar los detalles del producto -->
                <div class="card">
                    <!-- Encabezado de la tarjeta con el nombre del producto -->
                    <div class="card-header">{{ $product->name }}</div>
                    <!-- Cuerpo de la tarjeta -->
                    <div class="card-body">
                        <!-- Mostrar imagen del producto si está disponible -->
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}">
                        @endif
                        <!-- Descripción del producto -->
                        <p>{{ $product->description }}</p>
                        <!-- Precio del producto -->
                        <p>Precio: ${{ $product->price }}</p>
                        <!-- Enlace para ver los detalles del producto -->
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
