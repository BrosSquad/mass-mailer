import { createStyles, IconButton, makeStyles, Theme } from "@material-ui/core";
import { More as MoreIcon } from "@material-ui/icons";
import React, { MouseEvent } from 'react';

interface Props {
	handleMobileMenuOpen: ( event: MouseEvent<HTMLElement> ) => void;
}

const useStyles = makeStyles(( theme: Theme ) => createStyles({
	sectionMobile: {
		display: 'flex',
		[ theme.breakpoints.up('md') ]: {
			display: 'none',
		},
	},
}));


const NavbarMobileMenuIndicator = ( { handleMobileMenuOpen }: Props ) => {
	const classes = useStyles();
	return (
		<div className={ classes.sectionMobile }>
			<IconButton
				onClick={ handleMobileMenuOpen }
				color="inherit"
			>
				<MoreIcon/>
			</IconButton>
		</div>
	);
};

export default NavbarMobileMenuIndicator;
