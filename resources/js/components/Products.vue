<template>
    <div>
        <h1>Productos</h1>
        <button @click="showCreateForm">Agregar Producto</button>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.stock }}</td>
                    <td>{{ product.category.name }}</td>
                    <td>
                        <button @click="editProduct(product.id)">Editar</button>
                        <button @click="deleteProduct(product.id)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: []
        };
    },
    mounted() {
        this.fetchProducts();
    },
    methods: {
        fetchProducts() {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                });
        },
        showCreateForm() {
            // Lógica para mostrar el formulario de creación de producto
        },
        editProduct(id) {
            // Lógica para editar un producto
        },
        deleteProduct(id) {
            axios.delete(`/api/products/${id}`)
                .then(response => {
                    this.fetchProducts();
                })
                .catch(error => {
                    console.error('Error deleting product:', error);
                });
        }
    }
};
</script>
