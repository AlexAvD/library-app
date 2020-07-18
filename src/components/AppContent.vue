<template>
  <section class="content">
    <div class="content__inner">
      <router-view />
    </div>
  </section>
</template>

<script>
export default {
  name: "AppContent"
};
</script>

<style lang="scss">
.content {
  overflow: hidden;
  background-color: $secondary-color;
  border-radius: $border-radius-base $border-radius-base 0 0;

  &::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: -1;
    box-shadow: 0 -2px $tertiary-color,
      0 1px $shadow-blur-radius-base $shadow-color-base;
  }

  &__inner {
    height: 100%;
  }
}
</style>
