import * as t from "./actionTypes";

export const changeSettings = data => ({
  type: t.CHANGE_SETTINGS,
  payload: {
    data
  }
});

export const toggleSettings = data => ({
  type: t.TOGGLE_SETTINGS,
  payload: {}
});
