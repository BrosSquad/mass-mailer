import { Action } from '@ngrx/store';
import { AuthActions } from './auth.actions';

export interface Login {
  email: string;
  password: string;
}

export interface SaveUser {
  name: string;
  surname: string;
  email: string;
  role: string;
}

export class SaveUserAction implements Action {
  public readonly type: string = AuthActions.SAVE_USER;
  public constructor(public readonly payload: SaveUser) {}
}


export class LoginAction implements Action {
  public readonly type: string = AuthActions.LOGIN;
  public constructor(public readonly payload: Login) {}
}