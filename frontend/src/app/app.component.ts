import { Component, OnInit, OnDestroy } from '@angular/core';
import { State } from './store/reducers';
import { Store } from '@ngrx/store';
import { User } from './store/reducers/auth';
import { SaveUserAction } from './store/actions/auth';
import { Subscription } from 'rxjs';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  public constructor(private readonly store: Store<State>) {}

  public ngOnInit(): void {
    const userJson: string | null = localStorage.getItem('user');
    if (userJson !== null) {
      const user: User = JSON.parse(userJson);
      this.store.dispatch(new SaveUserAction(user));
    }
  }
}
