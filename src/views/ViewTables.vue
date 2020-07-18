<template>
  <div class="tables">
    <div class="tables__inner">
      <!-- <TablesHeader />* -->
      <TablesContent />
      <TablesFooter />
      <TablesModals />
    </div>
  </div>
</template>

<script>
import TablesContent from "@/components/TablesContent";
import TablesFooter from "@/components/TablesFooter";
import TablesHeader from "@/components/TablesHeader";
import TablesModals from "@/components/TablesModals";
import { mapActions } from "vuex";
import { FETCH_TABLE_DATA } from "@/store/actions.type";

export default {
  name: "ViewTables",
  components: {
    TablesContent,
    TablesModals,
    TablesHeader,
    TablesFooter,
  },

  beforeRouteUpdate(to, from, next) {
    const { meta } = to;

    if (meta && meta.table) {
      const { table } = to.meta;

      this.fetchData(table);
    }

    next();
  },

  beforeRouteEnter(to, from, next) {
    const { meta } = to;

    if (meta && meta.table) {
      const { table } = to.meta;

      next((vm) => {
        vm.fetchData(table);
      });
    } else {
      next();
    }
  },

  methods: {
    ...mapActions({
      fetchData: FETCH_TABLE_DATA,
    }),
  },
};
</script>

<style lang="scss">
.tables {
  height: 100%;

  &__inner {
    height: 100%;
    display: flex;
    flex-direction: column;
  }
}
</style>
