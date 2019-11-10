import { Component, OnInit, OnDestroy } from '@angular/core';
import { Store } from '@ngrx/store';
import { State } from 'src/app/store/reducers';
import { Subscription } from 'rxjs';
import { User } from 'src/app/shared/models';

@Component({
  selector: 'app-user-profile',
  templateUrl: './user-profile.component.html',
  styleUrls: ['./user-profile.component.scss']
})
export class UserProfileComponent implements OnInit, OnDestroy {
  
  private subscription: Subscription;
  
  public user: User;
  
  public constructor(private readonly store: Store<State>) { }

  public ngOnInit(): void {
    this.subscription = this.store
      .select(state => state.auth.user)
      .subscribe(user => this.user = user);
  }

  ngOnDestroy(): void {
    if(this.subscription) {
      this.subscription.unsubscribe();
    }
  }
  
}
