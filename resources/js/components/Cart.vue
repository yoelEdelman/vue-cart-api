<template>
    <div class="productList flex flex-wrap">
        <div class="p-2 w-full">
            <div class="rounded overflow-hidden shadow-lg bg-white" >
                <div class="font-bold text-xl mb-2 flex bg-gray-200 px-6 py-3">
                    <svg class="fill-current h-8 w-8 mr-2 p-1" height="512" viewBox="0 0 511.343 511.343" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m490.334 106.668h-399.808l-5.943-66.207c-.972-10.827-10.046-19.123-20.916-19.123h-42.667c-11.598 0-21 9.402-21 21s9.402 21 21 21h23.468c12.825 142.882-20.321-226.415 24.153 269.089 1.714 19.394 12.193 40.439 30.245 54.739-32.547 41.564-2.809 102.839 50.134 102.839 43.942 0 74.935-43.826 59.866-85.334h114.936c-15.05 41.455 15.876 85.334 59.866 85.334 35.106 0 63.667-28.561 63.667-63.667s-28.561-63.667-63.667-63.667h-234.526c-15.952 0-29.853-9.624-35.853-23.646l335.608-19.724c9.162-.538 16.914-6.966 19.141-15.87l42.67-170.67c3.308-13.234-6.71-26.093-20.374-26.093zm-341.334 341.337c-11.946 0-21.666-9.72-21.666-21.667s9.72-21.667 21.666-21.667c11.947 0 21.667 9.72 21.667 21.667s-9.72 21.667-21.667 21.667zm234.667 0c-11.947 0-21.667-9.72-21.667-21.667s9.72-21.667 21.667-21.667 21.667 9.72 21.667 21.667-9.72 21.667-21.667 21.667zm47.366-169.726-323.397 19.005-13.34-148.617h369.142z"/></svg>
                    Cart :
                </div>
                <div class="px-6 py-4">
                    <div class="text-gray-700 list">
                        <transition-group name="list" tag="div">
                            <div class="flex justify-between items-center py-2 cart-item transitionItem"
                                 v-for="cartItem in cart"
                                 :key="cartItem.id">
                                <p class="">
                                    x{{cartItem.quantity}} {{cartItem.product.name}} - {{cartItem.quantity * cartItem.product.price / 100}} €
                                </p>
                                <div class="flex items-center">
                                    <button @click="deleteCart(cartItem.product_id)"
                                            class="bg-transparent flex-grow hover:bg-red-600 text-red-600 font-semibold hover:text-black py-1 px-3 border border-red-600 hover:border-transparent rounded">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </transition-group>
                    </div>
                    <button @click="deleteAllCart" class="w-full mt-3 bg-transparent hover:bg-red-600 text-red-600 font-semibold hover:text-black py-1 px-3 border border-red-600 hover:border-transparent rounded">
                        Remove all products
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
            'cart'
        ],
        components: {
        },
        data() {
            return {
                loading: false,
                cartItems: []
            }
        },
        created() {

        },
        methods: {
            deleteCart(product_id) {
                if (!this.loading) {
                    this.loading = true
                    axios.delete(`/api/cart/${product_id}`)
                        .then(response => {
                            console.log(response)
                            this.$emit('deleteCart', product_id)
                            this.loading = false
                        })
                        .catch(error => console.log(error))
                }
            },
            deleteAllCart() {
                if (!this.loading) {
                    this.loading = true
                    axios.delete(`/api/cart`)
                        .then(response => {
                            console.log(response)
                            this.$emit('deleteAllCart')
                            this.loading = false
                        })
                        .catch(error => console.log(error))
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .cart-item {
        border-bottom: 1px solid #dddddd;
    }

    .list-enter, .list-leave-to {
        opacity: 0;
        transform: translateX(-50px);
    }
    .list-leave-active {
        position: absolute;
        /*z-index: 10;*/
    }
    .list-move {
        transition: transform 0.5s;
    }
    .transitionItem {
        transition: all 0.5s;
    }
</style>
