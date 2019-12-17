import {Button, makeStyles, TextField} from "@material-ui/core";
import {string, object} from 'yup';
import React, {FC} from 'react';
import {Formik} from "formik";
import {connect} from "react-redux";
import {ResetForm, SetErrors} from "../../../store/actions/login";
import Login from "../../../models/dto/login";
import axios from '../../../axios';
import {AuthActions} from "../../../store/actions/actions";


const useStyles = makeStyles(theme => ({
    form: {
        width: '100%', // Fix IE 11 issue.
        marginTop: theme.spacing(1),
    },
    submit: {
        margin: theme.spacing(3, 0, 2),
    }
}));

interface Props {
    login: (payload: Login, setErrors: SetErrors, resetForm: ResetForm) => void;
}

const LoginForm: FC<Props> = ({login}: Props) => {
    const validationSchema = object().shape<Login>({
        email: string()
            .required('Email field is required')
            .email('Email is not valid')
            .max(200, 'Maximum email length is 200 characters'),
        password: string()
            .required('Password field is required')
            .min(8, 'Password must be at lest 8 characters')
    });

    const initialValues: Login = {
        email: '',
        password: ''
    };

    const onSubmit = async (values: Login, {setErrors, resetForm, setSubmitting}: any) => {
        console.log(values);
        login(values, setErrors, resetForm);
        setSubmitting(false);
    };

    const classes = useStyles();
    return (
        <Formik initialValues={initialValues} onSubmit={onSubmit} validationSchema={validationSchema}>
            {({values, errors, touched, handleChange, handleBlur, handleSubmit, isSubmitting}) => (
                <form className={classes.form} onSubmit={handleSubmit} method="POST">
                    <TextField
                        error={Boolean(errors.email && touched.email)}
                        helperText={errors.email}
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        label="Email Address"
                        name="email"
                        autoComplete="email"
                        value={values.email}
                        onBlur={handleBlur}
                        onChange={handleChange}
                    />
                    <div>
                        <TextField
                            error={Boolean(errors.password && touched.password)}
                            helperText={errors.password}
                            variant="outlined"
                            margin="normal"
                            fullWidth
                            name="password"
                            label="Password"
                            type="password"
                            value={values.password}
                            onBlur={handleBlur}
                            onChange={handleChange}
                        />
                    </div>
                    <Button
                        type="submit"
                        fullWidth
                        variant="contained"
                        color="primary"
                        className={classes.submit}
                        disabled={isSubmitting}
                    >
                        Sign In
                    </Button>
                </form>
            )}
        </Formik>
    );
};

const login = (payload: Login, setErrors: SetErrors, resetForm: ResetForm) => async (dispatch: any) => {
    try {
        const res = await axios.post('/auth/login', payload);
        console.log(res);
        dispatch({
            type: AuthActions.LOGIN,
            payload: res.data
        });
    } catch (err) {
        console.log(err.response);
    }
};

export default connect(null, (dispatch: any) => ({
    login: (payload: Login, setErrors: SetErrors, resetForm: ResetForm) => dispatch(login(payload, setErrors, resetForm))
}))(LoginForm);
