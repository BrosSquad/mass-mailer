import { Component, OnInit, OnDestroy } from '@angular/core';
import {
  FormBuilder,
  FormGroup,
  FormControl,
  Validators,
} from '@angular/forms';
import { Login, LoginAction } from '../../../store/actions/auth';
import { Store } from '@ngrx/store';
import { State } from 'src/app/store/reducers';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  styleUrls: ['./login-form.component.scss'],
})
export class LoginFormComponent implements OnInit, OnDestroy {
  public loginForm: FormGroup;
  public error: string | null;
  public validationErrors: any[] = null;

  private subscriptions: Array<Subscription> = [];

  constructor(
    private readonly formBuilder: FormBuilder,
    private readonly store: Store<State>,
    private readonly router: Router,
  ) {
    this.loginForm = this.formBuilder.group({
      email: this.formBuilder.control('', [
        Validators.required,
        Validators.email,
        Validators.maxLength(255),
      ]),
      password: this.formBuilder.control('', [Validators.required]),
    });
  }

  public ngOnInit() {
    this.subscriptions.push(
      this.store
        .select((state) => state.auth.error.login)
        .subscribe((state) => {
          if (state !== null) {
            this.error = state.message;
          }
        }),
    );

    this.subscriptions.push(
      this.store
        .select((state) => state.auth.user)
        .subscribe((user) => {
          if (user !== null) {
            this.router.navigateByUrl('/');
          }
        }),
    );
  }

  public login() {
    const login: Login = {
      email: this.email.value,
      password: this.password.value,
    };

    this.store.dispatch(new LoginAction(login));
  }

  public get email(): FormControl {
    return this.loginForm.get('email') as FormControl;
  }

  public get password(): FormControl {
    return this.loginForm.get('password') as FormControl;
  }

  public ngOnDestroy(): void {
    this.subscriptions.forEach((sub) => sub.unsubscribe());
  }
}
