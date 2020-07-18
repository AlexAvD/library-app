<template>
  <BaseModal class="modal-genre" @close="close" :show="show" title="Genre">
    <ValidationObserver tag="form" class="modal-genre__form" @submit.prevent="submit" ref="form">
      <BaseTextField
        label="Name"
        variant="underline"
        placeholder="Name of the genre"
        v-model="name"
        class="modal-genre__text-field"
        rules="required|min:3"
      />
    </ValidationObserver>
    <template class="modal-genre__footer" #footer>
      <BaseButtonGroup align="right">
        <BaseButton @click="close">Close</BaseButton>
        <BaseButton @click="submit" variant="flat">Accept</BaseButton>
      </BaseButtonGroup>
    </template>
  </BaseModal>
</template>

<script>
import BaseTextField from "@/components/BaseTextField";
import BaseModal from "@/components/BaseModal";
import BaseButton from "@/components/BaseButton";
import BaseButtonGroup from "@/components/BaseButtonGroup";
import { ValidationObserver } from "vee-validate";
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
import { CLOSE_MODAL } from "@/store/mutations.type";
import { ADD, UPDATE } from "@/store/actions.type";

export default {
  name: "TablesModalGenre",
  components: {
    BaseModal,
    BaseButton,
    BaseButtonGroup,
    BaseTextField,
    ValidationObserver,
  },
  watch: {
    modalTypeAndSelectedIndex: {
      handler(val) {
        if (val.modalType === "edit" && val.selectedTableItem) {
          this.name = val.selectedTableItem["name"];
        } else {
          this.name = "";
        }
      },
      deep: true,
    },
  },

  props: {
    show: Boolean,
  },
  computed: {
    ...mapGetters(["selectedTableItem", "modalType"]),
    modalTypeAndSelectedIndex() {
      return {
        selectedTableItem: this.selectedTableItem,
        modalType: this.modalType,
      };
    },
  },
  data() {
    return {
      name: "",
    };
  },
  methods: {
    ...mapMutations({
      close: CLOSE_MODAL,
    }),
    ...mapActions({
      add: ADD,
      update: UPDATE,
    }),
    submit() {
      this.$refs.form.validate().then((isValid) => {
        if (isValid) {
          const genre = {
            name: this.name,
          };

          switch (this.modalType) {
            case "add":
              this.add(genre);
              break;
            case "edit":
              this.update(genre);
              break;
          }

          this.$refs.form.reset();
        }
      });
    },
  },
};
</script>

<style lang="scss">
.modal-genre {
  &__text-field:not(:last-child) {
    margin-bottom: 30px;
  }
}
</style>
