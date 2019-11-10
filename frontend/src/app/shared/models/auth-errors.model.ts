import { Error } from './error.model';

export interface AuthErrors {
  login: Error;
  unauthorized: Error;
  forbidden: Error;
}
