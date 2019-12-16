import { Menu, MenuItem } from "@material-ui/core";
import React from 'react';

interface Props {
	anchorEl: Element | null | undefined;
	id: string;
	menuOpen: boolean;
	handleClose: () => void;
}

const ProfileMenu = ( { anchorEl, handleClose, id, menuOpen }: Props ) => {
	return (
		<Menu
			anchorEl={ anchorEl }
			anchorOrigin={ { vertical: 'top', horizontal: 'right' } }
			id={ id }
			keepMounted
			transformOrigin={ { vertical: 'top', horizontal: 'right' } }
			open={ menuOpen }
			onClose={ handleClose }
		>
			<MenuItem onClick={ handleClose }>Profile</MenuItem>
			<MenuItem onClick={ handleClose }>My account</MenuItem>
		</Menu>
	);
};

export default ProfileMenu;
