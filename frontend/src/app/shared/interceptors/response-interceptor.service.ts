import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpResponse, HttpErrorResponse } from '@angular/common/http';
import { Observable, of, EMPTY, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ResponseInterceptorService implements HttpInterceptor {

  public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req)
      .pipe(
        map(event => {
          if (event instanceof HttpResponse) {
            if (event.body['auth']) {
              localStorage.setItem('token', JSON.stringify(event.body.auth))
            }
          }
          return event;
        }),
        catchError(error => {
          if (error instanceof HttpErrorResponse) {
            return throwError(event);
          }
        })
      );
  }
}
