import React, {PropsWithChildren} from 'react';
import {Route} from "react-router-dom";

interface Props {
    path: string;
    redirect: string;
    component: any;
}

const ProtectedRoute = ({
                            component: Component,
                            path,
                            redirect,
                            children,
                            ...rest
                        }
                            : PropsWithChildren<Props>) => {
    // TODO: Add login for logged in users and redirection
    return (
        <Route path={path}>
            <Component {...rest}>
                {children}
            </Component>
        </Route>
    );
};


export default ProtectedRoute;

