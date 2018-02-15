import { h, render } from "preact";
import { Provider } from "preact-redux";
import configureStore from "./store";
import Root from "./components/Root";

import "./index.css";
import "./App.css";

const store = configureStore();

render(
  <Provider store={store}>
    <div>
      <Root />
    </div>
  </Provider>,
  document.getElementById("root")
);
