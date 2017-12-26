<template>
    <div class="d-flex flex-column justify-content-center align-items-center mb-3">
        <a :href="linkTo" v-if="linkTo">
            <img :src="imagePath" class="fit-to-parent">
        </a>
        <img v-else :src="imagePath" class="fit-to-parent">
        <div style="margin-top: 0; width: 47%" class="d-flex-column" v-if="active">
            <p class="m-0 p-0 futura-medium">{{ product.name }}</p>
            <hr class="m-0 mb-2 p-0">
            <div class="d-flex justify-content-end">
                <a v-for="color in allColors" role="button" class="clickable mr-1" style="width: 10px; height: 10px;" :style="'background-color : ' + color.color" @click="changeImage(color.image)"></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dataProduct', 'dataActive', 'linkTo'],

        data() {
            return {
                product : '',
                imagePath: '',
                allProducts: '',
                associated: '',
            }
        },

        created() {
            this.product = this.dataProduct[0]
            this.imagePath = this.product.main_image_path,
            this.allProducts = Array.from(this.dataProduct);
        },

        methods: {
            changeImage(path) {
                this.imagePath = path
            }
        },

        computed : {
            active() {
                if(this.dataActive == 'parent') {
                    return this.$parent.isCurrent
                }
                return this.dataActive
            },

            allColors() {
                let colors = {};
                this.allProducts.forEach((product, index) =>
                    colors[index] = {
                        'color' : product.color,
                        'image' : product.main_image_path
                    }
                );
                return colors;
            }
        }
    }
</script>