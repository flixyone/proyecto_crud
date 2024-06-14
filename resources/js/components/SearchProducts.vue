<template>
    <div>
        <h1>Buscar Productos</h1>
        <input type="text" v-model="query" @input="searchProducts">
        <div v-if="products.length">
            <h2>Resultados de Búsqueda</h2>
            <div v-for="product in products" :key="product.id">
                <div>
                    <h3>{{ product.name }}</h3>
                    <p>{{ product.description }}</p>
                    <p>Precio: ${{ product.price }}</p>
                    <button @click="showProductDetails(product.id)">Ver Detalles</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p>No se encontraron productos.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            query: '',
            products: []
        }
    },
    methods: {
        searchProducts() {
            // Aquí puedes hacer la solicitud HTTP para buscar productos según el query
            // Por ejemplo, utilizando axios
            axios.get(`/api/products/search?query=${this.query}`)
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error('Error al buscar productos:', error);
                });
        },
        showProductDetails(productId) {
            // Aquí puedes redirigir al usuario a la página de detalles del producto
            window.location.href = `/products/${productId}`;
        }
    }
}
</script>
