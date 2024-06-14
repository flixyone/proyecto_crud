@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            @can('create products')
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProductModal">Create Product</button>
            @endcan
        </div>
    </div>

    <table id="productsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if($product->image && file_exists(public_path('images/' . $product->image)))
                        <img src="{{ asset('images/' . $product->image) }}" class="img-fluid" style="max-height: 100px;" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/default-product-image.jpg') }}" class="img-fluid" style="max-height: 100px;" alt="Default Product Image">
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category ? $product->category->name : 'No category' }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View</a>
                        @can('edit products')
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editProductModal{{ $product->id }}">Update</button>
                        @endcan
                        @can('delete products')
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>

            <!-- Edicion del modal producto -->
            <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                @include('products.form', ['product' => $product])
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Creacion del modal producto -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Create Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @include('products.form', ['product' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#productsTable').DataTable();

        // Función para abrir el modal de edición al hacer clic en el botón "Update"
        $('.edit-product-btn').on('click', function() {
            var productId = $(this).data('product-id');
            $('#editProductModal' + productId).modal('show');
        });
    });
</script>

@endpush
