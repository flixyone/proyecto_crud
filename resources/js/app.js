import './bootstrap'
import { createApp } from 'vue';
import ProductCart from './components/ProductCart.vue';

const app = createApp({
	components: {
		ProductCart
	}
})

app.mount('#app');
