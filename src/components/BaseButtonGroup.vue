<template>
  <div class="button-group" :class="alignClass">
    <div class="button-group__inner">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseButtonGroup",
  props: {
    align: {
      type: String,
      default: "",
      validator(align) {
        return ["", "left", "center", "right"].includes(align);
      }
    }
  },
  computed: {
    alignClass() {
      return this.align && `button-group_align_${this.align}`;
    }
  }
};
</script>

<style lang="scss">
.button-group {
  $parent: &;

  &_align_left #{$parent}__inner {
    justify-content: flex-start;
  }

  &_align_center #{$parent}__inner {
    justify-content: center;
  }

  &_align_right #{$parent}__inner {
    justify-content: flex-end;
  }

  &__inner {
    display: flex;

    & > *:not(:last-child) {
      margin-right: 15px;
    }
  }
}
</style>
