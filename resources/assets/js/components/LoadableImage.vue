<template>
    <div>
        <div v-if="! imageHasLoaded" class="animated-background" :style="skeletonStyle"></div>
        <img v-else :src="imageSource" :class="imageClasses" :style="imageStyle" :alt="imageAlt">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            'imageSource' : {
                required: true
            },
            'skeletonStyles' : {
                required: true
            },
            'imageStyles' : {
                required: true
            },
            'imageClasses' : {
                required : false
            },
            'imageAlt' : {
                required : true
            }
        },

        data() {
            return {
                imageLoaded : false
            }
        },

        computed : {
            imageStyle() {
                return JSON.parse(this.imageStyles)
            },
            skeletonStyle() {
                return JSON.parse(this.skeletonStyles)
            },
            imageHasLoaded() {
                var image = new Image()
                image.src = this.imageSource
                image.onload = () => this.imageLoaded = true
                if (image.complete) image.onload.call(image)
                return this.imageLoaded
            },
        }

    }
</script>