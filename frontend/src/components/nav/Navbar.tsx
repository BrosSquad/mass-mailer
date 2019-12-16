import React from 'react';
import { AppBar, Toolbar } from "@material-ui/core";
import { makeStyles, Theme, createStyles } from '@material-ui/core/styles';
import { NavbarDrawer } from "./items";
import NavbarDesktopMenu from "./menus/NavbarDesktopMenu";
import NavbarMobileMenuIndicator from "./menus/NavbarMobileMenuIndicator";
import NavbarMobileMenu from "./NavbarMobileMenu";
import ProfileMenu from "./ProfileMenu";
import Title from "./Title";

const useStyles = makeStyles(( theme: Theme ) =>
	createStyles({
		grow: {
			flexGrow: 1,
		},
		menuButton: {
			marginRight: theme.spacing(2),
		},
	}),
);


const Navbar = () => {
	const classes = useStyles();
	const [anchorEl, setAnchorEl] = React.useState<null | HTMLElement>(null);
	const [mobileMoreAnchorEl, setMobileMoreAnchorEl] = React.useState<null | HTMLElement>(null);
	
	const isMenuOpen = Boolean(anchorEl);
	const isMobileMenuOpen = Boolean(mobileMoreAnchorEl);
	
	const handleProfileMenuOpen = ( event: React.MouseEvent<HTMLElement> ) => {
		setAnchorEl(event.currentTarget);
	};
	
	const handleMobileMenuClose = () => {
		setMobileMoreAnchorEl(null);
	};
	
	const handleMenuClose = () => {
		setAnchorEl(null);
		handleMobileMenuClose();
	};
	
	const handleMobileMenuOpen = ( event: React.MouseEvent<HTMLElement> ) => {
		setMobileMoreAnchorEl(event.currentTarget);
	};
	
	return (
		<div className={ classes.grow }>
			<AppBar position="static">
				<Toolbar>
					<NavbarDrawer/>
					<Title title={ 'Mass Mailer' }/>
					<div className={ classes.grow }/>
					<NavbarDesktopMenu handleProfileMenuOpen={ handleProfileMenuOpen }/>
					<NavbarMobileMenuIndicator handleMobileMenuOpen={ handleMobileMenuOpen }/>
				</Toolbar>
			</AppBar>
			<NavbarMobileMenu id={ 'mobile' } isOpen={ isMobileMenuOpen } handleClose={ handleMobileMenuClose }
			                  profileClose={ handleProfileMenuOpen } anchorEl={ mobileMoreAnchorEl }/>
			<ProfileMenu id={ 'menu' } menuOpen={ isMenuOpen } handleClose={ handleMenuClose } anchorEl={ anchorEl }/>
		</div>
	)
};


export default Navbar;
