import { call, put, takeLatest } from "redux-saga/effects";
import * as t from "./actionTypes";
import * as actions from "./actions";
import api from "../../api";

function* fetchAllProjects() {
  try {
    const data = yield call(api.getProgectList, null);
    yield put(actions.projectListSuccess(data));
  } catch (e) {
    yield put(actions.projectListFailed(e.message));
  }
}

function* saga() {
  yield takeLatest(t.FETCH_REQUESTED, fetchAllProjects);
}

export default saga;
