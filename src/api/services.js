import { serviceFactory, get } from "./common";

const AUTHOR = "author";
const GENRE = "genre";
const BOOK = "book";

export default {
  get,
  authors: serviceFactory(AUTHOR),
  genres: serviceFactory(GENRE),
  books: serviceFactory(BOOK),
};
