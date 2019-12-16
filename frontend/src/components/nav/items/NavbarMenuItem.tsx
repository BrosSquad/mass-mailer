import React from 'react';
import { NavbarMenuItemProps } from "./props";


const NavbarMenuItem = ( { name, isMobile, children }: NavbarMenuItemProps ) => {
	return (
		<>
			{ children }
			{ isMobile ? <p>{ name }</p> : null }
		</>
	)
	
};


export default NavbarMenuItem;
