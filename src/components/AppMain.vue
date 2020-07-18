<template>
  <main class="main">
    <div class="main__inner">
      <slot />
    </div>
  </main>
</template>

<script>
export default {
  name: "AppMain",
};
</script>

<style lang="scss">
.main {
  overflow: hidden;

  &__inner {
    display: flex;
    flex-direction: column;
    height: 100%;
  }
}
</style>
