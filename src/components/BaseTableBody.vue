<template>
  <tbody class="table-body" @click="onClick">
    <BaseTableRow
      v-for="(cols, index) in rows"
      :key="index"
      :selected="index === selectedIndex"
      class="table-body__row"
    >
      <BaseTableCell
        v-for="(data, index) in cols"
        :key="index"
        :align="data.align"
        class="table-body__cell"
      >
        {{
        data.value
        }}
      </BaseTableCell>
    </BaseTableRow>
  </tbody>
</template>

<script>
import BaseTableCell from "./BaseTableCell";
import BaseTableRow from "./BaseTableRow";

export default {
  name: "BaseTableBody",
  components: {
    BaseTableCell,
    BaseTableRow
  },
  props: {
    headers: Array,
    data: Array,
    selectedIndex: {
      type: Number,
      default: -1
    }
  },
  computed: {
    rows() {
      const result = Array(this.data.length);

      this.headers.forEach((headerItem, headerItemIndex) => {
        this.data.forEach((dataItem, dataItemIndex) => {
          if (typeof result[dataItemIndex] === "undefined") {
            result[dataItemIndex] = Array(this.headers.length);
          }

          result[dataItemIndex][headerItemIndex] = {
            value: dataItem[headerItem.value] || headerItem.default,
            align: headerItem.align
          };
        });
      });

      return result;
    }
  },
  methods: {
    onClick(e) {
      if (e.target === this.$el) return;

      let tr = e.target;

      while (tr.parentNode !== this.$el) {
        tr = tr.parentNode;

        if (tr === null) break;
      }

      let selectedIndex = -1;

      if (tr) {
        selectedIndex = this.$children.findIndex(child => child.$el === tr);
      }

      this.$emit("select", selectedIndex);
    }
  }
};
</script>

<style lang="scss">
.table-body {
  &__row {
    cursor: pointer;
  }
}
</style>
