<template>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <img :src="imagePath">
        <div style="margin-top: -20px; width: 47%" class="d-flex-column">
            <p class="m-0 p-0">{{ product.name }}</p>
            <hr class="m-0 mb-2 p-0">
            <div class="d-flex justify-content-end">
                <a v-for="image in product.images" role="button" class="clickable mr-1" style="width: 10px; height: 10px;" :style="'background-color : ' + image.color" @click="changeImage(image.path)"></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],

        data() {
            return {
                imagePath: this.product.images[0].path
            }
        },

        methods: {
            changeImage(path) {
                this.imagePath = path
            }
        }
    }
</script>