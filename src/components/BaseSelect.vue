<template>
  <div class="select">
    <label class="select__inner">
      <span class="select__label">{{ label }}</span>
      <VSelect class="select__content" :label="objectKey" v-bind="$attrs" v-on="$listeners" />
    </label>
  </div>
</template>

<script>
export default {
  name: "BaseSelect",
  inheritAttrs: false,
  props: {
    label: String,
    objectKey: String,
    rules: [String, Object],
  },
};
</script>

<style lang="scss">
@import "vue-select/src/scss/vue-select.scss";

.select {
  &__inner {
    display: flex;
    flex-direction: column;
  }

  &__label {
    font-weight: 500;
  }

  .vs__dropdown-toggle {
    border: 0;
    background: linear-gradient(0deg, $primary-color 1px, transparent 1px) left center/100% no-repeat,
      linear-gradient(0deg, $primary-color 2px, transparent 2px) left center/0% 100% no-repeat;
    transition: $transition-base ease;
    padding: 0.6em 0.4em;

    &:focus {
      background: linear-gradient(0deg, $primary-color 1px, transparent 1px) left center/100% no-repeat,
        linear-gradient(0deg, $primary-color 2px, transparent 2px) left center/100% 100% no-repeat;
    }
  }

  .vs__search,
  .vs__selected {
    padding: 0;
    margin: 0;
  }

  .vs__search {
    &::placeholder {
      color: $placeholder-color;
    }
  }
}
</style>
