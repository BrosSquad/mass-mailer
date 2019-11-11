import { Action } from '@ngrx/store';
import { AuthActions } from './auth.actions';
import { SaveImageModel, ChangeImageModel } from 'src/app/shared/models/change-image.model';



export class SaveImageAction implements Action {
    public readonly type: string = AuthActions.SAVE_IMAGE;

    public constructor(public readonly payload: SaveImageModel) {}

}

export class ChangeImageAction implements Action {
    public readonly type: string = AuthActions.CHANGE_IMAGE;

    public constructor(public readonly payload: ChangeImageModel) {} 
}
