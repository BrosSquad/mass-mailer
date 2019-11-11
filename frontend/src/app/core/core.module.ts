import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserAvatarComponent } from './components/user-avatar/user-avatar.component';



@NgModule({
  declarations: [UserAvatarComponent],
  imports: [
    CommonModule
  ],
  exports: [UserAvatarComponent]
})
export class CoreModule { }
