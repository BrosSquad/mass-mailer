import { Action } from '@ngrx/store';
import { AuthActions } from './auth.actions';
import { User } from 'src/app/shared/models';

export interface Login {
  email: string;
  password: string;
}


export class SaveUserAction implements Action {
  public readonly type: string = AuthActions.SAVE_USER;
  public constructor(public readonly payload: User) {}
}


export class LoginAction implements Action {
  public readonly type: string = AuthActions.LOGIN;
  public constructor(public readonly payload: Login) {}
}