@extends('layouts.app')

@section('content')
<!-- Contenedor principal -->
<div class="container">
    <!-- Fila para centrar el contenido -->
    <div class="row">
        <!-- Columna principal -->
        <div class="col-md-8 offset-md-2">
            <!-- Tarjeta para mostrar los detalles del producto -->
            <div class="card">
                <!-- Encabezado de la tarjeta con el nombre del producto -->
                <div class="card-header">{{ $product->name }}</div>
                <!-- Cuerpo de la tarjeta -->
                <div class="card-body">
                    <!-- Verificar si hay una imagen del producto -->
                    @if($product->image)
                        <!-- Mostrar la imagen del producto -->
                        <img src="{{ asset('images/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}" style="max-height: 200px;">
                    @else
                        <!-- Si no hay imagen, mostrar una imagen por defecto -->
                        <img src="{{ asset('images/default-product-image.jpg') }}" class="img-fluid mb-3" alt="Imagen por defecto" style="max-width: 200px; max-height: 200px;">
                    @endif

                    <!-- Descripción del producto -->
                    <p>{{ $product->description }}</p>
                    <!-- Precio del producto -->
                    <p>Precio: ${{ $product->price }}</p>
                    <!-- Stock del producto -->
                    <p>Stock: {{ $product->stock }}</p>
                    <!-- Formulario para agregar el producto al carrito -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <!-- Botón para agregar al carrito -->
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
