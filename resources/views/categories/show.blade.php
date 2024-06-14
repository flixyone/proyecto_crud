@extends('layouts.app')

@section('content')
<!-- Contenedor principal -->
<div class="container">
    <!-- Título de la categoría -->
    <h1>{{ $category->name }}</h1>
    <!-- Fila de la cuadrícula para mostrar productos -->
    <div class="row">
        <!-- Iterar sobre los productos de la categoría -->
        @forelse($category->products as $product)
            <div class="col-md-4">
                <!-- Tarjeta para mostrar detalles del producto -->
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Nombre del producto -->
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <!-- Enlace para ver detalles del producto -->
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">show Product</a>
                    </div>
                </div>
            </div>
        @empty
            <!-- Mensaje si no hay productos en la categoría -->
            <div class="col-md-12">
                <p>No hay productos disponibles en esta categoría.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
