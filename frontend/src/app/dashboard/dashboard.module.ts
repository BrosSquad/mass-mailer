import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { DashLayoutComponent } from './components/dash-layout/dash-layout.component';
import { UserProfileComponent } from './components/user-profile/user-profile.component';
import { SidebarNavComponent } from './components/sidebar/sidebar-nav/sidebar-nav.component';
import { SidebarUserComponent } from './components/sidebar/sidebar-user/sidebar-user.component';
import { NavComponent } from './components/main/nav/nav.component';
import { DashboardComponent } from './components/main/dashboard/dashboard.component';
import { NavTitleService } from './services/nav-title.service';

const routes: Routes = [
  {
    path: '',
    component: DashLayoutComponent,
    children: [
      {
        path: '',
        component: DashboardComponent,
        pathMatch: 'full'
      },
      {
        path: 'user-profile',
        component: UserProfileComponent
      }
    ]
  }
]

@NgModule({
  declarations: [
    DashLayoutComponent,
    UserProfileComponent,
    SidebarNavComponent,
    SidebarUserComponent,
    NavComponent,
    DashboardComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule],
  providers: [NavTitleService]
})
export class DashboardModule { }
