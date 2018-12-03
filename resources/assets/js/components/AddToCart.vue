<template>
    <form @submit.prevent="addItemToCart">
        <div v-show="errors.quantity" class="text-red text-center" v-text="errors.quantity"></div>
        <div v-show="errors.selectedSize" class="text-red text-center" v-text="errors.selectedSize"></div>
        <div class="form-group">
            <input class="form-control" type="number" v-model="selectedItem.quantity" placeholder="How many do you want to add?" min=0 v-focus>
        </div>
        <div class="form-group">
            <select v-model="selectedItem.size" class="form-control mb-2">
                <option disabled value=null>Please select a size</option>
                <option v-for="size in product.sizes" class="text-uppercase" :value="size.id">{{ size.name }}</option>
            </select>
        </div>
        <button type="submit" class="btn btn-brand">Add</button>
    </form>
</template>

<script>
    export default {
        props: ['product'],

        data() {
            return {
                selectedItem : {
                    article_id : this.product.id,
                    quantity : '',
                    size : null
                },
                errors : {
                    quantity : '',
                    selectedSize : '',
                }
            }
        },

        methods: {
            addItemToCart() {
                this.validate()
                if(this.errors.quantity || this.errors.selectedSize) return
                this.$emit('item-added', this.selectedItem);
            },
            validate() {
                if(! this.selectedItem.quantity > 0) {
                    this.errors.quantity = "The quantity must be greater than 0"
                    return
                } else {
                    this.errors.quantity = ""
                }
                if(! this.selectedItem.size) {
                    this.errors.selectedSize = "A size must be selected"
                    return
                } else {
                    this.errors.selectedSize = ""
                }

            }
        }
    }
</script>