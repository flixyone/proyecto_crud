<template>
    <div>
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in cartItems" :key="product.id">
                    <td>
                        <img :src="'/images/' + (product.product.image || 'default-product-image.jpg')" alt="" style="max-height: 50px;">
                    </td>
                    <td>
                        {{ product.product.name || 'Product not available' }}
                    </td>
                    <td>
                        <input type="number" v-model.number="product.quantity" min="1" class="form-control form-control-sm d-inline" style="width: 70px;">
                        <button type="button" class="btn btn-primary btn-sm mt-1" @click="updateProduct(product.id)">Update</button>
                    </td>
                    <td>
                        ${{ product.product.price || 0 }}
                    </td>
                    <td>
                        ${{  parseFloat((product.product.price || 0) * product.quantity).toFixed(2)}}
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" @click="removeProduct(product.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Total Products:</strong></td>
                    <td><strong>{{ totalQuantity }}</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td><strong>Total Price:</strong></td>
                    <td><strong>${{ totalPrice }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    cartItems: Array,
    totalQuantity: Number,
    totalPrice: Number
});

const emit = defineEmits(['update', 'remove']);

const cartItems = ref(props.cartItems);
const totalQuantity = ref(props.totalQuantity);
const totalPrice = ref(props.totalPrice);

function updateProduct(id) {
    const product = cartItems.value.find(item => item.id === id);
    axios.put(`/cart/update/${id}`, { quantity: product.quantity })
        .then(response => {
            console.log(response.data.success);
            Swal.fire({
                icon: 'success',
                title: 'Product Updated',
                text: response.data.success,
                timer: 1000, // Tiempo en milisegundos para mantener la alerta abierta (opcional)
                timerProgressBar: true, // Mostrar una barra de progreso del temporizador (opcional)
                showConfirmButton: false // No mostrar el botón de confirmación
            });
            setTimeout(()=>{emit('update');
            window.location.reload()},1000)
             // Recargar la página después de actualizar
        })
        .catch(error => {
            Swal.fire({
            icon: 'warning',
            title: 'Stock Exceeded',
            text:error.response.data.error,
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: true // Mostrar el botón de confirmación
        });
        });
}

function removeProduct(id) {
    axios.delete(`/cart/remove/${id}`)
        .then(response => {
            console.log(response.data.success);
            Swal.fire({
                icon: 'success',
                title: 'Product Delete',
                text: response.data.success,
                timer: 1000, // Tiempo en milisegundos para mantener la alerta abierta (opcional)
                timerProgressBar: true, // Mostrar una barra de progreso del temporizador (opcional)
                showConfirmButton: false // No mostrar el botón de confirmación
            });
            setTimeout(()=>{emit('remove');
            window.location.reload()},1000)
             // Recargar la página después de actualizar

        })
        .catch(error => {
            console.error(error.response.data.error);
        });
}

function fetchCartData() {
    axios.get('/cart')
        .then(response => {
            const data = response.data;
            cartItems.value = data.cartItems;
            totalQuantity.value = data.totalQuantity;
            totalPrice.value = data.totalPrice;
        })
        .catch(error => {
            console.error(error.response.data.error);
        });


}
</script>

