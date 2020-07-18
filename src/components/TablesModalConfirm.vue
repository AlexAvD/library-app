<template>
  <ModalConfirm :show="show" :msg="msg" @cancel="onCancel" @confirm="onConfirm" />
</template>

<script>
import ModalConfirm from "@/components/ModalConfirm";
import { mapGetters, mapMutations, mapActions } from "vuex";
import { DELETE_SELECTED_TABLE_ITEM } from "@/store/actions.type";
import { CLOSE_MODAL } from "@/store/mutations.type";

export default {
  name: "TablesModalConfirm",
  components: {
    ModalConfirm,
  },
  props: {
    show: Boolean,
  },
  computed: {
    ...mapGetters(["isModalShown", "selectedTableItem", "modalType", "tableName"]),
    msg() {
      let result = "";

      if (this.selectedTableItem) {
        result = "Delete ";

        switch (this.tableName) {
          case "authors":
            result += `author "${this.selectedTableItem["full_name"]}"`;
            break;
          case "books":
            result += `book "${this.selectedTableItem["title"]}"`;
            break;
          case "genres":
            result += `genre "${this.selectedTableItem["name"]}"`;
            break;
        }
      }

      return result;
    },
  },
  methods: {
    ...mapMutations({
      close: CLOSE_MODAL,
    }),
    ...mapActions({
      deleteSelected: DELETE_SELECTED_TABLE_ITEM,
    }),
    onCancel() {
      this.close();
    },
    onConfirm() {
      this.deleteSelected();
      this.close();
    },
  },
};
</script>

<style></style>
