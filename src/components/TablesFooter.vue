<template>
  <div class="tables-footer">
    <div class="tables-footer__inner">
      <div class="tables-footer__group tables-footer__group_align_left">
        <TablesDataCounter />
      </div>
      <div class="tables-footer__group tables-footer__group_align_center">
        <TablesControls />
      </div>
      <div class="tables-footer__group tables-footer__group_align_right">
        <BaseButton
          variant="flat"
          @click="clearCurrentTable"
          :disabled="currentTableDataCount === 0"
        >Delete all</BaseButton>
      </div>
    </div>
  </div>
</template>

<script>
import TablesControls from "@/components/TablesControls";
import TablesDataCounter from "@/components/TablesDataCounter";
import BaseButton from "@/components/BaseButton";
import { mapActions, mapGetters } from "vuex";
import { CLEAR_CURRENT_TABLE } from "@/store/actions.type";

export default {
  name: "TablesFooter",
  components: {
    TablesControls,
    TablesDataCounter,
    BaseButton
  },
  computed: {
    ...mapGetters(["currentTableDataCount"])
  },
  methods: {
    ...mapActions({
      clearCurrentTable: CLEAR_CURRENT_TABLE
    })
  }
};
</script>

<style lang="scss">
.tables-footer {
  padding: 0 30px;
  background-color: $secondary-color;
  height: $tables-footer-height;
  border-top: 2px solid $tertiary-color;

  &__inner {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  &__group {
    flex: 1 1 100%;
    display: flex;

    &_align_left {
      justify-content: flex-start;
    }

    &_align_center {
      justify-content: center;
    }

    &_align_right {
      justify-content: flex-end;
    }
  }
}
</style>
