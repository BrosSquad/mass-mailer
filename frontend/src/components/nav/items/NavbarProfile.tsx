import React, { MouseEvent } from 'react';
import { IconButton } from "@material-ui/core";
import { AccountCircle } from "@material-ui/icons";
import NavbarMenuItem from "./NavbarMenuItem";
import { NavbarMenuProps } from "./props";

interface Props extends NavbarMenuProps {
	handleProfileMenuOpen: ( event: MouseEvent<HTMLElement> ) => void;
}


const NavbarProfile = ( { isMobile, handleProfileMenuOpen }: Props ) => (
	<NavbarMenuItem isMobile={ isMobile } name={ 'Profile' }>
		<IconButton
			edge="end"
			onClick={ handleProfileMenuOpen }
			color={ 'inherit' }
		>
			<AccountCircle/>
		</IconButton>
	</NavbarMenuItem>
);

export default NavbarProfile;
