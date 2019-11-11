import { Component, OnInit, Input } from '@angular/core';
import { User } from 'src/app/shared/models';

@Component({
  selector: 'app-profile-card',
  templateUrl: './profile-card.component.html',
  styleUrls: ['./profile-card.component.scss']
})
export class ProfileCardComponent implements OnInit {

  @Input()
  public user: User;
  
  constructor() { }

  ngOnInit() {
  }

}
