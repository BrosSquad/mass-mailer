import {
	Avatar,
	Container,
	Grid,
	Link, makeStyles,
	Typography
} from "@material-ui/core";
import React from 'react';
import LoginForm from "../components/auth/login/LoginForm";

const useStyles = makeStyles(theme => ( {
	paper: {
		marginTop: theme.spacing(8),
		display: 'flex',
		flexDirection: 'column',
		alignItems: 'center',
	},
	avatar: {
		margin: theme.spacing(1),
		backgroundColor: theme.palette.secondary.main,
	},
	lowerTitleDown: {
		marginBottom: theme.spacing(2),
	}
} ));


const Login = () => {
	const classes = useStyles();
	return (
		<Container component="main" maxWidth="sm">
			<div className={ classes.paper }>
				<Avatar className={ classes.avatar }/>
				<Typography component="h1" variant="h5" className={classes.lowerTitleDown}>
					Sign in to <b>Mass Mailer</b>
				</Typography>
				<LoginForm/>
				<Grid container>
					<Grid item xs>
						<Link href="#" variant="body2">
							Forgot password?
						</Link>
					</Grid>
				</Grid>
			</div>
		</Container>
	)
};

export default Login;
