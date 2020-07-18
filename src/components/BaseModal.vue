<template>
  <transition name="modal">
    <div @keydown.esc="close" @click.self="close" v-show="show" tabindex="-1" ref="modal" class="modal">
      <div class="modal__dialog">
        <BaseButton @click="close" class="modal__close">
          <XIcon />
        </BaseButton>
        <div class="modal__content">
          <div v-if="$slots.header || title" class="modal__header">
            <div class="modal__header-inner">
              <h2 v-if="title">{{ title }}</h2>
              <slot name="header" />
            </div>
          </div>
          <div v-if="$slots.default" class="modal__body">
            <div class="modal__body-inner">
              <slot />
            </div>
          </div>
          <div v-if="$slots.footer" class="modal__footer">
            <div class="modal__footer-inner">
              <slot name="footer" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import BaseButton from "./BaseButton";
import { XIcon } from "vue-feather-icons";

export default {
  name: "BaseModal",
  components: {
    BaseButton,
    XIcon,
  },
  props: {
    title: String,
    show: Boolean,
  },
  methods: {
    close() {
      this.$emit("close");
    },
  },
};
</script>

<style lang="scss">
.modal {
  $parent: &;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: $modal-z-index-base;
  overflow: hidden;
  text-align: left;

  &:focus {
    outline: 0;
  }

  &__dialog {
    max-width: 500px;
    margin: 4em auto;
    width: 100%;
    background-color: $secondary-color;
    border-radius: $border-radius-base;
    position: relative;
    box-shadow: 0 5px $shadow-blur-radius-base $shadow-color-base;
  }

  &__close {
    right: -30px;
    top: -25px;
    position: absolute;
    padding: 0;
    color: $secondary-color;
  }

  &__header,
  &__footer {
    padding: 20px;
  }
  &__body {
    padding: 30px;
  }

  &__header {
    border-bottom: 2px solid $tertiary-color;
  }

  &__footer {
    border-top: 2px solid $tertiary-color;
  }

  &-enter-active,
  &-leave-active {
    transition: 0.4s all;

    #{$parent}__dialog {
      transition: 0.4s all;
    }
  }

  &-enter,
  &-leave-to {
    opacity: 0;

    #{$parent}__dialog {
      transform: scale(0.9);
    }
  }
}
</style>
