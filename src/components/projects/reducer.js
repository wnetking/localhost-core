import * as t from "./actionTypes";

export default function reducer(state = { fatching: true }, action) {
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
    default:
      return state;
  }
}
