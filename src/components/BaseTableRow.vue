<template>
  <tr :class="{ 'table-row_selected': selected }" class="table-row">
    <slot />
  </tr>
</template>

<script>
export default {
  name: "BaseTableRow",
  props: {
    selected: Boolean,
  },
};
</script>

<style lang="scss">
.table-row {
  &:hover {
    background-color: $table-row-hover-background;
  }

  &_selected {
    background-color: $table-row-selected-background;
    transition: $transition-base;
    color: $table-row-selected-color;

    &:hover {
      background-color: $table-row-selected-background;
    }
  }
}
</style>
