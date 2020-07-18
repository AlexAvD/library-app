import ViewTables from "@/views/ViewTables";
import tables from "./tables";
import ViewBooks from "@/views/ViewBooks";

export default [
  {
    path: "/books",
    name: "books",
    meta: {
      title: "Books in last decade",
      nav: {
        label: "Decade",
        show: true,
      },
    },
    component: ViewBooks,
  },
  {
    path: "/tables",
    name: "tables",
    meta: {
      title: "Tables",
      nav: {
        label: "Tables",
        show: false,
      },
    },
    component: ViewTables,
    children: tables,
    redirect: { name: "table-books" },
  },
];
