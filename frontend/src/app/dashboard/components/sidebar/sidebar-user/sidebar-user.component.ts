import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-sidebar-user',
  templateUrl: './sidebar-user.component.html',
  styleUrls: ['./sidebar-user.component.scss']
})
export class SidebarUserComponent implements OnInit {

  @Input()
  public classes: string[];

  constructor() { }

  ngOnInit() {
    if(!this.classes) {
      this.classes = ['nav', 'align-items-center'];
    } else {
      this.classes = [...this.classes, 'nav', 'align-items-center'];
    }
  }

}
