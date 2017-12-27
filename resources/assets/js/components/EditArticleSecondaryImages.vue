<template>
    <div class="mw-100 mh-100" style="overflow-x: scroll; overflow-y: scroll">
        <div v-if="secondaryImages" v-for="(image, index) in secondaryImages" class="mb-3 mr-2 mr-sm-0 d-inline-block" :key="image.relative">
            <input type="hidden" :name="`secondary_images[]`" v-model="secondaryImages[index]['relative']">
            <image-upload is="image-upload"
                        :file-name="`secondary_images[]`"
                        :default-image="defaultImage(image)"
                        :is-banner="false"
                        style="width: 90px; height: 90px;"
                        :image-styles="{minWidth: '100%', minHeight: '100%'}"
                        :with-hover="false"
                        :deletable="true"
                        @closed="deleteImage(index)"></image-upload>
        </div>
        <a role="button" ref="addImageIcon" @click="addImageInput" class="add-image-icon mb-3 mr-2 mr-sm-0 clickable background-image d-inline-block" style="width: 90px; height: 90px; background-image: url('/images/add-image.png')" title="Add more images"></a>
    </div>
</template>

<script>
    export default {
        props: {
            'dataSecondaryImages' : {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                secondaryImages : this.dataSecondaryImages
            }
        },

        created() {
        },

        methods : {
            deleteImage(index) {
                Vue.set(this.secondaryImages, index, {
                    relative: null,
                    absolute: null
                })
            },
            addImageInput() {
                this.secondaryImages.push('')
            },
            defaultImage(image) {
                return image.absolute ? `${image.absolute}` : '/images/placeholder-image.png'
            }
        },
    }
</script>
<style>
.add-image-icon:hover {
    filter: brightness(75%);
}
</style>