<template>
  <div class="modals">
    <TablesModalConfirm :show="isConfirmModalShown" />
    <TablesModalAuthor v-if="tableName === 'authors'" :show="isAddEditModalShown" />
    <TablesModalGenre v-else-if="tableName === 'genres'" :show="isAddEditModalShown" />
    <TablesModalBook v-else-if="tableName === 'books'" :show="isAddEditModalShown" />
  </div>
</template>

<script>
import TablesModalAuthor from "@/components/TablesModalAuthor";
import TablesModalGenre from "@/components/TablesModalGenre";
import TablesModalBook from "@/components/TablesModalBook";
import TablesModalConfirm from "@/components/TablesModalConfirm";
import { mapGetters } from "vuex";

export default {
  name: "TablesModal",
  components: {
    TablesModalAuthor,
    TablesModalConfirm,
    TablesModalBook,
    TablesModalGenre,
  },
  computed: {
    ...mapGetters(["tableName", "modalType", "isModalShown"]),
    isConfirmModalShown() {
      return this.isModalShown && this.modalType === "confirm";
    },
    isAddEditModalShown() {
      return this.isModalShown && (this.modalType === "add" || this.modalType === "edit");
    },
  },
};
</script>

<style></style>
