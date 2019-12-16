import React, { FC } from 'react';
import { Provider } from 'react-redux';
import CssBaseline from '@material-ui/core/CssBaseline';

import store from './store';
import Header from './components/header/Header';
import Router from './components/Router';

const App: FC = () => {
	return (
		<Provider store={ store }>
			<CssBaseline/>
			<Header/>
			<Router/>
		</Provider>
	);
};

export default App;
