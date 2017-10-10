<template>
    <div class="row" style="position: relative">
        <carousel-3d width="250" height="300" space=300 perspective=0 ref="carousel">
            <slide v-for="(product, index) in products"
                    :index="parseInt(index)"
                    :key="product.id"
                    class="border-0"
                    style="background-color: white">
                <product :product="product" data-active="parent"></product>
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

        data() {
            return {
                products : {
                    0 : {
                        'id' : 1,
                        'code' : 'code1',
                        'name' : 'KOBI',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                        ],
                    },
                    1 : {
                        'id' : 2,
                        'code' : 'code2',
                        'name' : 'BRYAN',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                    2 : {
                        'id' : 3,
                        'code' : 'code3',
                        'name' : 'PAWER',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                    3 : {
                        'id' : 4,
                        'code' : 'code4',
                        'name' : 'ANDRES',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                    4 : {
                        'id' : 5,
                        'code' : 'code5',
                        'name' : 'AGUALOCA',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                    5 : {
                        'id' : 6,
                        'code' : 'code6',
                        'name' : 'MODELO',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                    6 : {
                        'id' : 7,
                        'code' : 'code7',
                        'name' : 'GORRA',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                    7 : {
                        'id' : 8,
                        'code' : 'code8',
                        'name' : 'INTERIOR',
                        'images' : [
                            {
                                'path' : '/images/product-thumbnail.png',
                                'color' : 'black',
                            },
                            {
                                'path' : '/images/product-thumbnail-2.png',
                                'color' : 'green',
                            },
                        ],
                    },
                }
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
