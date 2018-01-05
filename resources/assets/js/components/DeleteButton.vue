<template>
    <div>
        <button class="border-0 clickable bg-transparent" v-if="! confirmDelete" @click="confirmDelete = true" title="Delete">
            <svg class="icon black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/></svg>
        </button>
        <transition name="delete">
            <slot v-if="confirmDelete"></slot>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                confirmDelete : false
            }
        },
    }
</script>

<style>
.delete-enter-active, .delete-leave-active {
    transition: opacity .5s;
}
.delete-enter, .delete-leave-to{
    opacity: 0;
}
</style>