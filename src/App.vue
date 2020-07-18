<template>
  <div id="app" class="app">
    <AppSidebar class="app__sidebar" />
    <AppMain class="app__main">
      <AppHeader class="app__header" />
      <AppContent class="app__content" />
    </AppMain>
  </div>
</template>

<script>
import AppSidebar from "./components/AppSidebar";
import AppMain from "./components/AppMain";
import AppHeader from "./components/AppHeader";
import AppContent from "./components/AppContent";

export default {
  name: "App",
  components: {
    AppSidebar,
    AppMain,
    AppHeader,
    AppContent
  }
};
</script>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap");

*,
*:after,
*:before {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background-color: $tertiary-color;
}

::-webkit-scrollbar {
  height: 10px;
  width: 10px;
}

::-webkit-scrollbar-track {
  background: $secondary-color;
}

::-webkit-scrollbar-thumb {
  background: $primary-color;
  border-radius: $border-radius-base;
}

.app {
  font-family: Roboto, Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: $text-color-primary;
  height: 100vh;
  display: flex;

  &__sidebar {
    max-width: 300px;
    width: 100%;
  }

  &__main {
    padding: 0 30px;
    flex: 1 1 auto;
  }

  &__header {
    margin-bottom: 30px;
    flex: 0 0 $header-height;
  }

  &__content {
    flex: 1 1 auto;
  }
}
</style>
