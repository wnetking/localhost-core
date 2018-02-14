import * as t from "./actionTypes";

export const changeTheme = data => ({
  type: t.CHANGE_THEME,
  payload: {
    theme: data
  }
});

export const changeLang = data => ({
  type: t.CHANGE_LANG,
  payload: {
    lang: data
  }
});

export const changeHoverEffect = data => ({
  type: t.CHANGE_HOVER_EFFECT,
  payload: {
    hoverEffect: data
  }
});

export const changeTypeOfVeiw = data => ({
  type: t.CHANGE_TYPE_OF_VEIW,
  payload: {
    typeOfVeiw: data
  }
});

export const toggleSettings = data => ({
  type: t.TOGGLE_SETTINGS,
  payload: {}
});
