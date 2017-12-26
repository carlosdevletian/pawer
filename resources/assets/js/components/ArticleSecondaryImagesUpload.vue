<template>
    <div class="mw-100 mh-100" style="overflow-x: scroll; overflow-y: scroll">
        <div v-if="imageInputs" v-for="(input, index) in imageInputs" class="mb-3 mr-2 mr-sm-0 d-inline-block" :key="input">
            <image-upload is="image-upload"
                        file-name="regular_images[]"
                        :is-banner="false"
                        style="width: 90px; height: 90px;"
                        :image-styles="{minWidth: '100%', minHeight: '100%'}"
                        :with-hover="false"
                        :deletable="true"
                        @closed="imageInputs.splice(index, 1)"></image-upload>
        </div>
        <a role="button" ref="addImageIcon" @click="addImageInput" class="add-image-icon mb-3 mr-2 mr-sm-0 clickable background-image d-inline-block" style="width: 90px; height: 90px; background-image: url('/images/add-image.png')" title="Add more images"></a>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                imageInputs : [],
                inputCount : 0
            }
        },

        methods : {
            addImageInput() {
                this.imageInputs.push( this.inputCount++ )
            },
        }
    }
</script>
<style>
.add-image-icon:hover {
    filter: brightness(75%);
}
</style>