import * as mutation from "@/store/mutations.type";
import * as action from "@/store/actions.type";
import { api } from "@/api";

const state = {
  search: "",
  modal: {
    type: "add",
    show: false,
  },
  selectedIndex: -1,
  currentTableName: "books",
  current: {
    headers: [],
    data: [],
  },
  table: {
    authors: {
      headers: [
        {
          value: "id",
          label: "#",
          width: "1%",
        },
        {
          value: "full_name",
          label: "Full name",
        },
        {
          value: "date_of_birth",
          label: "Date of birth",
          align: "center",
        },
        {
          value: "date_of_death",
          label: "Date of death",
          align: "center",
        },
      ],
      data: [],
    },
    genres: {
      headers: [
        {
          value: "id",
          label: "#",
          width: "1%",
        },
        {
          value: "name",
          label: "Name",
        },
        {
          value: "book_count",
          label: "Book count",
          default: 0,
        },
      ],
      data: [],
    },
    books: {
      headers: [
        {
          value: "id",
          label: "#",
          width: "1%",
        },
        {
          value: "title",
          label: "Title",
        },
        {
          value: "description",
          label: "Description",
        },
        {
          value: "author",
          label: "Author",
        },
        {
          value: "genre",
          label: "Genre",
        },
        {
          value: "year_of_writing",
          label: "Year of writing",
          align: "center",
        },
      ],
      data: [],
    },
    decadeBooks: {
      headers: [
        {
          value: "title",
          label: "Title",
        },
        {
          value: "year_of_writing",
          label: "Year of writing",
        },
      ],
      data: [],
    },
  },
};

const getters = {
  authorById: (state) => (id) => state.table.authors.find((author) => author.id === id),
  genreById: (state) => (id) => state.table.genres.find((genre) => genre.id === id),
  authors: (state) => state.table.authors.data,
  genres: (state) => state.table.genres.data,
  search: (state) => state.search,
  isModalShown: (state) => state.modal.show,
  modalType: (state) => state.modal.type,
  tableName: (state) => state.currentTableName,
  tableData: (state) => state.table[state.currentTableName].data,
  tableHeaders: (state) => state.table[state.currentTableName].headers,
  isSelected: (state) => state.selectedIndex !== -1,
  currentTableDataCount: (state, getters) => getters.tableData.length,
  selectedIndex: (state) => state.selectedIndex,
  selectedTableItem: (state, getters) => getters.tableData[state.selectedIndex],
  confirmMsgDelete: (state, getters) => {
    const item = getters.selectedTableItem;
    let msg = "";

    if (item) {
      msg = "Delete ";

      switch (state.currentTableName) {
        case "authors":
          msg += `author "${item["full_name"]}"`;
          break;
        case "books":
          msg += `book "${item["title"]}"`;
          break;
        case "genres":
          msg += `genre "${item["name"]}"`;
          break;
      }
    }

    return msg;
  },
};

const mutations = {
  [mutation.SET_CURRENT_TABLE](state, table) {
    state.currentTableName = table;
  },
  [mutation.SET_TABLE_DATA](state, { tableName, tableData }) {
    // console.log(data);
    state.table[tableName].data = tableData;
  },
  [mutation.SET_SELECTED_INDEX](state, index) {
    state.selectedIndex = index;
  },
  [mutation.UNSET_SELECTED_INDEX](state) {
    state.selectedIndex = -1;
  },
  [mutation.DELETE_SELECTED](state) {
    if (state.selectedIndex !== -1) {
      state.table[state.currentTableName].data = state.table[state.currentTableName].data.filter(
        (data, index) => index !== state.selectedIndex
      );
      state.selectedIndex = -1;
    }
  },

  [mutation.CLOSE_MODAL](state) {
    state.modal.show = false;
  },

  [mutation.OPEN_MODAL](state) {
    state.modal.show = true;
  },

  [mutation.SET_MODAL_TYPE](state, type) {
    state.modal.type = type;
  },

  [mutation.ADD](state, data) {
    if (state.currentTableName === "books") {
      data["author"] = (
        state.table.authors.data.find((author) => author.id === data.author_id) || { full_name: "" }
      ).full_name;
      data["genre"] = (state.table.genres.data.find((genre) => genre.id === data.genre_id) || { name: "" }).name;
    }

    state.table[state.currentTableName].data = state.table[state.currentTableName].data.concat(data);
  },

  [mutation.UPDATE](state, data) {
    if (state.currentTableName === "books") {
      data["author"] = (
        state.table.authors.data.find((author) => author.id === data.author_id) || { full_name: "" }
      ).full_name;
      data["genre"] = (state.table.genres.data.find((genre) => genre.id === data.genre_id) || { name: "" }).name;
    }

    state.table[state.currentTableName].data = state.table[state.currentTableName].data.map((dataItem, index) => {
      return index === state.selectedIndex ? data : dataItem;
    });
  },

  [mutation.SET_SEARCH](state, search) {
    state.search = search;
  },

  [mutation.CLEAR_TABLE](state, table) {
    state.table[table].data = [];
  },
};

const actions = {
  async [action.ADD]({ state, commit }, data) {
    api[state.currentTableName].add(data).then(({ data }) => {
      const { success } = data;

      if (success == 1) {
        commit(mutation.ADD, data.data);
      }
    });
  },

  async [action.UPDATE]({ state, commit, getters }, data) {
    api[state.currentTableName].update(getters.selectedTableItem.id, data).then(({ data }) => {
      const { success } = data;

      if (success == 1) {
        commit(mutation.UPDATE, data.data);
      }
    });
  },

  async [action.OPEN_MODAL]({ commit }, type) {
    commit(mutation.SET_MODAL_TYPE, type);
    commit(mutation.OPEN_MODAL);
  },

  async [action.DELETE_SELECTED_TABLE_ITEM]({ state, commit, getters }) {
    if (state.selectedIndex !== -1) {
      api[state.currentTableName].delete(getters.selectedTableItem.id).then(({ data }) => {
        const { success } = data;

        if (success == 1) {
          commit(mutation.DELETE_SELECTED);
        }
      });
    }
  },
  async [action.FETCH_DATA]({ commit }, table) {
    if (!(table in api)) return;

    const { data } = await api[table].get();

    commit(mutation.SET_TABLE_DATA, {
      tableName: table,
      tableData: data.data,
    });
  },

  async [action.FETCH_TABLE_DATA]({ commit }, table) {
    if (!(table in api)) return;

    const { data } = await api[table].get();

    // console.log(data.data);
    if (data.success) {
      commit(mutation.UNSET_SELECTED_INDEX);
      commit(mutation.SET_CURRENT_TABLE, table);
      commit(mutation.SET_TABLE_DATA, {
        tableName: table,
        tableData: data.data || [],
      });
    }
  },

  async [action.FETCH_AUTHOR]({ commit }, id) {
    return api["authors"].get(id).then(({ data }) => (data.success == 1 ? data.data : null));
  },

  async [action.FETCH_GENRE]({ commit }, id) {
    return api["genres"].get(id).then(({ data }) => (data.success == 1 ? data.data : null));
  },

  async [action.FETCH_BOOK]({ commit }, id) {
    return api["books"].get(id).then(({ data }) => (data.success == 1 ? data.data : null));
  },

  async [action.CLEAR_CURRENT_TABLE]({ state, commit, getters }) {
    const ids = getters.tableData.map((dataItem) => dataItem.id);

    api[state.currentTableName].delete(ids).then(({ data }) => {
      if (data.success == 1) {
        commit(mutation.CLEAR_TABLE, state.currentTableName);
      }
    });
  },
};

export default {
  state,
  getters,
  mutations,
  actions,
};
