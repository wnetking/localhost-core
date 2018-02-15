import * as t from "./actionTypes";

const defaultSettings = {
  theme: "light",
  lang: "en",
  hoverEffect: "rollover",
  typeOfVeiw: "small-grid",
  show: false
};

export default function reducer(state = defaultSettings, action) {
  switch (action.type) {
    case t.CHANGE_SETTINGS:
      return {
        ...state,
        ...action.payload.data
      };
    case t.TOGGLE_SETTINGS:
      return {
        ...state,
        ...{
          show: !state.show
        }
      };
    default:
      return state;
  }
}
