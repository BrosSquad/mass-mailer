import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { DashLayoutComponent } from './components/dash-layout/dash-layout.component';
import { UserProfileComponent } from './components/user-profile/user-profile.component';

const routes:Routes = [
  {
    path: '',
    component: DashLayoutComponent,
    children: [
      {
        path: 'user-profile',
        component: UserProfileComponent
      }
    ]
  }
]

@NgModule({
  declarations: [DashLayoutComponent, UserProfileComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule]
})
export class DashboardModule { }
