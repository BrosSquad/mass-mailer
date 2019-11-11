import { Action } from '@ngrx/store';

import { AuthActions } from '../../actions/auth/auth.actions';
import {
  LoginErrorAction,
  UnauthorizedAction,
  ForbiddenAction,
  SaveImageAction
} from '../../actions/auth';
import { SaveUserAction } from '../../actions/auth/login.action';

import { logout, saveUser } from './login.reducer';
import { AuthState } from './auth.state';
import { forbidden, unauthorized, loginError } from './errors.reducer';
import { changeImage } from './change-image.reducer';

export function authReducer(state: AuthState, action: Action): AuthState {
  switch (action.type) {
    case AuthActions.SAVE_IMAGE:
      return changeImage(state, action as SaveImageAction);
    case AuthActions.SAVE_USER:
      return saveUser(state, action as SaveUserAction);
    case AuthActions.LOGIN_ERROR:
      return loginError(action as LoginErrorAction);
    case AuthActions.LOGOUT:
      return logout();
    case AuthActions.UNAUTHORIZED:
      return unauthorized(state, action as UnauthorizedAction);
    case AuthActions.FORBIDDEN:
      return forbidden(state, action as ForbiddenAction);
    default:
      return state;
  }
}
