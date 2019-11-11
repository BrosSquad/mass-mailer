import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {NgxPermissionsModule} from 'ngx-permissions';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { StoreDevtoolsModule } from '@ngrx/store-devtools';
import { environment } from '../environments/environment';
import { EffectsModule } from '@ngrx/effects';
import { StoreModule } from '@ngrx/store';
import { reducers, metaReducers, initialState } from './store/reducers';
import { NgBootstrapFormValidationModule } from 'ng-bootstrap-form-validation';
import { SharedModule } from './shared/shared.module';
import { LoginEffect } from './store/effects/auth/login.effect';
import { BootstrapModule } from './bootstrap.module';
import { MaterialModule } from './material.module';
import { ChangeImageEffect } from './store/effects/auth/change-image.effect';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    SharedModule,
    BrowserAnimationsModule,
    NgxPermissionsModule.forRoot(),
    StoreDevtoolsModule.instrument({ maxAge: 25, logOnly: !environment.production }),
    StoreModule.forRoot(reducers, {
      metaReducers,
      runtimeChecks: {
        strictStateImmutability: true,
        strictActionImmutability: true,
      },
      initialState
    }),
    EffectsModule.forRoot([LoginEffect, ChangeImageEffect]),
    BootstrapModule,
    MaterialModule,
    NgBootstrapFormValidationModule.forRoot(),
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
