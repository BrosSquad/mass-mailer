import { Component, OnInit } from '@angular/core';
import { UserProfileComponent } from '../user-profile/user-profile.component';

@Component({
  selector: 'app-dash-layout',
  templateUrl: './dash-layout.component.html',
  styleUrls: ['./dash-layout.component.scss']
})
export class DashLayoutComponent implements OnInit {

  public isUserProfile: boolean = false;
  constructor() { }

  ngOnInit() {
  }

  public onActivate(event) {
    if(event instanceof UserProfileComponent) {
      this.isUserProfile = true;
    } else {
      this.isUserProfile = false;
    }
  }

}
