<template>
  <div class="search">
    <div class="search__inner">
      <form class="search__form" @submit.prevent="onSubmit">
        <BaseButton type="submit" class="search__submit">
          <SearchIcon size="1.5x" />
        </BaseButton>
        <BaseTextField
          placeholder="Search"
          name="search"
          type="search"
          variant="underline"
          :value="value"
          @input="$emit('input', $event)"
          class="search__text-field"
        />
      </form>
    </div>
  </div>
</template>

<script>
import BaseButton from "@/components/BaseButton";
import BaseTextField from "@/components/BaseTextField";
import { SearchIcon } from "vue-feather-icons";

export default {
  name: "BaseSearch",
  components: {
    BaseTextField,
    SearchIcon,
    BaseButton,
  },
  props: {
    value: String,
  },
  data() {
    return {
      lastSubmitedValue: "",
    };
  },
  methods: {
    onSubmit() {
      if (this.lastSubmitedValue !== this.value) {
        this.$emit("search", this.value);
        this.lastSubmitedValue = this.value;
      }
    },
  },
};
</script>

<style lang="scss">
.search {
  &__inner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  &__text-field {
    width: 250px;
  }

  &__submit {
    padding: 0;
    margin-right: 0.6em;
  }

  &__form {
    display: flex;
  }
}
</style>
