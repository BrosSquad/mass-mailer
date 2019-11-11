import { Component, OnInit, Input } from '@angular/core';
import { User } from 'src/app/shared/models';

@Component({
  selector: 'app-update-profile-form',
  templateUrl: './update-profile-form.component.html',
  styleUrls: ['./update-profile-form.component.scss']
})
export class UpdateProfileFormComponent implements OnInit {

  @Input()
  public user: User;

  public constructor() { }

  public ngOnInit(): void {
  }

}
