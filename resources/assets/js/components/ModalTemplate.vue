<template>
    <transition name="modal">
        <div class="Modal__background" @click="$emit('close')" :style="addOverflow">
            <div class="Modal" :class="childClassObject" @click.stop>
                <span class="Modal__close" @click="$emit('close')">&#10005;</span>
                <div class="Modal__header">
                    <slot name="header"></slot>
                </div>
                <div class="Modal__description">
                    <slot name="description"></slot>
                </div>
                <div class="Modal__body">
                    <slot name="body"></slot>
                </div>
                <div class="Modal__footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            childClassObject: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            overflowY: {
                type: Boolean,
                default: false
            },
        },
        computed: {
            addOverflow() {
                if(this.overflowY) {
                    return {
                        overflowY : 'scroll'
                    }
                }
            }
        },
        mounted: function () {
            document.addEventListener("keydown", (e) => {
              if (e.keyCode == 27) {
                    this.$emit('close');
                }
            });
        },
    }
</script>

<style lang="scss">
    .Modal {
        max-width: 1200px;
        height: auto;
        margin: 50px auto;
        background: #22292f;
        width: 70%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        position: relative;

        &--wide {
            max-width: none;
            width: 90%;
        }

        &__background {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            transition: opacity .3s ease;
            overflow-y: hidden;
        }

        &__header {
            font-size: 13pt;
            text-align: center;
            padding-top: 20px;
            padding-left: 30px;
            padding-right: 30px;
        }

        &__description {
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 11pt;
            color: black;
            text-align: justify;
            padding-left: 30px;
            padding-right: 30px;
        }

        &__body {
            margin: 20px 0 30px;
            padding-left: 30px;
            padding-right: 30px;

            & img {
                max-height: 400px;
                max-height: 60vh;
                width: auto;
            }
        }

        &__footer {
            text-align: center;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 20px;
        }

        &__checkbox {
            text-align: left;
        }

        &__close {
            color: lightgrey;
            padding: 20px 30px;
            position: absolute;
            right: 0;
            &:hover {
                color: grey;
                cursor: pointer;
            }
        }

        &__image-description {
                padding: 20px 10px;
                font-size: 10pt;
            }
        }

        .Blur {
            transition: 0.1s filter ease-in;
            -webkit-filter: blur(5px);
            -moz-filter: blur(5px);
            -o-filter: blur(5px);
            -ms-filter: blur(5px);
        }

    /*
    * The following styles are auto-applied to elements with
    * v-transition="modal" when their visiblity is toggled
    * by Vue.js.
    */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .Modal,
    .modal-leave-active .Modal {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>