<template>
    <div class="d-flex flex-column justify-content-center align-items-center mb-3">
        <div class="position-relative">
            <a v-if="withLink && active" :href="selectedArticle.links.show"  :title="selectedArticle.name">
                <loadable-image
                    class="position-relative"
                    skeleton-styles='{"width": "250px", "height": "250px"}'
                    image-styles='{"maxWidth": "250px", "maxHeight": "250px"}'
                    :image-source="imagePath"
                    image-classes="fit-to-parent"
                    :image-alt="selectedArticle.name"
                >
                    <div class="position-absolute text-2xl text-red" style="bottom: 0px; right: 0px;" v-if="selectedArticle.on_sale && !selectedArticle.sold_out">
                        <div class="position-relative">
                            <svg style="transform: rotate(45deg)" class="fill-current" width="55" height="55" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path class="position-relative" d="M0 10V2l2-2h8l10 10-10 10L0 10zm4.5-4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                            </svg>
                            <span class="text-white position-absolute text-base font-weight-bold d-flex justify-content-center align-items-center w-100 h-100 pin">${{ selectedArticle.sale_price }}</span>
                        </div>
                    </div>
                    <div class="position-absolute d-flex text-3xl text-red justify-content-center align-items-center koyu-italic" style="bottom: 90px; right: 45px; transform: rotate(-35deg)"  v-if="selectedArticle.sold_out">
                        <span>SOLD OUT</span>
                    </div>
                </loadable-image>
            </a>
            <loadable-image v-else
                class="position-relative"
                skeleton-styles='{"width": "250px", "height": "250px"}'
                image-styles='{"maxWidth": "250px", "maxHeight": "250px"}'
                :image-source="imagePath"
                image-classes="fit-to-parent"
                :image-alt="selectedArticle.name"
            >
                <div class="position-absolute text-2xl text-red" style="bottom: 0px; right: 0px;" v-if="selectedArticle.on_sale && active">
                    <div class="position-relative">
                        <svg style="transform: rotate(45deg)" class="fill-current" width="55" height="55" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path class="position-relative" d="M0 10V2l2-2h8l10 10-10 10L0 10zm4.5-4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                        </svg>
                        <span class="text-white position-absolute text-base font-weight-bold d-flex justify-content-center align-items-center w-100 h-100 pin">${{ selectedArticle.sale_price }}</span>
                    </div>
                </div>
            </loadable-image>
            <p class="position-absolute" style="right:0; bottom:-40px;" v-if="active">
                <span :class="{ 'line-through' : selectedArticle.on_sale  }">${{ selectedArticle.price }}</span>
            </p>
        </div>
        <div style="margin-top: 0; width: 47%" class="d-flex-column" v-if="active">
            <p class="m-0 p-0 futura-medium text-truncate">{{ selectedArticle.name }}</p>
            <hr class="m-0 mb-2 p-0">
            <div class="d-flex justify-content-end">
                <a v-for="article in allArticles"
                    role="button"
                    class="clickable mr-1"
                    style="width: 10px; height: 10px; border: black 1px solid"
                    :style="'background-color : ' + article.color"
                    @click="changeArticle(article.id)"
                    :title="article.name + '-' + article.color"></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dataProduct', 'dataActive', 'withLink'],

        data() {
            return {
                allArticles: '',
                imageLoaded : false,
                selectedArticle : null
            }
        },

        created() {
            this.allArticles = Array.from(this.dataProduct);
            this.selectedArticle = this.dataProduct[0]
        },

        methods: {
            changeImage(path) {
                this.imagePath = path
            },
            changeArticle(id) {
                let selected = null
                this.allArticles.forEach((article) => {
                    if(article.id === id) {
                        selected = article
                    }
                })
                this.selectedArticle = selected
            }
        },

        computed : {
            active() {
                if(this.dataActive == 'parent') {
                    return this.$parent.isCurrent
                }
                return this.dataActive
            },

            imagePath() {
                return this.selectedArticle.main_image_path
            },

            imageHasLoaded() {
                var image = new Image()
                image.src = this.imagePath
                image.onload = () => this.imageLoaded = true
                if (image.complete) image.onload.call(image)
                return this.imageLoaded
            },
        }
    }
</script>