import { Effect, Actions, ofType } from '@ngrx/effects';
import { Injectable } from '@angular/core';
import { LoginService, LoginSuccess } from 'src/app/shared/services/auth/login.service';
import { AuthActions, LoginAction, LoginErrorAction, SaveUserAction } from '../actions';
import { switchMap, exhaustMap } from 'rxjs/operators';
import { Observable, of } from 'rxjs';
import { Error } from 'src/app/shared/error.model';
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
      this.loginService.login(res.payload)
        .pipe(exhaustMap(this.loginUser)))
  );

  public loginUser(data: LoginSuccess | Error): Observable<Action> {
    if(data instanceof LoginSuccess) {
      localStorage.setItem('token', JSON.stringify(data.token));
      localStorage.setItem('user', JSON.stringify(data.user));
      return of(new SaveUserAction({...data.user}));
    }

    return of(new LoginErrorAction(data));
  }
}
