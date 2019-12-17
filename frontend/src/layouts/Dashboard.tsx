import React, {FC, PropsWithChildren} from 'react';
import Header from "../components/header/Header";

const Dashboard: FC = ( { children }: PropsWithChildren<any> ) => {
	
	return (
		<>
			<Header/>
			{ children }
		</>
	)
};

export default Dashboard;
