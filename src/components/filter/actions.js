import * as t from "./actionTypes";

export const setVisibilityFilter = filter => ({
  type: t.SET_VISIBILITY_FILTER,
  payload: {
    filter
  }
});
