<template>
    <div class="row position-relative">
        <h2 class="position-absolute w-100 text-center mt-2 mb-2 text-brand-primary bg-white" style="z-index:1">
            FEATURED PRODUCTS
        </h2>
        <carousel-3d width="250" height="300" space=300 perspective=0 ref="carousel">
            <slide v-for="(product, index) in products"
                    :index="parseInt(index)"
                    :key="product[0].id"
                    class="border-0"
                    style="background-color: white">
                <product :data-product="product" data-active="parent" :with-link="true"></product>
            </slide>
        </carousel-3d>
        <a role="button" class="carousel-control-prev clickable" @click="previousProduct">
            <slot name="arrow-left">
                <
            </slot>
        </a>
        <a role="button" class="carousel-control-next clickable" @click="nextProduct">
            <slot name="arrow-right">
                >
            </slot>
        </a>
    </div>
</template>

<script>
    import {Carousel3d, Slide} from 'vue-carousel-3d';

    export default {
        components: {Carousel3d, Slide},

        props: ['dataProducts'],

        data() {
            return {
                products : this.dataProducts
            }
        },

        methods: {
            nextProduct() {
                this.$refs.carousel.goNext()
            },
            previousProduct() {
                this.$refs.carousel.goPrev()
            },
        }
    }
</script>
