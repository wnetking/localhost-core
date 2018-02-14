import { combineReducers } from "redux";
import projects from "./projects";
import details from "./details";
import filter from "./filter";
import settings from "./settings";

export default combineReducers({
  projects: projects.reducer,
  details: details.reducer,
  filter: filter.reducer,
  settings: settings.reducer
});
