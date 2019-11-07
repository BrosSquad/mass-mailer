import { Action } from '@ngrx/store';
import { AuthActions } from './auth.actions';

export class LogoutAction implements Action {
    public readonly type: string = AuthActions.LOGOUT;
}