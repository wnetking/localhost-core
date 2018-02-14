import * as t from "./actionTypes";

export const getProjectList = () => ({
  type: t.FETCH_REQUESTED,
  payload: {
    data: null,
    fatching: true
  }
});

export const projectListSuccess = data => ({
  type: t.FETCH_REQUESTED_SUCCEEDED,
  payload: {
    data,
    fatching: false
  }
});

export const projectListFailed = err => ({
  type: t.FETCH_REQUESTED_FAILED,
  payload: {
    fatching: false,
    error: {
      status: true,
      message: err
    }
  }
});

export const getProjectInfo = (projectName, type) => ({
  type: t.INFO_FETCH_REQUESTED,
  payload: {
    data: null,
    fatching: true,
    show: true,
    projectName,
    type
  }
});
