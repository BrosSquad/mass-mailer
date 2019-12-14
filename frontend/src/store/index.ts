import {createStore} from 'redux';
import reducers from './reducers';


const state = createStore(reducers);


export default state;