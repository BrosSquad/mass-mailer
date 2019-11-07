import { ActionReducerMap, Action, ActionReducerFactory } from '@ngrx/store';
import {
  AuthActions,
  LoginAction,
  LoginErrorAction,
  UnauthorizedAction,
  ForbiddenAction
} from '../actions';
import { Error } from 'src/app/shared/error.model';
import { SaveUserAction } from '../actions/login.action';


export interface User {
  name: string;
  surname: string;
  email: string;
  role: string;
}

export interface AuthErrors {
  login: Error;
  unauthorized: Error;
  forbidden: Error;
}

export interface AuthState {
  user: User;
  error: AuthErrors;
}

const initalState: AuthState = {
  user: null,
  error: {
    forbidden: null,
    login: null,
    unauthorized: null
  }
};

export function reducers(
  state: AuthState = initalState,
  action: Action
): AuthState {
  switch (action.type) {
    case AuthActions.SAVE_USER:
      return {
        ...state,
        error: null,
        user: (action as SaveUserAction).payload
      };
    case AuthActions.LOGIN_ERROR:
      return {
        user: null,
        error: {
          forbidden: null,
          unauthorized: null,
          login: (action as LoginErrorAction).payload
        }
      };

    case AuthActions.LOGOUT:
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      return { user: null, error: null };

    case AuthActions.UNAUTHORIZED:
      return {
        ...state,
        error: {
          unauthorized: (action as UnauthorizedAction).payload,
          login: null,
          forbidden: null
        }
      };
    case AuthActions.FORBIDDEN:
      return {
        ...state,
        error: {
          forbidden: (action as ForbiddenAction).payload,
          login: null,
          unauthorized: null
        }
      };
    default:
      return state;
  }
}
