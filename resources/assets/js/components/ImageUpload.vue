<template>
    <div class="position-relative">
        <div class="background-image image-upload-banner bg-overlay m-0 p-0" role="img" :style="bannerStyles"></div>
        <label class="position-absolute pin clickable d-flex justify-content-center align-items-center text-light bg-overlay md-hover-only m-0">
            <input type="file" class="pseudo-hidden" name="category_image" @change="updateImagePreview">
            <div>
                <p class="futura-medium m-0 text-bold text-xl">Upload an image</p>
                <div class="text-center text-3xl">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 6c0-1.1.9-2 2-2h3l2-2h6l2 2h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm10 10a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                </div>
            </div>
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            'defaultImage' : {
                type: String,
                default : '/images/placeholder-image.png'
            }
        },

        data() {
            return {
                imagePreview: this.defaultImage,
            }
        },

        computed: {
            bannerStyles() {
                return {
                    'background-image' : `url('${this.imagePreviewPath}')`
                }
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
            }
        }
    }
</script>