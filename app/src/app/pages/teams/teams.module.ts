import {NgModule} from '@angular/core';
import {TeamsComponent} from "./containers/teams.component";
import {ReactiveFormsModule} from "@angular/forms";
import { CoreModule } from "../../core/core.module";
import {SharedModule} from "../../shared/shared.module";
import {TeamsRoutingModule} from "./teams-routing.module";

@NgModule({
  declarations: [
    TeamsComponent
  ],
  exports: [
    TeamsComponent
  ],
  imports: [
    TeamsRoutingModule,
    ReactiveFormsModule,
    CoreModule,
    SharedModule
  ]
})
export class TeamsModule {
}
