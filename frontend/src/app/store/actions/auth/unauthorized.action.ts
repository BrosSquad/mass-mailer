import { Action } from '@ngrx/store';
import { AuthActions } from './auth.actions';
import { Error } from 'src/app/shared/error.model';

export class UnauthorizedAction implements Action {
    public readonly type: string = AuthActions.UNAUTHORIZED;

    public constructor(public readonly payload: Error) {}
}