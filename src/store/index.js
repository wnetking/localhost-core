import { createStore, applyMiddleware } from "redux";
import createSagaMiddleware from "redux-saga";
import throttle from "lodash/throttle";
import rootReducer from "../components/rootReducer";
import rootSagas from "../components/rootSagas";

import { loadState, saveState } from "../api/localStorage";

const sagaMiddleware = createSagaMiddleware();
const persistendState = loadState();

function configureStore(initialState = persistendState) {
  const store = createStore(
    rootReducer,
    initialState,
    applyMiddleware(sagaMiddleware)
  );
  sagaMiddleware.run(rootSagas);

  // store.subscribe(() => console.log(store.getState()));

  store.subscribe(
    throttle(() => {
      saveState(store.getState());
    }, 1000)
  );

  return store;
}

export default configureStore;
