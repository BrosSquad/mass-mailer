import { AuthErrors, User } from 'src/app/shared/models';

export interface AuthState {
  user: User;
  error: AuthErrors;
}
