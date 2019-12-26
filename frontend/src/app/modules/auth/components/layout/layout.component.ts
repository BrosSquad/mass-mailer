import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormTitleService } from '../../services/form-title.service';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss']
})
export class LayoutComponent implements OnInit, OnDestroy {
  public title: string = '';

  constructor(private formTitleService: FormTitleService) { }

  public ngOnInit(): void {
    this.formTitleService.subscribe((title) => this.title = title);
  }

  public ngOnDestroy(): void {
    this.formTitleService.unsubscribe();
  }

}
