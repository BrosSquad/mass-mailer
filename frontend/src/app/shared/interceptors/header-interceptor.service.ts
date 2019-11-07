import { Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent,
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class HeaderInterceptorService implements HttpInterceptor {
  constructor() {}
  public intercept(
    req: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const request = req.clone({ url: `${environment.api}${req.url}` });

    if (!req.headers.has('Content-Type')) {
      request.headers.append('Content-Type', 'application/json');
    }

    if (!req.headers.has('Accept')) {
      request.headers.append('Accept', 'application/json');
    }

    return next.handle(request);
  }
}
