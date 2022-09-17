import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {BoatPageComponent} from "./containers/boat-page.component";
import {BoatPageRoutingModule} from "./boat-page-routing.module";
import {ReactiveFormsModule} from "@angular/forms";
import { CoreModule } from "../../core/core.module";
import {SharedModule} from "../../shared/shared.module";

@NgModule({
  declarations: [
    BoatPageComponent
  ],
    imports: [
        CommonModule,
        BoatPageRoutingModule,
        ReactiveFormsModule,
        CoreModule,
        SharedModule
    ]
})
export class BoatPageModule {
}
