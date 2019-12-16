import { Theme } from "@material-ui/core";
import { createStyles } from "@material-ui/core/styles";
import makeStyles from "@material-ui/core/styles/makeStyles";
import React, { MouseEvent } from 'react';
import { NavbarMessages, NavbarProfile } from "../items";
import NavbarNotification from "../items/NavbarNotification";

interface Props {
	handleProfileMenuOpen: ( event: MouseEvent<HTMLElement> ) => void;
}


const useStyles = makeStyles((theme: Theme) => createStyles({
	sectionDesktop: {
		display: 'none',
		[ theme.breakpoints.up('md') ]: {
			display: 'flex',
		},
	}
}));

const NavbarDesktopMenu = ( { handleProfileMenuOpen }: Props ) => {
	const classes = useStyles();
	return (
		<div className={ classes.sectionDesktop }>
			<NavbarMessages isMobile={ false } numberOfNotifications={ 17 }/>
			<NavbarNotification color={ 'secondary' } numberOfNotifications={ 17 } isMobile={ false }/>
			<NavbarProfile handleProfileMenuOpen={ handleProfileMenuOpen } isMobile={ false }/>
		</div>
	);
};


export default NavbarDesktopMenu;
