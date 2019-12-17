import {Action} from "redux";
import {AuthActions} from "../actions/actions";

export interface User {
  name: string;
  surname: string;
  email: string;
}

export interface Auth {
  token: string;
  refreshToken: string;
}

export interface AuthState {
  user: User | null;
  auth: Auth | null;
}

const initialState: AuthState = {
  user: null,
  auth: null
};



export default (state: AuthState = initialState, action: Action) => {
  switch (action.type) {
    case AuthActions.LOGIN:
      return state;
    default:
      return state;
  }
};
