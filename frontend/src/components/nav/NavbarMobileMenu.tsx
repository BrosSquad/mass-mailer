import { Menu, MenuItem } from "@material-ui/core";
import React, { MouseEvent } from 'react';
import NavbarMessages from "./items/NavbarMessages";
import NavbarNotification from "./items/NavbarNotification";
import NavbarProfile from "./items/NavbarProfile";

interface Props {
	anchorEl: Element | null | undefined;
	id: string;
	isOpen: boolean;
	handleClose: () => void;
	profileClose: ( event: MouseEvent<HTMLElement> ) => void;
}

const NabvarMobileMenu = ( { anchorEl, id, handleClose, isOpen, profileClose }: Props ) => {
	return (
		<Menu
			anchorEl={ anchorEl }
			anchorOrigin={ { vertical: 'top', horizontal: 'right' } }
			id={ id }
			keepMounted
			transformOrigin={ { vertical: 'top', horizontal: 'right' } }
			open={ isOpen }
			onClose={ handleClose }
		>
			<MenuItem>
				<NavbarMessages isMobile={ true } numberOfNotifications={ 17 }/>
			</MenuItem>
			<MenuItem>
				<NavbarNotification numberOfNotifications={ 17 } isMobile={ true }/>
			</MenuItem>
			<MenuItem onClick={ profileClose }>
				<NavbarProfile isMobile={ true } handleProfileMenuOpen={ profileClose }/>
			</MenuItem>
		</Menu>
	)
};

export default NabvarMobileMenu;
