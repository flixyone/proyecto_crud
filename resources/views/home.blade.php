@extends('layouts.app')

@section('content')
<!-- Contenedor principal -->
<div class="container">
    <!-- Fila para mostrar las categorías -->
    <div class="row">
        <!-- Iterar sobre cada categoría -->
        @foreach($categories as $category)
            <!-- Columna para cada categoría -->
            <div class="col-md-4">
                <!-- Tarjeta para mostrar los productos de la categoría -->
                <div class="card mb-3">
                    <!-- Encabezado de la tarjeta con el nombre de la categoría -->
                    <div class="card-header">
                        <h5 class="card-title">{{ $category->name }}</h5>
                    </div>
                    <!-- Lista de productos de la categoría -->
                    <ul class="list-group list-group-flush">
                        <!-- Iterar sobre los primeros 5 productos de la categoría -->
                        @foreach($category->products->take(5) as $product)
                            <!-- Elemento de la lista para cada producto -->
                            <li class="list-group-item">
                                <!-- Enlace para ver los detalles del producto -->
                                <a href="{{ route('products.show', $product->id) }}">
                                    <!-- Fila para mostrar el producto -->
                                    <div class="row">
                                        <!-- Columna para la imagen del producto -->
                                        <div class="col-md-4">
                                            <!-- Verificar si hay una imagen del producto -->
                                            @if($product->image)
                                                <!-- Mostrar la imagen del producto -->
                                                <img src="{{ asset('images/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}" style="max-height: 100px;">
                                            @else
                                                <!-- Si no hay imagen, mostrar una imagen por defecto -->
                                                <img src="{{ asset('images/default-product-image.jpg') }}" class="img-fluid mb-3" alt="Imagen por defecto" style="max-width: 100px; max-height: 100px;">
                                            @endif
                                        </div>
                                        <!-- Columna para el nombre y precio del producto -->
                                        <div class="col-md-8">
                                            <!-- Nombre y precio del producto -->
                                            {{ $product->name }} - {{ $product->price }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <!-- Pie de la tarjeta con enlace para ver más productos -->
                    <div class="card-footer">
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary">See more products</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
