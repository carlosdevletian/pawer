<template>
    <form @submit.prevent="addItemToCart">
        <div class="form-group">
            <input class="form-control" type="number" v-model="selectedItem.quantity" placeholder="How many do you want to add?" autofocus>
        </div>
        <div class="form-group">
            <select v-model="selectedItem.size" class="form-control mb-2">
                <option disabled value="">Please select a size</option>
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
                    product_id : this.product.id,
                    quantity : '',
                    size : ''
                },
                errors : {
                    quantity : '',
                    selectedSize : '',
                }
            }
        },

        methods: {
            addItemToCart() {
                this.$emit('item-added', this.selectedItem);
            }
        }
    }
</script>