import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {LayoutComponent} from './components/layout/layout.component';
import {RouterModule, Routes} from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { RequestPasswordChangeComponent } from './components/request-password-change/request-password-change.component';
import { ChangePasswordComponent } from './components/change-password/change-password.component';


const routes: Routes = [
  {
    component: LayoutComponent,
    path: '',
    children: [
      {
        path: 'login',
      },
      {
        path: 'change-password'
      }
    ]
  }
];

@NgModule({
  declarations: [LayoutComponent, LoginComponent, RequestPasswordChangeComponent, ChangePasswordComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ]
})
export class AuthModule {
}
