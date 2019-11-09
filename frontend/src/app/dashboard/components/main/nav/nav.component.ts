import { Component, OnInit, OnDestroy } from '@angular/core';
import { NavTitleService, Title } from 'src/app/dashboard/services/nav-title.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent implements OnInit, OnDestroy {
  public title: Title;
  
  public constructor(private readonly navTitleService: NavTitleService) {
  }

  public ngOnInit() {
    this.navTitleService.subscribe((title) => this.title = title)
  }

  public ngOnDestroy(): void {
    this.navTitleService.unsubscribe();
  }

}
