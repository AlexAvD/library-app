<template>
  <button v-on="$listeners" class="button" :class="variantClass">
    <div class="button__inner">
      <span v-if="$slots.prepend" class="button__prepend">
        <slot name="prepend" />
      </span>
      <span class="button__label">
        <slot />
      </span>
      <span v-if="$slots.append" class="button__append">
        <slot name="append" />
      </span>
    </div>
  </button>
</template>

<script>
export default {
  name: "BaseButton",
  props: {
    variant: {
      type: String,
      default: "",
      validator(variant) {
        return ["", "flat", "outline"].includes(variant);
      }
    }
  },
  computed: {
    variantClass() {
      return this.variant && `button_${this.variant}`;
    }
  }
};
</script>

<style lang="scss">
.button {
  $parent: &;
  user-select: none;
  white-space: nowrap;
  flex: 0 0 auto;
  cursor: pointer;
  padding: 0.6em 1.2em;
  font: inherit;
  font-size: 0.9em;
  transition: $transition-base;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  background-color: transparent;
  border: 0;

  &:not(:disabled):active {
    transform: scale(0.95);
  }

  &:disabled {
    cursor: initial;
  }

  &:focus {
    outline: 0;
  }

  &_flat {
    background-color: $primary-color;
    color: $secondary-color;
    border: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);

    &:disabled {
      background-color: $button-disabled-background;
      color: $button-disabled-text-color;
      box-shadow: none;
    }
  }

  &_outline {
    background-color: transparent;
    color: $primary-color;
    border: 1px solid $primary-color;

    &:disabled {
      border-color: $button-disabled-text-color;
      color: $button-disabled-text-color;
    }

    &:not(:disabled):hover {
      background-color: $tertiary-color;
    }
  }

  &_flat,
  &_outline {
    border-radius: $border-radius-sm;
  }

  &__inner {
    vertical-align: middle;
    position: relative;
    display: inline-flex;
    align-items: center;
  }

  &__prepend {
    margin-right: 0.5em;
  }

  svg {
    display: block;
  }
}
</style>
