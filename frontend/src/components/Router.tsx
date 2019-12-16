import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import Dashboard from "../layouts/Dashboard";
import Login from "../pages/Login";

const Router = () => (
	<BrowserRouter>
		<Switch>
			<Route path="/login">
				<Login/>
			</Route>
			<Dashboard>
				<Route path="/">
				</Route>
			</Dashboard>
		</Switch>
	</BrowserRouter>
);

export default Router;
