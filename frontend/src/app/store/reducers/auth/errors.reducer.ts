import { AuthState } from './auth.state';
import {
  LoginErrorAction,
  UnauthorizedAction,
  ForbiddenAction
} from '../../actions/auth';

export const loginError = ({
  payload: login
}: LoginErrorAction): AuthState => ({
  user: null,
  error: {
    forbidden: null,
    unauthorized: null,
    login
  }
});

export const forbidden = (
  state: AuthState,
  { payload }: ForbiddenAction
): AuthState => ({
  ...state,
  error: {
    forbidden: payload,
    login: null,
    unauthorized: null
  }
});

export const unauthorized = (
  state: AuthState,
  { payload }: UnauthorizedAction
): AuthState => ({
  ...state,
  error: {
    forbidden: null,
    login: null,
    unauthorized: payload
  }
});
