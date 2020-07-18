<template>
  <BaseModal class="modal-author" @close="close" :show="show" title="Author">
    <ValidationObserver tag="form" class="modal-author__form" @submit.prevent="submit" ref="form">
      <BaseTextField
        label="Full name"
        variant="underline"
        placeholder="Author full name"
        v-model="fullName"
        class="modal-author__text-field"
        rules="required|min:3"
      />
      <BaseTextField
        label="Date of birth"
        variant="underline"
        placeholder="1990-08-20"
        mask="yyyy-mm-dd"
        v-model.trim="dateOfBirth"
        rules="date"
        class="modal-author__text-field"
      />
      <BaseTextField
        label="Date of death"
        variant="underline"
        placeholder="2012-06-06"
        mask="yyyy-mm-dd"
        v-model.trim="dateOfDeath"
        class="modal-author__text-field"
        :rules="{ is_not: dateOfBirth, date: true }"
      />
    </ValidationObserver>
    <template class="modal-author__footer" #footer>
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
  name: "TablesAuthorModal",
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
          this.fullName = val.selectedTableItem["full_name"];
          this.dateOfBirth = val.selectedTableItem["date_of_birth"];
          this.dateOfDeath = val.selectedTableItem["date_of_death"];
        } else {
          this.fullName = this.dateOfBirth = this.dateOfDeath = "";
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
      fullName: "",
      dateOfBirth: "",
      dateOfDeath: "",
    };
  },
  methods: {
    ...mapMutations({
      close: CLOSE_MODAL,
    }),
    ...mapActions({
      addAuthor: ADD,
      updateAuthor: UPDATE,
    }),
    submit() {
      this.$refs.form.validate().then((isValid) => {
        if (isValid) {
          const author = {
            full_name: this.fullName,
          };

          if (this.dateOfBirth) author["date_of_birth"] = this.dateOfBirth;
          if (this.dateOfDeath) author["date_of_death"] = this.dateOfDeath;

          switch (this.modalType) {
            case "add":
              this.addAuthor(author);
              break;
            case "edit":
              this.updateAuthor(author);
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
.modal-author {
  &__text-field:not(:last-child) {
    margin-bottom: 30px;
  }
}
</style>
