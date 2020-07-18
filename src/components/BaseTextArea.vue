<template>
  <div class="text-area">
    <label class="text-area__inner">
      <span class="text-area__label">{{ label }}</span>
      <textarea
        autocomplete="off"
        v-bind="$attrs"
        :rules="rules"
        :value="value"
        @input="$emit('input', $event.target.value)"
        class="text-area__field"
      ></textarea>
    </label>
  </div>
</template>

<script>
export default {
  name: "BaseTextArea",
  inheritAttrs: false,
  model: {
    prop: "value",
    event: "input",
  },
  props: {
    label: String,
    value: String,
    rules: [String, Object],
  },
};
</script>

<style lang="scss">
.text-area {
  &__inner {
    display: flex;
    flex-direction: column;
  }

  &__label {
    font-weight: 500;
  }

  &__field {
    background: linear-gradient(0deg, $primary-color 1px, transparent 1px) left center/100% no-repeat,
      linear-gradient(0deg, $primary-color 2px, transparent 2px) left center/0% 100% no-repeat;
    transition: $transition-base ease;
    padding: 0.6em 0.4em;
    display: block;
    width: 100%;
    background-color: transparent;
    border: 0;
    font: inherit;
    font-size: 0.9375em;
    resize: none;

    &:focus {
      outline: 0;
      background: linear-gradient(0deg, $primary-color 1px, transparent 1px) left center/100% no-repeat,
        linear-gradient(0deg, $primary-color 2px, transparent 2px) left center/100% 100% no-repeat;
    }

    &::placeholder {
      color: $placeholder-color;
    }
  }
}
</style>
