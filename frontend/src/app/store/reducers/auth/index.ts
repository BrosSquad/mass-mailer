import { Action } from '@ngrx/store';
import {
  AuthActions,
  LoginErrorAction,
  UnauthorizedAction,
  ForbiddenAction
} from '../../actions/auth';
import { SaveUserAction } from '../../actions/auth/login.action';
import { User } from 'src/app/shared/models/user.model';
import { AuthErrors } from 'src/app/shared/models/auth-errors.model';

export interface AuthState {
  user: User;
  error: AuthErrors;
}
export function authReducer(state: AuthState, action: Action): AuthState {
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
      
      const error = { 
        forbidden: null, 
        login: null, 
        unauthorized: null 
      };
      
      return { user: null, error };
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
