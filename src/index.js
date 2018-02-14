import { h, render } from "preact";
import { Provider } from "preact-redux";
import configureStore from "./store";

import ProjectList from "./components/projects/components/ProjectList";
import Info from "./components/details/components/Info";
import FilterList from "./components/filter/components/FilterList";
import SettingButton from "./components/settings/components/SettingButton";

import "./index.css";
import "./App.css";

const store = configureStore();

const Root = () => (
  <Provider store={store}>
    <div>
      <div className="navbar-top">
        <FilterList />
        <span className="btn">|</span>
        <SettingButton />
      </div>
      <ProjectList />
      <Info />
    </div>
  </Provider>
);

render(<Root />, document.getElementById("root"));
