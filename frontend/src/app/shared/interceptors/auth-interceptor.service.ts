import { Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent
} from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthInterceptorService implements HttpInterceptor {
  public intercept(
    req: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const jsonTokenString: string | null = localStorage.getItem('token');
    let newHeaders = req.headers;
    if (jsonTokenString) {
      const deserialize = JSON.parse(jsonTokenString);
      newHeaders = req.headers
        .append('X-Refresh-Token', deserialize.refreshToken)
        .append(
          'Authorization',
          `${deserialize.authType} ${deserialize.token}`
        );
    }

    if (newHeaders !== null) {
      return next.handle(req.clone({headers: newHeaders}));
    }
    return next.handle(req);
  }
}
