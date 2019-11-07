import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { State } from 'src/app/store/reducers';
import { Store } from '@ngrx/store';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss']
})
export class LayoutComponent implements OnInit, OnDestroy {
  private subscription: Subscription;

  public constructor(
    private readonly store: Store<State>,
    private readonly router: Router
  ) {}

  public ngOnInit(): void {
    this.subscription = this.store
      .select((state) => state.auth.user)
      .subscribe((user) => {
        if (user !== null) {
          this.router.navigateByUrl('/dashboard');
        }
      });
  }

  public ngOnDestroy(): void {
    if (this.subscription) {
      this.subscription.unsubscribe();
    }
  }
}
