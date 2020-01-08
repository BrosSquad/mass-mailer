import { Component, OnInit } from '@angular/core';
import { FormTitleService } from '../../services/form-title.service';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  public loginForm: FormGroup;

  constructor(
    private readonly formTitleService: FormTitleService,
    private readonly formBuilder: FormBuilder) {
    this.loginForm = this.formBuilder.group({
      email: this.formBuilder.control('',
        [Validators.required, Validators.email, Validators.maxLength(255)]),
      password: this.formBuilder.control('', [
        Validators.required,
      ]),
    });
  }

  public ngOnInit(): void {
    this.formTitleService.next('Login');
  }

  public get email(): FormControl {
    return this.loginForm.get('email') as FormControl;
  }

  public get password(): FormControl {
    return this.loginForm.get('password') as FormControl;
  }

  public submit(): void {
    console.log('Email', this.email.value);
    console.log('Password', this.password.value);
  }
}
