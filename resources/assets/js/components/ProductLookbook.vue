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
                <div class="d-flex align-items-center justify-content-center mb-2" style="position: relative; max-width: 100%">
                    <a style="left: 0" role="button" class="position-absolute clickable" @click="prevImage" title="Previous Image"><slot name="arrow-left"></slot></a>
                        <loadable-image
                            skeleton-styles='{"width": "400px", "height": "400px"}'
                            image-styles='{"width": "400px", "height": "400px", "transition" : "all 0.5s"}'
                            :image-source="activeImage"
                            :image-alt="product.name"
                        ></loadable-image>
                    <a style="right: 0" role="button" class="position-absolute clickable" @click="nextImage" title="Next Image"><slot name="arrow-right"></slot></a>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <a role="button"
                        v-for="(image, index) in product.images"
                        class="unselected rounded-circle mr-1 clickable"
                        :class="{ 'selected' : index === selectedIndex }"
                        style="height: 10px; width: 10px"
                        @click="select(index)"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-5 p-0 px-1">
            <div class="pr-2 pt-2 d-flex flex-column justify-content-center align-items-center border border-top-0 border-left-0 border-right-0 border-secondary mb-2">
                <h4 class="futura-medium p-0">{{ product.name }}</h4>
                <div class="d-flex justify-content-between w-100 mt-2">
                    <small v-for="size in product.sizes" v-text="size"></small>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <a v-for="product in related"
                    @click="changeProduct(product)"
                    role="button"
                    class="clickable mr-2 border border-light" style="width: 20px; height: 20px;"
                    :style="'background-color : ' + product.color"
                    :title="product.name + '-' + product.color"></a>
            </div>
            <p class="futura-medium m-0">Product Detail</p>
            <p class="p-2 mt-0" style="background-color: rgb(230,230,230)">
                {{ product.description }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dataProduct', 'dataModel'],

        data() {
            return {
                product : this.dataProduct,
                related : this.dataModel,
                selectedIndex : 0
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