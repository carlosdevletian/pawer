<template>
    <div class="position-relative">
        <div class="background-image bg-overlay m-0 p-0" role="img" :style="[imageBackground, additionalStyles]" :class="{ 'image-upload-banner' : isBanner }" draggable=true></div>
        <label class="position-absolute pin clickable d-flex justify-content-center align-items-center text-light bg-overlay md-hover-only m-0">
            <input type="file" class="pseudo-hidden w-100 h-100 clickable"
                    :name="fileName"
                    @change="updateImagePreview"
                    @dragenter="activateHover"
                    @dragleave="deactivateHover"
                    @drop="deactivateHover">
            <div v-if="withHover">
                <p class="futura-medium m-0 text-bold text-xl" v-text="hoverText"></p>
                <div class="text-center text-3xl">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 6c0-1.1.9-2 2-2h3l2-2h6l2 2h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm10 10a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                </div>
            </div>
        </label>
        <span class="close-icon position-absolute top-0 clickable" style="top:5px; right:10px" v-if="deletable" role="button" @click="close" title="Delete this image">
            <svg style="width: 10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            'defaultImage' : {
                type: String,
                default : '/images/placeholder-image.png'
            },
            'fileName' : {
                type: String,
                required: true
            },
            'isBanner' : {
                type : Boolean,
                default: true
            },
            'imageStyles' : {
                type : Object,
                required : false
            },
            'hoverText' : {
                type : String,
                required : false,
                default : 'Upload an image'
            },
            'withHover' : {
                type : Boolean,
                required : false,
                default : true
            },
            'deletable' : {
                type : Boolean,
                required : false,
                default : false
            }
        },

        data() {
            return {
                imagePreview: this.defaultImage,
            }
        },

        computed: {
            imageBackground() {
                return { backgroundImage : `url('${this.imagePreviewPath}')`}
            },
            additionalStyles() {
                if(this.imageStyles) return this.imageStyles
            },
            imagePreviewPath() {
                return this.imagePreview !== null ? this.imagePreview : '/images/placeholder-image.png'
            }
        },

        methods: {
            updateImagePreview(e) {
                if(! e.target.files.length) {
                    this.imagePreview = null
                    return
                }

                let image = e.target.files[0]
                let reader = new FileReader()
                reader.onload = e => {
                    this.imagePreview = e.target.result
                }
                reader.readAsDataURL(image)
            },
            close() {
                this.$emit('closed');
            },
            activateHover(event) {
                event.target.parentElement.classList.remove('md-hover-only')
            },
            deactivateHover(event) {
                event.target.parentElement.classList.add('md-hover-only')
            }
        }
    }
</script>
<style>
    .close-icon:hover {
        fill: white;
    }
</style>