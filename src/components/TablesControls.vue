<template>
  <BaseButtonGroup class="tables-controls">
    <BaseButton variant="flat" @click="openConfirmModal" :disabled="!isSelected">
      <Trash2Icon size="1.5x" />
    </BaseButton>
    <BaseButton variant="flat" @click="openAddModal">
      <PlusIcon size="1.5x" />
    </BaseButton>
    <BaseButton variant="flat" @click="openEditModal" :disabled="!isSelected">
      <Edit2Icon size="1.5x" />
    </BaseButton>
  </BaseButtonGroup>
</template>

<script>
import BaseButton from "@/components/BaseButton";
import BaseButtonGroup from "@/components/BaseButtonGroup";
import { PlusIcon, Trash2Icon, Edit2Icon } from "vue-feather-icons";

import { mapActions, mapGetters } from "vuex";
import { OPEN_MODAL } from "@/store/mutations.type";

export default {
  name: "TablesControls",
  components: {
    BaseButton,
    BaseButtonGroup,
    PlusIcon,
    Trash2Icon,
    Edit2Icon,
  },
  computed: {
    ...mapGetters(["isSelected"]),
  },
  methods: {
    ...mapActions({
      openModal: OPEN_MODAL,
    }),
    openEditModal() {
      this.openModal("edit");
    },
    openAddModal() {
      this.openModal("add");
    },
    openConfirmModal() {
      this.openModal("confirm");
    },
  },
};
</script>

<style></style>
