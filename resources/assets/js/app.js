
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Events = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.directive('focus', {
    inserted: function (el) {
        el.focus()
    }
})

Vue.component('product-carousel', require('./components/ProductCarousel.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('product-lookbook', require('./components/ProductLookbook.vue'));
Vue.component('image-upload', require('./components/ImageUpload.vue'));
Vue.component('article-secondary-images-upload', require('./components/ArticleSecondaryImagesUpload.vue'));
Vue.component('edit-article-secondary-images', require('./components/EditArticleSecondaryImages.vue'));
Vue.component('loadable-image', require('./components/LoadableImage.vue'));
Vue.component('delete-button', require('./components/DeleteButton.vue'));
Vue.component('dropdown-list', require('./components/DropdownList.vue'));
Vue.component('make-order-modal', require('./components/MakeOrderModal.vue'));
Vue.component('svg-mono', require('./components/svg/mono.vue'));

const app = new Vue({
    el: '#app',
    data()  {
        return {
            pageIsLoading: false,
            orderModalIsOpen: false,
            modalIsActive: false,
            cartIsUpdating: false,
        }
    },

    mounted() {
        let forms = document.forms
        let vm = this

        Events.$on('cart-updated', () => {
            this.cartIsUpdating = true
            let vm = this;

            setTimeout(function(){
                vm.cartIsUpdating = false
            }, 500);
        })

        for (var i = forms.length - 1; i >= 0; i--) {
            forms[i].addEventListener('submit', function(e) {
                e.preventDefault()
                vm.pageIsLoading = true
                e.target.submit()
            })
        }
    },

    methods: {
        openOrderModal() {
            this.orderModalIsOpen = true
            this.modalIsActive = false
        },
        closeOrderModal() {
            this.orderModalIsOpen = false;
            this.modalIsActive = false;
        }
    }
});
