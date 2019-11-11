import { ActionReducerMap, MetaReducer } from '@ngrx/store';
import { environment } from '../../../environments/environment';
import { authReducer } from './auth';
import { AuthState } from './auth/auth.state';

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

export const metaReducers: MetaReducer<State>[] = !environment.production
  ? []
  : [];
