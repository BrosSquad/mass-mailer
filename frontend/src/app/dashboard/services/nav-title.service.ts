import { Injectable } from '@angular/core';
import { BehaviorSubject, Subscription } from 'rxjs';

export interface Title {
  name: string;
  url: string;
}

@Injectable()
export class NavTitleService {
  private title: BehaviorSubject<Title> = new BehaviorSubject<Title>({name: 'dashboard', url: '/'}); 
  private subscription: Subscription | null;
  constructor() { }


  public changeTitle(title: Title) {
    this.title.next(title);
  }

  public unsubscribe() {
    if(this.subscription) {
      this.subscription.unsubscribe();
      this.subscription = null;
    }
  }

  public subscribe(next: (title: Title) => void) {
    this.unsubscribe();
    this.subscription = this.title.subscribe(next);
  }
}
