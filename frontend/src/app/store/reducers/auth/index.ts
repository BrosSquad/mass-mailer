import { ActionReducerMap, Action, ActionReducerFactory } from '@ngrx/store';
import {
  AuthActions,
  LoginAction,
  LoginErrorAction,
  UnauthorizedAction,
  ForbiddenAction
} from '../../actions/auth';
import { Error } from 'src/app/shared/error.model';
import { SaveUserAction } from '../../actions/auth/login.action';


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
export function authReducer(
  state: AuthState,
  action: Action
): AuthState {
  switch (action.type) {
    case AuthActions.SAVE_USER:
      return {
        ...state,
        error: {
          forbidden: null,
          unauthorized: null,
          login: null
        },
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
