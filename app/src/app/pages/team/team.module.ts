import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {TeamComponent} from "./containers/team.component";
import {TeamRoutingModule} from "./team-routing.module";
import {ReactiveFormsModule} from "@angular/forms";
import { CoreModule } from "../../core/core.module";
import {SharedModule} from "../../shared/shared.module";

@NgModule({
  declarations: [
    TeamComponent
  ],
    imports: [
        CommonModule,
        TeamRoutingModule,
        ReactiveFormsModule,
        CoreModule,
        SharedModule
    ]
})
export class TeamModule {
}
