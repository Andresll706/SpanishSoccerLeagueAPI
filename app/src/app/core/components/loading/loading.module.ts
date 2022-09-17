import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import { RouterModule } from "@angular/router";
import {SharedModule} from "../../../shared/shared.module";
import {LoadingComponent} from "./containers/loading.component";

@NgModule({
  declarations: [
    LoadingComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    SharedModule
  ],
  exports: [
    LoadingComponent
  ]
})
export class LoadingModule {
}
