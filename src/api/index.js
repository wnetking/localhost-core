import config from "./config";

export default {
  getProgectList() {
    return fetch(config.BASE_URL, {
      method: "POST",
      headers: config.HEADERS
    })
      .then(response => response.json())
      .catch(err => err);
  },
  getProductInfo(projectName, type) {
    return fetch(config.BASE_URL, {
      method: "POST",
      body: `show_modules=${projectName}&type=${type}`,
      headers: config.HEADERS
    })
      .then(response => response.json())
      .catch(err => err);
  },
  clearDataBase(projectName, type) {
    if (confirm("Are you sure? It's  " + projectName + " data base")) {
      return fetch(config.BASE_URL, {
        method: "POST",
        body: `clear_data_base=${projectName}&type=${type}`,
        headers: config.HEADERS
      })
        .then(response => response.text())
        .catch(err => err);
    }
  },
  createGitStructure(projectName) {
    return fetch(config.BASE_URL, {
      method: "POST",
      body: `create_git_structure=${projectName}`,
      headers: config.HEADERS
    })
      .then(response => response.text())
      .catch(err => err);
  },
  removeProject(projectName, type) {
    if (confirm("Are you sure? You agree delete " + projectName + "?")) {
      return fetch(config.BASE_URL, {
        method: "POST",
        body: `remove_project=${projectName}&type=${type}`,
        headers: config.HEADERS
      })
        .then(response => response.text())
        .catch(err => err);
    }
  }
};
