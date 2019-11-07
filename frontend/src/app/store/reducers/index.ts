import {
  ActionReducer,
  ActionReducerMap,
  createFeatureSelector,
  createSelector,
  MetaReducer
} from '@ngrx/store';
import { environment } from '../../../environments/environment';
import { AuthState, authReducer } from './auth';

export interface State {
  auth: AuthState;
}

export const reducers: ActionReducerMap<State> = {
  auth: authReducer
};



export const initialState: State = {
  auth: {
    user: null,
    error: {
      forbidden: null,
      login: null,
      unauthorized: null
    }
  }
};

export const metaReducers: MetaReducer<State>[] = !environment.production ? [] : [];
