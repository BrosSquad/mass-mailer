import { IconButton } from "@material-ui/core";
import { Menu as MenuIcon } from "@material-ui/icons";
import React from 'react';


const NavbarDrawer = ({classes}: any) => (
	<IconButton
		edge="start"
		className={ classes }
		color="inherit"
	>
		<MenuIcon/>
	</IconButton>
);

export default NavbarDrawer;
