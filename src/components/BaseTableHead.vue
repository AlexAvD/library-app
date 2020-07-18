<template>
  <thead class="table-head">
    <BaseTableRow class="table-head__row">
      <BaseTableCell
        v-for="header in headers"
        :key="header.value"
        :align="header.align"
        :width="header.width"
        tag="th"
        class="table-head__cell"
      >
        {{ header.label }}
      </BaseTableCell>
    </BaseTableRow>
  </thead>
</template>

<script>
import BaseTableCell from "./BaseTableCell";
import BaseTableRow from "./BaseTableRow";

export default {
  name: "BaseTableHead",
  components: {
    BaseTableCell,
    BaseTableRow,
  },
  props: {
    headers: Array,
  },
};
</script>

<style lang="scss"></style>
