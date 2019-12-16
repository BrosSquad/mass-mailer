import React from 'react';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import Dashboard from "../layouts/Dashboard";
import Login from "../pages/Login";
import Home from "./home/Home";
import ProtectedRoute from "./ProtectedRoute";

const Router = () => (
	<BrowserRouter>
		<Switch>
			<Route path="/login">
				<Login/>
			</Route>
			<Dashboard>
				<ProtectedRoute path="/" redirect="/login" component={ Home }/>
			</Dashboard>
		</Switch>
	</BrowserRouter>
);

export default Router;
