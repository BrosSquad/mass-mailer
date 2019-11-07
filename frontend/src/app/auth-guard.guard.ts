import { Injectable } from '@angular/core';
import {
  CanActivate,
  CanActivateChild,
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
  UrlTree,
  Router
} from '@angular/router';
import { Observable, of, from } from 'rxjs';
import { JwtHelperService } from '@auth0/angular-jwt';
import { UserService } from './shared/services/user.service';
import { catchError, switchMap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthGuardGuard implements CanActivate, CanActivateChild {
  private jwtHelper: JwtHelperService = new JwtHelperService();
  public constructor(
    protected readonly router: Router,
    private readonly userService: UserService
  ) {}

  protected activate(): Observable<boolean> {
    const tokenJson = localStorage.getItem('token');

    if (!tokenJson) {
      return from(this.router.navigateByUrl('/'));
    }

    const jwt = JSON.parse(tokenJson);

    const payload = this.jwtHelper.decodeToken(jwt.token);
    if (payload === null) {
      return of(false);
    }
    const expires: Date | null = this.jwtHelper.getTokenExpirationDate(
      jwt.token
    );

    if (expires === null) {
      return of(false);
    }

    // TODO: If token has expires try to refresh it
    const hasExpired: boolean = new Date() > expires;

    if (hasExpired) {
      return this.userService.me().pipe(
        catchError((_) => from(this.router.navigateByUrl('/'))),
        switchMap((_) => of(true))
      );
    }

    return of(true);
  }

  public canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ):
    | Observable<boolean | UrlTree>
    | Promise<boolean | UrlTree>
    | boolean
    | UrlTree {
    return this.activate();
  }

  public canActivateChild(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ):
    | Observable<boolean | UrlTree>
    | Promise<boolean | UrlTree>
    | boolean
    | UrlTree {
    return this.activate();
  }
}
