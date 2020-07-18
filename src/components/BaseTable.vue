<template>
  <table class="table">
    <BaseTableHead :headers="headers" />
    <BaseTableBody
      :selected-index="selectedIndex"
      @select="$emit('select', $event)"
      :headers="headers"
      :data="data"
    />
  </table>
</template>

<script>
import BaseTableHead from "./BaseTableHead";
import BaseTableBody from "./BaseTableBody";

export default {
  name: "BaseTable",
  props: {
    selectedIndex: Number,
    headers: Array,
    data: Array
  },
  components: {
    BaseTableHead,
    BaseTableBody
  },
  model: {
    props: "selectedIndex",
    event: "select"
  }
};
</script>

<style lang="scss">
.table {
  width: 100%;
  border-collapse: collapse;
  white-space: nowrap;
  user-select: none;
}
</style>
