<template>
  <aside class="sidebar">
    <div class="sidebar__inner">
      <div class="sidebar__header">
        <AppLogo v-once class="sidebar__logo" />
      </div>
      <div class="sidebar__body">
        <h3 class="sidebar__title">menu</h3>
        <BaseNavbar :nav="nav" />
      </div>
      <div class="sidebar__footer"></div>
    </div>
  </aside>
</template>

<script>
import AppLogo from "./AppLogo";
import BaseNavbar from "./BaseNavbar";
import routes from "@/router/routes/tables";
import rootRoutes from "@/router/routes";
import { getNavItemsFromRoutes } from "@/utils";

export default {
  name: "AppSidebar",
  components: {
    AppLogo,
    BaseNavbar
  },

  created() {
    this.nav = getNavItemsFromRoutes([...routes, ...rootRoutes]);
  }
};
</script>

<style lang="scss">
.sidebar {
  background-color: $secondary-color;
  box-shadow: 1px 0 $shadow-blur-radius-base $shadow-color-base;

  &__title {
    text-transform: uppercase;
    font-weight: 300;
    letter-spacing: 0.5em;
    text-indent: 0.5em;
    margin: 30px 0 15px 0;
    font-size: 1.2em;
  }

  &__inner {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  &__header {
    flex: 0 0 $sidebar-header-height;
    border-bottom: 2px solid $tertiary-color;
    display: flex;
    justify-content: center;
    align-items: center;
    // border-radius: 0 0 $border-radius-base $border-radius-base;
  }

  &__footer {
    height: $sidebar-footer-height;
    margin-top: auto;
    border-top: 2px solid $tertiary-color;
  }
}
</style>
