<template>
  <BaseModal @close="cancel" :show="show" :title="title">
    {{ msg }}
    <template class="modal-confirm__footer" #footer>
      <BaseButtonGroup align="right">
        <BaseButton @click="cancel">Cancel</BaseButton>
        <BaseButton @click="confirm" variant="flat">Accept</BaseButton>
      </BaseButtonGroup>
    </template>
  </BaseModal>
</template>

<script>
import BaseModal from "@/components/BaseModal";
import BaseButton from "@/components/BaseButton";
import BaseButtonGroup from "@/components/BaseButtonGroup";

export default {
  name: "ModalConfirm",
  components: {
    BaseModal,
    BaseButton,
    BaseButtonGroup,
  },
  props: {
    title: {
      type: String,
      default: "Are you sure?",
    },
    msg: {
      type: String,
      default: "",
    },
    show: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {},
  methods: {
    cancel() {
      this.$emit("cancel");
    },
    confirm() {
      this.$emit("confirm");
    },
    test() {
      console.log("enter");
    },
  },
};
</script>

<style lang="scss">
.modal-confirm {
  &__footer {
  }
}
</style>
