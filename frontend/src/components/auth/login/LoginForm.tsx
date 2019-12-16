import { Button, Checkbox, FormControlLabel, makeStyles, TextField } from "@material-ui/core";
import React from 'react';

const useStyles = makeStyles(theme => ( {
	form: {
		width: '100%', // Fix IE 11 issue.
		marginTop: theme.spacing(1),
	},
	submit: {
		margin: theme.spacing(3, 0, 2),
	}
} ));

const LoginForm = () => {
	const classes = useStyles();
	return (
		<form className={ classes.form } noValidate>
			<TextField
				variant="outlined"
				margin="normal"
				required
				fullWidth
				id="email"
				label="Email Address"
				name="email"
				autoComplete="email"
				autoFocus
			/>
			<TextField
				variant="outlined"
				margin="normal"
				required
				fullWidth
				name="password"
				label="Password"
				type="password"
				id="password"
				autoComplete="current-password"
			/>
			<FormControlLabel
				control={ <Checkbox value="remember" color="primary"/> }
				label="Remember me"
			/>
			<Button
				type="submit"
				fullWidth
				variant="contained"
				color="primary"
				className={ classes.submit }
			>
				Sign In
			</Button>
		</form>
	);
};

export default LoginForm;
