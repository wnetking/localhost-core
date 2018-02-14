import { fork, all } from "redux-saga/effects";
import projects from "./projects";
import details from "./details";

export default function* rootSagas() {
  yield all([fork(projects.saga), fork(details.saga)]);
}
