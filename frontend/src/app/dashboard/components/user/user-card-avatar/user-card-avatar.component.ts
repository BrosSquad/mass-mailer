import { Component, OnInit, Input, ViewChild, ElementRef } from '@angular/core';
import { User } from 'src/app/shared/models';
import { Store } from '@ngrx/store';
import { State } from 'src/app/store/reducers';
import { ChangeImageAction } from 'src/app/store/actions/auth';

@Component({
  selector: 'app-user-card-avatar',
  templateUrl: './user-card-avatar.component.html',
  styleUrls: ['./user-card-avatar.component.scss']
})
export class UserCardAvatarComponent implements OnInit {
  @Input()
  public user: User;

  @ViewChild('avatarFileUplaod', { static: true })
  private fileInput: ElementRef;

  constructor(private readonly store: Store<State>) {}

  ngOnInit() {}

  public changeAvatar(event) {
    const [file] = event.target.files;
    // console.log(file);
    this.store.dispatch(new ChangeImageAction({ type: 'avatar', file }));
  }

  public openFileDialog(event: Event) {
    event.preventDefault();
    this.fileInput.nativeElement.click();
  }
}
