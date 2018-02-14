import { call, put, takeLatest } from "redux-saga/effects";
import * as t from "./actionTypes";
import * as actions from "./actions";
import { getProjectList } from "../projects/actions";
import api from "../../api";

function* fetchProgectInfo(action) {
  try {
    const data = yield call(
      api.getProductInfo,
      action.payload.projectName,
      action.payload.type
    );
    yield put(actions.projectInfoSuccess(data));
  } catch (e) {
    yield put(actions.projectInfoFailed(e.message));
  }
}

function* clearDataBase(action) {
  try {
    const data = yield call(
      api.clearDataBase,
      action.payload.projectName,
      action.payload.type
    );
    yield put(actions.clearDBSuccess(data));
  } catch (e) {
    yield put(actions.clearDBFailed(e.message));
  }
}

function* deleteProject(action) {
  try {
    const data = yield call(
      api.removeProject,
      action.payload.projectName,
      action.payload.type
    );
    yield put(actions.clearDBSuccess(data));
    yield put(getProjectList());
    yield put(actions.closeProjectInfo());
  } catch (e) {
    yield put(actions.clearDBFailed(e.message));
  }
}

function* saga() {
  yield takeLatest(t.FETCH_REQUESTED, fetchProgectInfo);
  yield takeLatest(t.DATA_BASE_DELETE_REQUESTED, clearDataBase);
  yield takeLatest(t.PROJECT_DELETE_REQUESTED, deleteProject);
}

export default saga;
