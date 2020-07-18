<template>
  <div class="tables-content">
    <div class="tables-content__inner">
      <BaseTable
        @select="setSelectedIndex($event)"
        :selected-index="selectedIndex"
        :data="data"
        :headers="tableHeaders"
        class="tables-content__table"
      />
      <div v-if="data.length === 0" class="tables-content__empty">
        <p class="tables-content__empty-msg">Empty :(</p>
      </div>
    </div>
  </div>
</template>

<script>
import BaseTable from "@/components/BaseTable";
import { mapGetters, mapMutations } from "vuex";
import { SET_SELECTED_INDEX } from "@/store/mutations.type";

export default {
  name: "TablesContent",
  components: {
    BaseTable
  },
  computed: {
    ...mapGetters(["selectedIndex", "tableData", "tableHeaders", "search"]),
    data() {
      if (this.search) {
        return this.tableData.filter(item => {
          return Object.values(item).some(value => {
            return new RegExp(`.*${this.search}.*`, "i").test(value);
          });
        });
      } else {
        return this.tableData;
      }
    }
  },
  methods: {
    ...mapMutations({
      setSelectedIndex: SET_SELECTED_INDEX
    })
  }
};
</script>

<style lang="scss">
.tables-content {
  height: 100%;
  // background-color: $secondary-color;
  position: relative;
  overflow: hidden;
  // border-radius: $border-radius-base $border-radius-base 0 0;

  // &::after {
  //   content: "";
  //   position: absolute;
  //   top: 0;
  //   bottom: 0;
  //   left: 0;
  //   right: 0;
  //   z-index: -1;
  //   box-shadow: 0 -2px $tertiary-color,
  //     0 1px $shadow-blur-radius-base $shadow-color-base;
  // }

  &__inner {
    overflow-y: auto;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  &__empty {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  &__empty-msg {
    color: $gray;
  }

  .fade {
    &-enter-active,
    &-leave-active {
      transition: 0.4s all;
    }
    &-enter-active {
      transition-delay: 0.2s;
    }

    &-enter,
    &-leave-to {
      position: absolute;
      opacity: 0;
      transform: scale(0.9);
    }
  }
}
</style>
