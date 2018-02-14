import { h } from "preact";
import * as t from "../actionTypes";
import FilterLink from "./FilterLink";

export default function FilterList() {
  return (
    <span>
      <FilterLink type={t.SHOW_ALL}> Show all</FilterLink>
      <FilterLink type={t.SHOW_PS16}>Show 1.6</FilterLink>
      <FilterLink type={t.SHOW_PS17}>Show 1.7</FilterLink>
      <FilterLink type={t.SHOW_OTHER}>Show other</FilterLink>
    </span>
  );
}
