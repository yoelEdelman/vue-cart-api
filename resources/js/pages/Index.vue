<template>
    <div class="index bg-black">
        <nav class="flex items-center justify-between bg-red-600 p-6">
            <div class="flex items-center flex-shrink-0 text-black mr-6">
                <span class="font-semibold text-xl tracking-tight">Laravel E-commerce API</span>
            </div>
            <div class="w-full block flex-grow flex items-center w-auto justify-end text-black">
                <div class="font-bold">{{getTotalCart}} items in cart ({{getTotalPrice}} €)</div>
            </div>
        </nav>

        <section id="main" class="p-5">
            <div class="w-full flex">
                <div class="w-8/12" id="productsList">
                    <ProductList :products="products"
                                 @updateCart="updateCart"></ProductList>
                </div>
                <div class="w-4/12">
                    <Cart :cart="cart"
                          @deleteAllCart="cart = []"
                          @deleteCart="removeFromCart"></Cart>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import ProductList from '../components/ProductList.vue'
    import Cart from '../components/Cart.vue'

    export default {
        name: "Index",
        components: {
            ProductList,
            Cart
        },
        data() {
            return {
                loading: false,
                products: [],
                cart: []
            }
        },
        created() {
            this.getProducts()
            this.getCart()
        },
        computed: {
            getTotalCart() {
                return this.cart.reduce((a, b) => a + (b['quantity'] || 0), 0);
            },
            getTotalPrice() {
                let price = 0
                this.cart.forEach(cart => {
                    price += cart.product.price * cart.quantity
                })
                return (price / 100).toFixed(2)
            },
        },
        methods: {
            getProducts() {
                this.loading = true
                axios.get(`/api/products`)
                    .then(response => {
                        console.log(response)
                        this.products = response.data
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            },
            getCart() {
                this.loading = true
                axios.get(`/api/cart`)
                    .then(response => {
                        console.log(response)
                        this.cart = response.data
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            },
            removeFromCart(product_id) {
                let cartIndex = this.cart.findIndex(cart => cart.product_id === product_id)
                if (cartIndex !== -1) {
                    this.cart.splice( cartIndex, 1)
                }
            },
            updateCart(product) {
                let productIndex = this.cart.findIndex(prod => prod.product_id === product.product_id)
                if (productIndex === -1) {
                    this.cart.push(product)
                } else {
                    this.cart.splice(productIndex, 1, product)
                }

            }
        }
    }
</script>

<style scoped lang="scss">
    #productsList {
        border-right: 1px solid #E53E3E;
    }
    .chip {
        padding: 0 3px;
        right: 5px;
        top: -5px
    }
</style>
