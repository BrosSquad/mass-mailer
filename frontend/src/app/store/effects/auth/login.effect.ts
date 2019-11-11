import { Effect, Actions, ofType } from '@ngrx/effects';
import { Injectable } from '@angular/core';
import {
  LoginService,
  LoginSuccess
} from 'src/app/shared/services/auth/login.service';
import {
  AuthActions,
  LoginAction,
  LoginErrorAction,
  SaveUserAction
} from '../../actions/auth';
import { switchMap, exhaustMap, catchError } from 'rxjs/operators';
import { Observable, of } from 'rxjs';
import { Error } from 'src/app/shared/models/error.model';
import { Action } from '@ngrx/store';

@Injectable()
export class LoginEffect {
  public constructor(
    private actions: Actions,
    private loginService: LoginService
  ) {}

  @Effect()
  public login = this.actions.pipe(
    ofType(AuthActions.LOGIN),
    switchMap((res: LoginAction) =>
      this.loginService.login(res.payload).pipe(exhaustMap(this.loginUser))
    )
  );

  public loginUser(data: LoginSuccess | Error): Observable<Action> { 
    if ('message' in data) {
      return of(new LoginErrorAction(data));
    }
    
    
    localStorage.setItem('token', JSON.stringify(data.token));
    localStorage.setItem('user', JSON.stringify(data.user));
    
    return of(new SaveUserAction({ ...data.user }));
  }
}
