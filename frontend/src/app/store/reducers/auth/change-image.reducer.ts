import { AuthState } from './auth.state';
import { ChangeImageAction, SaveImageAction } from '../../actions/auth';
import { logout } from './login.reducer';
import { User } from 'src/app/shared/models';

export const changeImage = (
  state: AuthState,
  { payload: { path, type } }: SaveImageAction
): AuthState => {
  const userJson = localStorage.getItem('user');

  if (!userJson) {
    return logout();
  }

  const user: User = JSON.parse(userJson);

  user[type] = path;

  localStorage.setItem('user', JSON.stringify(user));

  return {
    ...state,
    user: { ...state.user, [type]: path }
  };
};
