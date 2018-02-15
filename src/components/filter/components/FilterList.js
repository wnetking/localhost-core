import { h } from "preact";
import * as type from "../actionTypes";
import { connect } from "preact-redux";
import t from "../../../translations";
import FilterLink from "./FilterLink";

function FilterList({ settings }) {
  return (
    <span>
      <FilterLink type={type.SHOW_ALL}>
        {t(`Show all`, settings.lang)}
      </FilterLink>
      <FilterLink type={type.SHOW_PS16}>
        {t(`Show 1.6`, settings.lang)}
      </FilterLink>
      <FilterLink type={type.SHOW_PS17}>
        {t(`Show 1.7`, settings.lang)}
      </FilterLink>
      <FilterLink type={type.SHOW_OTHER}>
        {t(`Show other`, settings.lang)}
      </FilterLink>
    </span>
  );
}

export default connect(state => state)(FilterList);
