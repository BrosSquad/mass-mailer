import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { RouterModule, Routes } from '@angular/router';
import { SharedModule } from '../shared/shared.module';
import { LayoutComponent } from './components/layout/layout.component';
import { LoginComponent } from './components/login/login.component';
import { ChangePasswordComponent } from './components/change-password/change-password.component';
import { RequestPasswordComponent } from './components/request-password/request-password.component';
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';
import { NavComponent } from './components/nav/nav.component';
import { SocialAuthComponent } from './components/social-auth/social-auth.component';
import { LoginFormComponent } from './components/login-form/login-form.component';
import { NgBootstrapFormValidationModule } from 'ng-bootstrap-form-validation';
const routes: Routes = [
  {
    path: '',
    component: LayoutComponent,
    children: [
      { path: 'login', component: LoginComponent },
      { path: 'request-password', component: RequestPasswordComponent },
      { path: 'change-password', component: ChangePasswordComponent },
    ],
  },
];

@NgModule({
  declarations: [
    LayoutComponent,
    LoginComponent,
    ChangePasswordComponent,
    RequestPasswordComponent,
    HeaderComponent,
    FooterComponent,
    NavComponent,
    SocialAuthComponent,
    LoginFormComponent,
  ],
  imports: [
    CommonModule,
    SharedModule,
    ReactiveFormsModule,
    NgBootstrapFormValidationModule,
    RouterModule.forChild(routes),
  ],
})
export class AuthModule {}
