<template>
    <modal-template @close="close()" :overflow-y="true" class="text-white">
        <h3 v-if="! orderSent" slot="header" class="text-uppercase">My cart</h3>
        <div slot="body" v-if="! cartDataHasLoaded" class="position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="loader"></div>
            </div>
        </div>
        <div slot="body" v-if="cartDataHasLoaded">
            <div v-if="sendingEmail">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="loader"></div>
                </div>
            </div>
            <div v-if="orderSent">
                <div class="text-center">
                    <svg-mono class="icon-w-3 icon-h-3"></svg-mono>
                    <h3>Thank you!</h3>
                    <p class="text-2xl">We will be contacting you shortly. Feel free to keep shopping in the meantime</p>
                </div>
            </div>
            <div v-if="! sendingEmail && ! orderSent">
                <div v-if="items.length > 0">
                    <div v-for="item in items" class="bg-white text-black mb-2 m-sm-4 p-2 p-sm-4 d-flex flex-column flex-md-row position-relative">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <loadable-image
                                skeleton-styles='{"width": "150px", "height": "150px"}'
                                image-styles='{"maxWidth": "150px", "maxHeight": "150px"}'
                                :image-source="item.article.images[0]"
                                image-classes="fit-to-parent"
                                :image-alt="item.name"
                            ></loadable-image>
                            <a role="button" class="text-center text-grey-darker clickable" @click="removeItemFromCart(item)">Remove</a>
                        </div>
                        <div class="w-1 d-none d-md-block"></div>
                        <div class="text-grey-darkest d-flex flex-column text-center md:text-left">
                            <a :href="item.article.links.show"><h5 class="m-0 text-grey-darkest mb-1 hover:text-brand-primary">{{ item.name }}</h5></a>
                            <p class="futura-medium m-0 mb-1">Color: <span class="text-grey-darker">{{ item.article.color_name }}</span></p>
                            <p class="futura-medium m-0 mb-1">Quantity: <span class="text-grey-darker">{{ item.quantity }}</span></p>
                            <p class="futura-medium m-0 mb-1">Size: <span class="text-grey-darker">{{ item.size.name }}</span></p>
                            <p class="futura-medium m-0">Price: <span class="text-grey-darker">${{ item.article.price }}</span></p>
                            <p class="futura-medium m-0 mt-1 d-md-none text-2xl">${{ item.total_price }}</p>
                        </div>
                        <div class="position-absolute right-0 d-none d-md-block text-2xl" style="bottom: 50%; left: 80%">${{ item.total_price }}</div>
                    </div>
                    <div class="d-block d-md-flex justify-content-between text-center">
                        <div class="text-2xl mr-md-4 order-md-2"><span class="text-base">Total:</span> ${{ totalAmount }}</div>
                        <button  v-if="!showEmailField" type="button" class="btn btn-brand rounded-0 ml-md-4 order-md-1" @click="showEmailField = true">MAKE ORDER</button>
                        <transition name="cubic">
                            <form @submit.prevent="sendOrderEmail" v-if="showEmailField" class="d-flex cubic order-md-1 mw-100 justify-content-center">
                                <div class="ml-md-4 mb-0">
                                    <input class="h-100 border border-white px-2 px-md-4 py-2" type="email" v-model="email" required placeholder="Your email here" v-focus></input>
                                </div>
                                <button type="submit" class="btn btn-brand rounded-0 d-none d-sm-block">SEND</button>
                                <button type="submit" class="btn btn-brand rounded-0 d-flex justify-content-center align-items-center d-sm-none m-none">
                                    <svg class="fill-current rounded-circle" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 0l20 10L0 20V0zm0 8v4l10-2L0 8z"/></svg>
                                </button>
                            </form>
                        </transition>
                    </div>
                </div>
                <div v-if="! items.length > 0" class="text-center">
                    <p class="futura-medium m-0">Seems like you haven't selected any items... </p>
                    <p class="futura-medium">While browsing through our site you can add items to the cart and send us an email with your order</p>
                    <div class="mt-4 mb-4 d-flex justify-content-center align-items-center m-auto sq-200">
                        <svg class="fill-current text-white" height="150" width="150"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 2h16l-3 9H4a1 1 0 1 0 0 2h13v2H4a3 3 0 0 1 0-6h.33L3 5 2 2H0V0h3a1 1 0 0 1 1 1v1zm1 18a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm10 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                    </div>
                    <a class="btn btn-brand rounded-0 w-100" href="/catalog">Shop around Ugo's cave</a>
                </div>
            </div>
        </div>
    </modal-template>
</template>

<script>
    import ModalTemplate from "./ModalTemplate"
    export default {
        components: {
            ModalTemplate
        },

        data() {
            return {
                items : {},
                cartDataHasLoaded : false,
                showEmailField : false,
                email : '',
                sendingEmail : false,
                orderSent : false
            }
        },

        mounted() {
            this.getCartData()
        },

        computed: {
            totalAmount() {
                let total = 0;
                if(this.items.length > 0) {
                    this.items.forEach((item) => total+=parseFloat(item.total_price))
                }
                return total.toFixed(2)
            }
        },

        methods: {
            close() {
                this.$emit('close')
            },
            getCartData() {
                axios.get(`/cart/items/index`).then(({data}) => {
                    this.items = data.items ? data.items : ''
                    Vue.nextTick(() => this.cartDataHasLoaded = true)
                })
            },
            removeItemFromCart(item) {
                axios.delete(`/cart/items/delete`, {
                    data: {
                        item : JSON.stringify(item)
                    }
                }).then(({data}) => {
                    this.getCartData()
                })
            },
            resetCart() {
                axios.delete(`/cart/items/all`)
            },
            sendOrderEmail() {
                this.sendingEmail = true
                axios.post(`/orders/email`, {
                    email : this.email
                }).then(() => {
                    this.sendingEmail = false
                    this.orderSent = true
                    this.resetCart()
                })
            }
        }
    }
</script>

<style>
    .cubic {
        transition: all 0.6s cubic-bezier(0.23, 1.85, 0.32, 1);
    }
    .cubic-enter {
        -webkit-transform: translateX(-100%);
        transform: translateX(-100%);
        opacity: 0;
    }
</style>