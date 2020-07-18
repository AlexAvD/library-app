<template>
  <ValidationProvider
    :class="variantClass"
    :rules="rules"
    :name="name || label"
    tag="div"
    v-slot="{ errors, required, ariaInput, ariaMsg }"
    class="text-field"
  >
    <label v-if="label" class="text-field__field">
      <span class="text-field__label">
        {{ label + (required ? " *" : "") }}
      </span>
      <input
        :value="value"
        :autocomplete="autocomplete"
        :type="type"
        @input="input"
        v-bind="ariaInput"
        v-mask="mask"
        :placeholder="placeholder"
        class="text-field__input"
      />
    </label>
    <input
      v-else
      :value="value"
      :type="type"
      :autocomplete="autocomplete"
      @input="input"
      v-bind="ariaInput"
      v-mask="mask"
      :placeholder="placeholder"
      class="text-field__input"
    />

    <span v-if="errors.length" v-bind="ariaMsg" class="text-field__error">
      {{ errors[0] }}
    </span>
  </ValidationProvider>
</template>

<script>
export default {
  name: "BaseInput",
  inheritAttrs: false,
  props: {
    rules: [String, Object],
    label: String,
    value: String,
    name: String,
    mask: {
      type: [String, Object],
      default: "",
    },
    placeholder: {
      type: String,
      default: null,
    },
    variant: {
      type: String,
      default: "underline",
      validator(variant) {
        return ["underline"].includes(variant);
      },
    },
    autocomplete: {
      type: String,
      default: "off",
      validator(autocomplete) {
        return ["off", "on"].includes(autocomplete);
      },
    },
    type: {
      type: String,
      default: "text",
      validator(value) {
        return ["url", "text", "password", "tel", "search", "number", "email", "textarea"].includes(value);
      },
    },
  },
  computed: {
    variantClass() {
      return `text-field_${this.variant}`;
    },
  },
  methods: {
    input(e) {
      this.$emit("input", e.target.value);
    },
  },
};
</script>

<style lang="scss">
.text-field {
  $parent: &;
  text-align: left;
  width: 100%;

  &_underline #{$parent}__input {
    background: linear-gradient(0deg, $primary-color 1px, transparent 1px) left center/100% no-repeat,
      linear-gradient(0deg, $primary-color 2px, transparent 2px) left center/0% 100% no-repeat;
    transition: $transition-base ease;
    padding: 0.6em 0.4em;

    &:focus {
      background: linear-gradient(0deg, $primary-color 1px, transparent 1px) left center/100% no-repeat,
        linear-gradient(0deg, $primary-color 2px, transparent 2px) left center/100% 100% no-repeat;

      &::placeholder {
        color: transparent;
      }
    }
  }

  &_placeholder #{$parent}__input {
    padding: 0.6em 0;
  }

  &__field {
    display: flex;
    flex-direction: column;
  }

  &__label {
    font-weight: 500;
  }

  &__input {
    display: block;
    width: 100%;
    background-color: transparent;
    border: 0;
    font: inherit;
    font-size: 0.9375em;

    &:focus {
      outline: 0;
    }

    &::placeholder {
      color: $placeholder-color;
    }
  }

  &__error {
    font-size: 0.875em;
    display: inline-block;
    margin-top: 0.3em;
    color: #ff2b2b;
  }
}
</style>
