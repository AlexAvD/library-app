<template>
  <div class="logo">
    <router-link :to="{ name: 'books' }" class="logo__link">
      <div class="logo__icon-wrapper">
        <BookOpenIcon class="logo__icon" />
      </div>
      <div class="logo__text">Book Stock</div>
    </router-link>
  </div>
</template>

<script>
import { BookOpenIcon } from "vue-feather-icons";

export default {
  name: "AppLogo",
  components: {
    BookOpenIcon,
  },
};
</script>

<style lang="scss">
.logo {
  &__link {
    display: inline-flex;
    flex-direction: column;
    user-select: none;
    text-decoration: none;
    color: $primary-color;
  }

  &__icon-wrapper {
    line-height: 1;
  }

  &__text {
    font-size: 1.2em;
  }
}
</style>
