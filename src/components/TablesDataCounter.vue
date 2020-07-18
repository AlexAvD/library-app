<template>
  <div class="tables-data-counter">
    <div class="tables-data-counter__inner">
      Total:
      <span class="tables-data-counter__counter">{{ currentTableDataCount }}</span>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "TablesDataCounter",
  computed: {
    ...mapGetters(["currentTableDataCount"]),
  },
};
</script>

<style lang="scss">
.tables-data-counter {
  &__counter {
    margin-left: 0.4em;
  }
}
</style>
