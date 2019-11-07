import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { DashLayoutComponent } from './components/dash-layout/dash-layout.component';

const routes:Routes = [
  {
    path: '',
    component: DashLayoutComponent,
    children: []
  }
]

@NgModule({
  declarations: [DashLayoutComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule]
})
export class DashboardModule { }
