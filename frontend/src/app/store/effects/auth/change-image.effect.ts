import { Actions, Effect, ofType } from '@ngrx/effects';
import { Injectable } from '@angular/core';
import {
  AuthActions,
  ChangeImageAction,
  SaveImageAction
} from '../../actions/auth';
import { switchMap, exhaustMap, map } from 'rxjs/operators';
import { UserService } from 'src/app/shared/services/user.service';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ChangeImageEffect {
  public constructor(
    private readonly actions: Actions,
    private readonly userService: UserService
  ) {}

  @Effect()
  public changeImage = this.actions.pipe(
    ofType(AuthActions.CHANGE_IMAGE),
    exhaustMap((action: ChangeImageAction) => {
      console.log(action);
      return this.userService.changeImage(action.payload).pipe(
        map((res) => res.image),
        switchMap(this.changeAvatar)
      );
    })
  );

  public changeAvatar(image: string) {
    return of(new SaveImageAction({ path: image, type: 'avatar' }));
  }
}
