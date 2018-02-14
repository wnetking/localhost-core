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
    case t.CHANGE_THEME:
      return {
        ...state,
        ...action.payload
      };
    case t.CHANGE_LANG:
      return {
        ...state,
        ...action.payload
      };
    case t.CHANGE_HOVER_EFFECT:
      return {
        ...state,
        ...action.payload
      };
    case t.CHANGE_TYPE_OF_VEIW:
      return {
        ...state,
        ...action.payload
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
