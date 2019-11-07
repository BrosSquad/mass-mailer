import { Injectable } from '@angular/core';
import {
  CanActivate,
  CanActivateChild,
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
  UrlTree,
  Router
} from '@angular/router';
import { Observable } from 'rxjs';
import { JwtHelperService } from '@auth0/angular-jwt';

@Injectable({
  providedIn: 'root'
})
export class AuthGuardGuard implements CanActivate, CanActivateChild {
  private jwtHelper: JwtHelperService = new JwtHelperService();
  public constructor(protected readonly router: Router) {}

  protected activate(): boolean | Promise<boolean> {
    const tokenJson = localStorage.getItem('token');

    if (!tokenJson) {
      return this.router.navigateByUrl('/');
    }

    const jwt = JSON.parse(tokenJson);

    const payload = this.jwtHelper.decodeToken(jwt.token);

    if (payload === null) {
      return false;
    }
    return !this.jwtHelper.isTokenExpired(jwt.token);
  }

  public canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ):
    | Observable<boolean | UrlTree>
    | Promise<boolean | UrlTree>
    | boolean
    | UrlTree {
    try {
      if (!this.activate()) {
        return this.router.navigateByUrl('');
      }
    } catch (err) {
      return this.router.navigateByUrl('');
    }

    return true;
  }

  public canActivateChild(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ):
    | Observable<boolean | UrlTree>
    | Promise<boolean | UrlTree>
    | boolean
    | UrlTree {
    try {
      if (!this.activate()) {
        return this.router.navigateByUrl('');
      }
    } catch (err) {
      return this.router.navigateByUrl('');
    }

    return true;
  }
}
