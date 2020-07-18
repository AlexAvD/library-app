<template>
  <nav class="navbar" :class="dirClass">
    <ul class="navbar__list">
      <li v-for="{ name, label } in nav" :key="name" class="navbar__item">
        <router-link :to="{ name }" class="navbar__link">
          {{ label }}
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  props: {
    nav: Array,
    horizontal: Boolean,
  },
  computed: {
    dirClass() {
      return {
        navbar_horizontal: this.horizontal,
      };
    },
  },
};
</script>

<style lang="scss">
.navbar {
  $parent: &;
  font-size: 1.1em;

  &_horizontal {
    #{$parent}__list {
      flex-direction: row;
    }

    #{$parent}__item:not(:last-child) {
      margin-right: 30px;
    }

    #{$parent}__link {
      padding: 1em 0;
    }
  }

  &__title {
    text-transform: uppercase;
    font-weight: 300;
    letter-spacing: 0.5em;
    text-indent: 0.5em;
    margin: 30px 0 15px 0;
    font-size: 1.3em;
  }

  &__list {
    display: flex;
    flex-direction: column;
    height: 100%;
    list-style: none;
  }

  &__link {
    text-decoration: none;
    padding: 0.8em;
    font-size: inherit;
    display: block;
    color: $text-color-tertiary;
    transition: $transition-base;

    &.router-link-active {
      color: $primary-color;
    }
  }
}
</style>
