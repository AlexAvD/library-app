<template>
  <div class="books">
    <div class="books__inner">
      <ul class="books__list">
        <li
          v-for="(book, index) in books"
          :key="index"
        >{{book['title']}} - {{book['year_of_writing']}}</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "ViewBooks",
  data() {
    return {
      books: []
    };
  },
  mounted() {
    this.$api.get("book", { "in-last-decade": 1 }).then(({ data }) => {
      console.log(data);
      if (data.success == 1) {
        this.books = data.data;
      }
    });
  }
};
</script>

<style lang="scss">
.books {
  margin: 30px;

  &__list {
    text-align: left;
    padding-left: 40px;
  }
}
</style>
