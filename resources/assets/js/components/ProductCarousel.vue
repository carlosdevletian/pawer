<template>
    <div class="row" style="position: relative">
        <carousel-3d width="250" height="300" space=300 perspective=0 ref="carousel">
            <slide v-for="(product, index) in products"
                    :index="parseInt(index)"
                    :key="product.id"
                    class="border-0"
                    style="background-color: white">
                <product :data-product="product" data-active="parent"></product>
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
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    1 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    2 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    3 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    4 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    5 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    6 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
                    },
                    7 : {
                        0: {
                            'id' : 1,
                            'code' : 'code1',
                            'name' : 'KOBI',
                            'color' : 'green',
                            'images' : [
                                '/images/product-thumbnail-2.png',
                            ],
                        },
                        1: {
                            'color' : 'black',
                            'image' : '/images/product-thumbnail.png',
                        }
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
