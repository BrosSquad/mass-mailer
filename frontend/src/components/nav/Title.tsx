import { createStyles, makeStyles, Theme, Typography } from "@material-ui/core";
import React from 'react';

const useStyles = makeStyles(( theme: Theme ) => createStyles({
	title: {
		display: 'none',
		[ theme.breakpoints.up('sm') ]: {
			display: 'block',
		},
	},
}));


const Title = ( { title }: { title: string } ) => {
	const classes = useStyles();
	return (
		<Typography className={ classes.title } variant="h6" noWrap>
			{ title }
		</Typography>
	)
};


export default Title;
