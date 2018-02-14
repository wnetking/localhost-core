import * as t from "./actionTypes";

export const getProjectInfo = projectName => ({
  type: t.FETCH_REQUESTED,
  payload: {
    data: null,
    fatching: true,
    show: true,
    projectName
  }
});

export const projectInfoSuccess = data => ({
  type: t.FETCH_REQUESTED_SUCCEEDED,
  payload: {
    data,
    message: "",
    fatching: false
  }
});

export const projectInfoFailed = err => ({
  type: t.FETCH_REQUESTED_FAILED,
  payload: {
    fatching: false,
    error: {
      status: true,
      message: err
    }
  }
});

export const closeProjectInfo = () => ({
  type: t.CLOSE_PROJECT_INFO,
  payload: {
    show: false
  }
});

export const clearDbRequest = (projectName, type) => ({
  type: t.DATA_BASE_DELETE_REQUESTED,
  payload: {
    projectName,
    type,
    makeRequest: true
  }
});

export const clearDBSuccess = data => ({
  type: t.DATA_BASE_DELETE_REQUESTED_SUCCEEDED,
  payload: {
    message: data,
    fatching: false,
    makeRequest: false
  }
});

export const clearDBFailed = err => ({
  type: t.DATA_BASE_DELETE_REQUESTED_FAILED,
  payload: {
    fatching: false,
    makeRequest: false,
    error: {
      status: true,
      message: err
    }
  }
});

export const removeProject = (projectName, type) => ({
  type: t.PROJECT_DELETE_REQUESTED,
  payload: {
    projectName,
    type,
    makeRequest: true
  }
});
