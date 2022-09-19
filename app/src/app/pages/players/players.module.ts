import {NgModule} from '@angular/core';
import {PlayersComponent} from "./containers/players.component";
import {ReactiveFormsModule} from "@angular/forms";
import { CoreModule } from "../../core/core.module";
import {SharedModule} from "../../shared/shared.module";
import {PlayersRoutingModule} from "./players-routing.module";

@NgModule({
  declarations: [
    PlayersComponent
  ],
  exports: [
    PlayersComponent
  ],
  imports: [
    PlayersRoutingModule,
    ReactiveFormsModule,
    CoreModule,
    SharedModule
  ]
})
export class PlayersModule {
}
