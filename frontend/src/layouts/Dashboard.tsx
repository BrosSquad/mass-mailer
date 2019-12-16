import React, { PropsWithChildren } from 'react';
import Header from "../components/header/Header";

const Dashboard = ( { children }: PropsWithChildren<any> ) => {
	
	return (
		<>
			<Header/>
			{ children }
		</>
	)
};

export default Dashboard;
