<div class="form-group">
    <!-- Etiqueta para el campo de nombre -->
    <label for="name">Name</label>
    <!-- Campo de entrada para el nombre -->
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required pattern="[a-zA-Z\s]+">
</div>
<div class="form-group">
    <!-- Etiqueta para el campo de descripción -->
    <label for="description">Description</label>
    <!-- Campo de entrada para la descripción -->
    <textarea class="form-control" id="description" name="description" required>{{ old('description', $product->description ?? '') }}</textarea>

</div>


<div class="form-group">
    <!-- Etiqueta para el campo de precio -->
    <label for="price">Price</label>
    <!-- Campo de entrada para el precio -->
    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required>
</div>
<div class="form-group">
    <!-- Etiqueta para el campo de stock -->
    <label for="stock">Stock</label>
    <!-- Campo de entrada para el stock -->
    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
</div>
<div class="form-group">
    <label for="category_id">Categoría</label>
    <select class="form-control" id="category_id" name="category_id" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    
</div>

<div class="form-group">
    <!-- Etiqueta para el campo de imagen -->
    <label for="image">Image</label>
    <!-- Campo de carga de imagen -->
    <input type="file" class="form-control" id="image" name="image">
</div>
