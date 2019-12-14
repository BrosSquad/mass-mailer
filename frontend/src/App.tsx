import React, { FC } from 'react';
import { Provider } from 'react-redux';

import store from './store';
import Header from './components/header/Header';
import Router from './components/Router';

const App: FC = () => {
  return (
    <Provider store={store}>
      <Header />
      <Router />
    </Provider>
  );
};

export default App;
