import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent } from '@angular/common/http';
import { Observable } from 'rxjs';



@Injectable({
  providedIn: 'root'
})
export class AuthInterceptorService implements HttpInterceptor {
  public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const jsonTokenString: string | null = localStorage.getItem('token');
    
    if(jsonTokenString) {
      const deserialize = JSON.parse(jsonTokenString);
      req.headers.append('X-Refresh-Token', deserialize.refreshToken);
       req.headers.append('Authorization', `${deserialize.authType} ${deserialize.token}`);
    }

    return next.handle(req);
  }

}
