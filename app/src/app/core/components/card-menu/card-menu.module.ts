import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import { SharedModule } from "../../../shared/shared.module";
import {CardMenuComponent} from "./containers/card-menu.component";
import {RouterModule} from "@angular/router";

@NgModule({
  declarations: [
    CardMenuComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    RouterModule
  ],
  exports: [
    CardMenuComponent
  ]
})
export class CardMenuModule {
}
