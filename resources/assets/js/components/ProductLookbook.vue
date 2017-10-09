<template>
    <div class="row">
        <div class="col-sm-3 col-lg-2 pl-sm-5 pr-0">
            <div class="d-flex flex-sm-column justify-content-center">
                <a role="button" v-for="(image, index) in product.images"
                    class="background-image border border-dark mb-3 mr-2 mr-sm-0 clickable"
                    :style="'background-image: url(' + image + '); width: 90px; height: 90px'"
                    @click="select(index)"></a>
            </div>
        </div>
        <div class="col-sm-9 col-md-8 col-lg-7 col-xl-5 pl-0 pr-0">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center mb-2" style="position: relative; max-width: 100%">
                    <a style="position: absolute; left: 0" role="button" class="clickable" @click="prevImage"><slot name="arrow-left"></slot></a>
                    <div class="background-image" :style="'background-image: url(' + activeImage + '); width: 400px; height: 400px; transition: background-image 0.5s'"></div>
                    <a style="position: absolute; right: 0" role="button" class="clickable" @click="nextImage"><slot name="arrow-right"></slot></a>
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
        <div class="col-lg-3 col-xl-5 p-0 px-4">
            <div class="pr-2 pt-2 d-flex justify-content-between align-items-center border border-top-0 border-left-0 border-right-0 border-secondary mb-2">
                <h4 class="futura-medium p-0">{{ product.name }}</h4>
                <small>ONE-SIZE</small>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <a v-for="color in product.colors" role="button" class="clickable mr-2 border border-light" style="width: 20px; height: 20px;" :style="'background-color : ' + color"></a>
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
        data() {
            return {
                product : {
                    name : 'Ruca Snapsack',
                    description : `Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.`,
                    colors : [
                        'red',
                        'blue',
                        'green',
                        'orange',
                    ],
                    images : [
                        'images/gorra1.png',
                        'images/gorra2.png',
                        'images/gorra3.png',
                        'images/gorra4.png',
                        'images/gorra5.png',
                    ]
                },
                selectedIndex : 0
            }
        },
        methods: {
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