import { combineReducers, ReducersMapObject } from "redux";
import authReducer from './auth';

const reducers: ReducersMapObject = {
    auth: authReducer
};

export default combineReducers(reducers);