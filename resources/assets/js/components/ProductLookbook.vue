<template>
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <div class="d-flex flex-sm-column justify-content-center align-items-center">
                <a role="button" v-for="(image, index) in product.images"
                    @click="select(index)"
                    class="mb-3 mr-2 mr-sm-0">
                        <loadable-image
                            skeleton-styles='{"width": "90px", "height": "90px"}'
                            image-styles='{"width": "90px", "height": "90px"}'
                            :image-source="image"
                            image-classes="background-image border border-dark clickable"
                            :image-alt="product.name"
                        ></loadable-image>
                    </a>
            </div>
        </div>
        <div class="col-sm-9 col-md-8 col-lg-6 col-xl-5 pl-0 pr-0">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center mb-2 position-relative mw-100">
                    <a role="button" class="position-absolute clickable left-0" @click="prevImage" title="Previous Image"><slot name="arrow-left"></slot></a>
                        <div v-if="showAddedToCartMessage" class="sq-400 position-absolute bg-overlay text-white d-flex justify-content-center align-items-center">
                            THE ITEM WAS ADDED TO YOUR CART
                        </div>
                        <loadable-image
                            skeleton-styles='{"width": "400px", "height": "400px"}'
                            image-styles='{"width": "400px", "height": "400px", "transition" : "all 0.5s"}'
                            :image-source="activeImage"
                            :image-alt="product.name"
                        ></loadable-image>
                    <a role="button" class="position-absolute clickable right-0" @click="nextImage" title="Next Image"><slot name="arrow-right"></slot></a>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <a role="button"
                        v-for="(image, index) in product.images"
                        class="unselected rounded-circle mr-1 clickable sq-10"
                        :class="{ 'selected' : index === selectedIndex }"
                        @click="select(index)"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-5 p-0 px-1 mb-2">
            <div class="pr-2 pt-2 d-flex justify-content-center position-relative border border-top-0 border-left-0 border-right-0 border-secondary mb-2">
                <h4 class="futura-medium p-0 align-self-center">{{ product.name }}</h4>
                <dropdown-list class="position-absolute p-0 m-0 right-0 bottom-0" name="Size" :items="product.sizes"></dropdown-list>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <a v-for="product in related"
                    @click="changeProduct(product)"
                    role="button"
                    class="clickable mr-2 border border-light sq-20"
                    :style="'background-color : ' + product.color"
                    :title="product.name + ' ' + product.color_name"></a>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="text-2xl text-red mr-4" v-if="product.on_sale">
                        <span class="font-weight-bold">${{ product.sale_price }}</span>
                </div>
            <span class="futura-medium text-xl" :class="{ 'line-through' : product.on_sale }">${{ product.price }}</span>
            </div>
            <p class="futura-medium m-0">Product Detail</p>
            <p class="p-2 mt-0 bg-grey-light">
                {{ product.description }}
            </p>
            <div class="d-flex-column">
                <div v-if="product.sold_out" class="btn btn-sold-out">
                    SOLD OUT
                </div>
                <div v-else>
                    <span v-if="errors" class="d-block">{{ errors[0] }}</span>
                    <button v-if="!showAddToCartFields" type="button" class="btn btn-brand mr-2" @click="showAddToCartFields = true">Add to cart</button>
                    <add-to-cart :product="product" :sizes="product.sizes" @item-added="addToCart" v-if="showAddToCartFields"></add-to-cart>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AddToCart from './AddToCart.vue';
    export default {
        props: ['dataProduct', 'dataModel'],

        components: {
            AddToCart,
        },

        data() {
            return {
                product : this.dataProduct,
                related : this.dataModel,
                selectedIndex : 0,
                showAddToCartFields : false,
                cartAddedQuantity: 0,
                showAddedToCartMessage: false,
                errors: null
            }
        },

        methods: {
            changeProduct(product) {
                this.product = product
                this.selectedIndex = 0
                history.pushState(null, null, this.product.slug)
            },
            select(index) {
                this.selectedIndex = index
            },
            nextImage() {
                if(this.selectedIndex == (this.product.images.length - 1)) {
                    this.selectedIndex = 0
                } else {
                    this.selectedIndex ++
                }
            },
            prevImage() {
                if(this.selectedIndex == 0) {
                    this.selectedIndex = (this.product.images.length - 1)
                } else {
                    this.selectedIndex --
                }
            },
            addToCart(item) {
                let vm = this
                axios.post(`/cart/items/store`, {
                    item: item
                }).then(({data}) => {
                    this.showAddToCartFields = false
                    this.showAddedToCartMessage = true
                    setTimeout(function(){
                        vm.showAddedToCartMessage = false
                    }, 1500);
                    Events.$emit('cart-updated')
                }).catch(({response}) => {
                    if(response.status == 422) {
                        this.errors = response.data.errors['item.article_id']
                        this.showAddToCartFields = false
                    }
                })
            }
        },
        computed: {
            activeImage() {
                return this.product.images[this.selectedIndex]
            },
        }
    }
</script>

<style>
    .unselected {
        background-color: white;
        border: 2px solid rgb(230,230,230);
    }
    .selected {
        background-color: rgb(230,230,230);
    }
</style>