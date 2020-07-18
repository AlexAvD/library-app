<template>
  <BaseModal class="modal-form" @close="close" :show="show" :title="title">
    <ValidationObserver tag="form" class="modal-form__form" @submit.prevent="submit" ref="form">
      <slot />
    </ValidationObserver>
    <template class="modal-form__footer" #footer>
      <BaseButtonGroup align="right">
        <BaseButton @click="close">Close</BaseButton>
        <BaseButton @click="submit" variant="flat">Accept</BaseButton>
      </BaseButtonGroup>
    </template>
  </BaseModal>
</template>

<script>
import BaseModal from "@/components/BaseModal";
import BaseButton from "@/components/BaseButton";
import BaseButtonGroup from "@/components/BaseButtonGroup";
import { ValidationObserver } from "vee-validate";

export default {
  name: "ModalForm",
  components: {
    BaseModal,
    BaseButton,
    BaseButtonGroup,
    ValidationObserver,
  },
  props: {
    title: String,
    show: Boolean,
  },
  mounted() {},
  methods: {},
};
</script>

<style lang="scss">
.modal-form {
  &__form > * {
    margin-bottom: 15px;
    width: 100%;
  }
}
</style>
