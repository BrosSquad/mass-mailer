import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-change-password',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.scss'],
})
export class ChangePasswordComponent implements OnInit {

  public changePasswordForm: FormGroup;

  constructor(private readonly formBuilder: FormBuilder) {
    this.changePasswordForm = this.formBuilder.group({
      password: this.formBuilder.control('', [
        Validators.required,
        Validators.minLength(8),
        Validators.maxLength(64)]),
    });
  }

  public get password(): FormControl {
    return this.changePasswordForm.get('password') as FormControl;
  }

  ngOnInit() {
  }

  public submit(): void {
    console.log('Password', this.password.value);
  }

}
