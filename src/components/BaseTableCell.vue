<template>
  <component
    :is="tag"
    :class="{ 'table-cell_head': tag === 'th' }"
    :style="{ width, textAlign: align }"
    class="table-cell"
  >
    <div class="table-cell__inner">
      <slot />
    </div>
  </component>
</template>

<script>
export default {
  name: "BaseTableCell",
  props: {
    width: [String, Number],
    tag: {
      type: String,
      default: "td",
      validator(tag) {
        return ["td", "th"].includes(tag);
      },
    },
    align: {
      type: String,
      default: "left",
      validator(align) {
        return ["left", "center", "right"].includes(align);
      },
    },
  },
};
</script>

<style lang="scss">
.table-cell {
  padding: 20px 30px;
  box-shadow: 0 1px $tertiary-color;

  &__inner {
    text-overflow: ellipsis;
    overflow: hidden;
    max-width: 320px;
  }

  &_head {
    box-shadow: 0 2px $tertiary-color;
    position: sticky;
    top: 0;
    background-color: $secondary-color;
  }
}
</style>
