<template>
    <div @click="toggleView" class="clickable d-flex flex-column position-relative">
        <p class="align-self-end p-0 m-0 text-grey text-uppercase">{{ name }} &or;</p>
        <transition name="dropdown-list">
            <ul v-if="showList" class="dropdown-list position-absolute bg-white shadow m-0 no-list-style p-4">
                <li v-for="item in items" v-text="item.name" class="w-100 d-block text-capitalize futura-medium"></li>
            </ul>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['name', 'items'],

        data() {
            return {
                showList : false
            }
        },

        methods : {
            toggleView() {
                this.showList = ! this.showList
            }
        }
    }
</script>

<style>
    .dropdown-list {
        right:0;
        top:35px;
        z-index:999;
        width:150px;
        transition: all .3s cubic-bezier(0.23, 1.85, 0.32, 1);
    }
    .dropdown-list-enter {
        -webkit-transform: translateY(-100%);
        transform: translateY(-100%);
        opacity: 0;
    }

    .dropdown-list-leave-active {
        transition: all 0.2s ease;
        -webkit-transform: translateY(100%);
        transform: translateY(100%);
        opacity: 0;
    }
</style>