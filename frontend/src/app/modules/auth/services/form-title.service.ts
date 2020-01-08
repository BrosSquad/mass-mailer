import { Injectable } from '@angular/core';
import { BehaviorSubject, Subscription } from 'rxjs';

@Injectable()
export class FormTitleService {
  private title: BehaviorSubject<string> = new BehaviorSubject<string>('');
  private subscriptions: Subscription[] = [];

  public subscribe( cb: ( title: string ) => void ) {
    this.subscriptions.push(this.title.subscribe(cb));
  }


  public next( title: string ) {
    this.title.next(title);
  }

  public unsubscribe() {
    for ( let sub of this.subscriptions ) {
      sub.unsubscribe();
    }
  }

}
