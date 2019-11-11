import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-user-avatar',
  templateUrl: './user-avatar.component.html',
  styleUrls: ['./user-avatar.component.scss']
})
export class UserAvatarComponent implements OnInit {
  
  @Input()
  public avatar: string | null | undefined;

  @Input()
  public alt: string | null | undefined;
   
  constructor() { }

  ngOnInit() {
  }

}
