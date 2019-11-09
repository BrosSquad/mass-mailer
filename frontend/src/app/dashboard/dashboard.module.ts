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
import { ApplicationsComponent } from './components/main/applications/applications.component';
import { NavigationComponent } from './components/sidebar/navigation/navigation.component';
import { HeaderComponent } from './components/main/header/header.component';
import { BsDropdownModule } from 'ngx-bootstrap/dropdown';

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
        path: 'applications',
        component: ApplicationsComponent,
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
    ApplicationsComponent,
    UserProfileComponent,
    SidebarNavComponent,
    SidebarUserComponent,
    NavComponent,
    DashboardComponent,
    NavigationComponent,
    HeaderComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    BsDropdownModule
  ],
  exports: [RouterModule],
  providers: [NavTitleService]
})
export class DashboardModule { }
