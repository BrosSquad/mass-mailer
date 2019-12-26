import { Component, OnInit } from '@angular/core';
import { FormTitleService } from '../../services/form-title.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  constructor(private readonly formTitleService: FormTitleService) { }

  ngOnInit() {
    this.formTitleService.next('Login');
  }

}
