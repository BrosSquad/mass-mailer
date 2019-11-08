import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { AuthInterceptorService } from './interceptors/auth-interceptor.service';
import { ResponseInterceptorService } from './interceptors/response-interceptor.service';
import { HeaderInterceptorService } from './interceptors/header-interceptor.service';
import { NgxPermissionsModule } from 'ngx-permissions';

@NgModule({
  declarations: [],
  imports: [CommonModule, HttpClientModule, NgxPermissionsModule.forChild()],
  exports: [HttpClientModule],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      multi: true,
      useClass: HeaderInterceptorService
    },
    {
      provide: HTTP_INTERCEPTORS,
      multi: true,
      useClass: AuthInterceptorService
    },
    {
      provide: HTTP_INTERCEPTORS,
      multi: true,
      useClass: ResponseInterceptorService
    }
  ]
})
export class SharedModule {}
