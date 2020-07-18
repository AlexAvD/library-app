<template>
  <header class="header">
    <div class="header__inner">
      <div class="header__title-wrapper">
        <h1 class="header__title" :key="title">
          {{ title }}
        </h1>
      </div>

      <div class="header__search">
        <BaseSearch :value="search" @input="onInput" @search="onSearch" class="tables-header__search" />
      </div>
    </div>
  </header>
</template>

<script>
import BaseSearch from "@/components/BaseSearch";
import { mapMutations, mapGetters, mapState } from "vuex";
import { SET_SEARCH } from "@/store/mutations.type";

export default {
  name: "AppHeader",
  components: {
    BaseSearch,
  },
  computed: {
    title() {
      const { meta } = this.$route;

      return meta && meta.title;
    },
    ...mapState({
      searchVal: (state) => state.tables.search,
    }),
    ...mapGetters(["tableName"]),
  },
  watch: {
    tableName() {
      this.setSearch("");
    },
  },
  data() {
    return {
      search: "",
    };
  },
  methods: {
    ...mapMutations({
      setSearch: SET_SEARCH,
    }),
    onInput(value) {
      if (/^[\wа-я\s]*$/i.test(value)) {
        this.search = value;
      }
    },
    onSearch() {
      this.setSearch(this.search);
    },
  },
};
</script>

<style lang="scss">
.header {
  padding: 0 30px;
  background-color: $secondary-color;
  border-radius: 0 0 $border-radius-base $border-radius-base;
  box-shadow: 0 1px $shadow-blur-radius-base $shadow-color-base;

  &__title {
    font-size: 1.6em;
  }

  &__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 100%;
  }
}
</style>
