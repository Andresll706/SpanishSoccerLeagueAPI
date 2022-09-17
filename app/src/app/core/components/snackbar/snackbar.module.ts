import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from '../../../shared/shared.module';
import { SnackbarComponent } from './containers/snackbar.component';
import {FlexLayoutModule} from "@angular/flex-layout";

@NgModule({
  declarations: [
    SnackbarComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    FlexLayoutModule
  ],
  exports: [
    SnackbarComponent
  ]
})
export class SnackbarModule {
}
