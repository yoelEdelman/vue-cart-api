<template>
    <div class="productList flex flex-wrap">
        <div class="p-2 w-4/12" v-for="product in products">
            <div class="rounded overflow-hidden shadow-lg bg-white" >
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{product.name}}</div>
                    <p class="text-gray-700 text-base">
                        {{product.description}}
                    </p>
                </div>
                <div class="px-6 py-4 flex items-center">
                    <span class="inline-block bg-red-600 rounded-full px-3 py-1 text-sm font-semibold text-black mr-2">{{product.price / 100}} €</span>
                    <button @click="addToCart(product.id)"
                            class="bg-transparent flex-grow hover:bg-black text-black font-semibold hover:text-red-600 py-1 px-3 border border-black hover:border-transparent rounded">
                        Buy
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductList",
        props: [
            'products'
        ],
        components: {
        },
        data() {
            return {
            }
        },
        created() {

        },
        methods: {
            addToCart(product_id) {
                this.loading = true
                axios.post(`/api/cart`, {product_id: product_id})
                    .then(response => {
                        console.log(response)
                        this.$emit('updateCart', response.data)
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            },
        }
    }
</script>
