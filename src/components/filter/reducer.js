import * as t from "./actionTypes";

export default function reducer(state = t.SHOW_ALL, action) {
  switch (action.type) {
    case t.SET_VISIBILITY_FILTER:
      return action.payload.filter;
    default:
      return state;
  }
}

export const getFilterProject = (project, filter) => {
  switch (filter) {
    case t.SHOW_ALL:
      return project;
    case t.SHOW_PS16:
      return {
        ...project,
        ...{
          data: project.data.filter(t => t.type === "PS16")
        }
      };
    case t.SHOW_PS17:
      return {
        ...project,
        ...{
          data: project.data.filter(t => t.type === "PS17")
        }
      };
    case t.SHOW_OTHER:
      return {
        ...project,
        ...{
          data: project.data.filter(t => t.type === "other")
        }
      };
    default:
      throw new Error("Unknown filter: " + filter);
  }
};
