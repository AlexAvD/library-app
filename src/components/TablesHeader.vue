<template>
  <div class="tables-header">
    <BaseNavbar :nav="nav" horizontal class="tables-header__nav" />
    <BaseSearch :value="search" @input="onInput" @search="onSearch" class="tables-header__search" />
  </div>
</template>

<script>
import BaseNavbar from "@/components/BaseNavbar";
import BaseSearch from "@/components/BaseSearch";
import routes from "@/router/routes/tables";
import { getNavItemsFromRoutes } from "@/utils";
import { mapGetters, mapMutations, mapState } from "vuex";
import { SET_SEARCH } from "@/store/mutations.type";

export default {
  name: "TablesHeader",
  components: {
    BaseNavbar,
    BaseSearch,
  },
  computed: {
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
  created() {
    this.nav = getNavItemsFromRoutes(routes);
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
// .tables-header {
//   display: flex;
//   justify-content: space-between;

//   &__nav,
//   &__search {
//     background-color: $secondary-color;
//     border-radius: $border-radius-base $border-radius-base 0 0;
//     padding: 0 30px;
//     position: relative;
//     border-bottom: 2px solid $tertiary-color;
//     user-select: none;

//     &::after {
//       box-shadow: 0 1px $shadow-blur-radius-base $shadow-color-base;
//     }
//   }

//   &__nav::after,
//   &__search::after,
//   &__table-wrapper::after {
//     content: "";
//     position: absolute;
//     top: 0;
//     bottom: 0;
//     left: 0;
//     right: 0;
//     z-index: -1;
//   }
// }
</style>
