import { Action } from '@ngrx/store';
import { AuthActions } from './auth.actions';
import { Error } from 'src/app/shared/error.model';

export class LoginErrorAction implements Action {
    public readonly type: string = AuthActions.LOGIN_ERROR;

    public constructor(public readonly payload: Error) {}
}