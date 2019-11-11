import { AuthState } from './auth.state';
import {
  SaveUserAction,
} from '../../actions/auth';

export const saveUser = (state: AuthState, action: SaveUserAction) => ({
  ...state,
  error: {
    forbidden: null,
    unauthorized: null,
    login: null
  },
  user: (action as SaveUserAction).payload
});

export const logout = (): AuthState => {
  localStorage.removeItem('token');
  localStorage.removeItem('user');

  const error = {
    forbidden: null,
    login: null,
    unauthorized: null
  };

  return { user: null, error };
};
