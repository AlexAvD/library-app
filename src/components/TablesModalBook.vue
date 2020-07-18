<template>
  <BaseModal class="modal-book" @close="close" :show="show" title="Author">
    <ValidationObserver tag="form" class="modal-book__form" @submit.prevent="submit" ref="form">
      <BaseTextField
        label="Title"
        variant="underline"
        placeholder="Title of the book"
        v-model="title"
        class="modal-book__text-field"
        rules="required|min:3"
      />
      <BaseTextField
        label="Year of writing"
        variant="underline"
        placeholder="2012"
        mask="yyyy"
        type="number"
        v-model="yearOfWriting"
        class="modal-book__text-field"
        rules="min_value:1500|max_value:2020"
      />
      <BaseSelect
        label="Author"
        rules="required"
        object-key="full_name"
        v-model="author"
        placeholder="Author"
        :options="authors"
      />
      <BaseSelect
        label="Genre"
        rules="required"
        object-key="name"
        v-model="genre"
        placeholder="Genre"
        :options="genres"
      />
      <BaseTextArea label="Description" v-model="description" placeholder="Description" />
    </ValidationObserver>
    <template class="modal-book__footer" #footer>
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
import BaseSelect from "@/components/BaseSelect";
import BaseTextArea from "@/components/BaseTextArea";
import { ValidationObserver } from "vee-validate";
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
import { CLOSE_MODAL } from "@/store/mutations.type";
import { ADD, UPDATE, FETCH_DATA, FETCH_BOOK } from "@/store/actions.type";

export default {
  name: "TablesModalBook",
  components: {
    BaseModal,
    BaseButton,
    BaseButtonGroup,
    BaseSelect,
    BaseTextField,
    BaseTextArea,
    ValidationObserver,
  },
  watch: {
    modalTypeAndSelectedIndex: {
      handler(val) {
        if (val.modalType === "edit" && val.selectedTableItem) {
          this.fetchBook(val.selectedTableItem["id"]).then((book) => {
            if (book) {
              this.title = book["title"];
              this.author = this.authors.find((author) => author.id === book["author_id"]);
              this.genre = this.genres.find((genre) => genre.id === book["genre_id"]);
              this.yearOfWriting = book["year_of_writing"];
              this.description = book["description"];
            }
          });
        } else {
          this.resetFields();
        }
      },
      deep: true,
    },
  },

  props: {
    show: Boolean,
  },
  computed: {
    ...mapGetters(["selectedTableItem", "modalType", "authors", "genres", "authorById", "genreById"]),
    modalTypeAndSelectedIndex() {
      return {
        selectedTableItem: this.selectedTableItem,
        modalType: this.modalType,
      };
    },
  },
  data() {
    return {
      title: "",
      yearOfWriting: "",
      description: "",
      author: null,
      genre: null,
    };
  },
  mounted() {
    this.fetchData("authors");
    this.fetchData("genres");
  },
  methods: {
    ...mapMutations({
      close: CLOSE_MODAL,
    }),
    ...mapActions({
      add: ADD,
      update: UPDATE,
      fetchData: FETCH_DATA,
      fetchBook: FETCH_BOOK,
    }),
    resetFields() {
      this.title = this.description = this.yearOfWriting = "";
      this.genre = this.author = null;
    },
    submit() {
      this.$refs.form.validate().then((isValid) => {
        if (isValid) {
          const book = {
            title: this.title,
          };

          if (this.author) book["author_id"] = this.author.id;
          if (this.genre) book["genre_id"] = this.genre.id;
          if (this.description) book["description"] = this.description;
          if (this.yearOfWriting) book["year_of_writing"] = this.yearOfWriting;

          console.log(book);

          switch (this.modalType) {
            case "add":
              this.add(book);
              break;
            case "edit":
              this.update(book);
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
.modal-book {
  &__form > *:not(:last-child) {
    margin-bottom: 30px;
  }
}
</style>
