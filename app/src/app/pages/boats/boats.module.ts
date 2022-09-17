import {NgModule} from '@angular/core';
import {BoatsComponent} from "./containers/boats.component";
import {ReactiveFormsModule} from "@angular/forms";
import { CoreModule } from "../../core/core.module";
import {SharedModule} from "../../shared/shared.module";
import {BoatsRoutingModule} from "./boats-routing.module";

@NgModule({
  declarations: [
    BoatsComponent
  ],
  exports: [
    BoatsComponent
  ],
  imports: [
    BoatsRoutingModule,
    ReactiveFormsModule,
    CoreModule,
    SharedModule
  ]
})
export class BoatsModule {
}
