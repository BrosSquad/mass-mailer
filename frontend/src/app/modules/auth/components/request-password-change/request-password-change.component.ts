import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-request-password-change',
  templateUrl: './request-password-change.component.html',
  styleUrls: ['./request-password-change.component.scss'],
})
export class RequestPasswordChangeComponent implements OnInit {

  public requestResetPasswordForm: FormGroup;

  constructor(private formBuilder: FormBuilder) {
    this.requestResetPasswordForm = this.formBuilder.group({
      email: this.formBuilder.control('',
        [Validators.required, Validators.email, Validators.maxLength(255)]),
    });
  }

  public ngOnInit(): void {
  }

  public get email(): FormControl {
    return this.requestResetPasswordForm.get('email') as FormControl;
  }

  public submit() {

  }

}
