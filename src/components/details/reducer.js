import * as t from "./actionTypes";

export default function reducer(
  state = { show: false, fatching: true },
  action
) {
  switch (action.type) {
    case t.FETCH_REQUESTED:
      return {
        ...state,
        ...action.payload
      };
    case t.FETCH_REQUESTED_SUCCEEDED:
      return {
        ...state,
        ...action.payload
      };
    case t.FETCH_REQUESTED_FAILED:
      return {
        ...state,
        ...action.payload
      };
    case t.DATA_BASE_DELETE_REQUESTED:
      return {
        ...state,
        ...action.payload
      };
    case t.DATA_BASE_DELETE_REQUESTED_SUCCEEDED:
      return {
        ...state,
        ...action.payload
      };
    case t.DATA_BASE_DELETE_REQUESTED_FAILED:
      return {
        ...state,
        ...action.payload
      };
    case t.CLOSE_PROJECT_INFO:
      return {
        ...state,
        ...action.payload
      };
    case t.PROJECT_DELETE_REQUESTED:
      return {
        ...state,
        ...action.payload
      };
    default:
      return state;
  }
}
