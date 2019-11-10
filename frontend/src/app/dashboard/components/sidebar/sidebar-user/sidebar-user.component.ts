import { Component, OnInit, Input, OnDestroy } from '@angular/core';
import { Store } from '@ngrx/store';
import { State } from 'src/app/store/reducers';
import { LogoutAction } from 'src/app/store/actions/auth';
import { Router } from '@angular/router';
import { BsDropdownConfig } from 'ngx-bootstrap/dropdown';
import { User } from 'src/app/store/reducers/auth';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-sidebar-user',
  templateUrl: './sidebar-user.component.html',
  styleUrls: ['./sidebar-user.component.scss'],
  providers: [{ provide: BsDropdownConfig, useValue: { isAnimated: true, autoClose: true } }]
})
export class SidebarUserComponent implements OnInit, OnDestroy {
  
  @Input()
  public classes: string[];

  public user: User;
  
  private subscription: Subscription;

  constructor(
    private readonly store: Store<State>,
    private readonly router: Router) { }

  public ngOnInit() {
    if(!this.classes) {
      this.classes = ['nav', 'align-items-center'];
    } else {
      this.classes = [...this.classes, 'nav', 'align-items-center'];
    }

    this.subscription = this.store.select(state => state.auth.user)
      .subscribe(user => this.user = user)
  }

  public logout(event: Event) {
    event.preventDefault();
    this.store.dispatch(new LogoutAction());
    this.router.navigateByUrl('/auth/login');
  }

  public ngOnDestroy(): void {
    if(this.subscription) {
      this.subscription.unsubscribe();
    }
  }

}
