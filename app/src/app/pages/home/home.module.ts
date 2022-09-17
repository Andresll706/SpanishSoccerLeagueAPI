import {NgModule} from '@angular/core';
import {HomeRoutingModule} from './home-routing.module';
import {ReactiveFormsModule} from "@angular/forms";
import { CoreModule } from "../../core/core.module";
import {SharedModule} from "../../shared/shared.module";
import {HomeComponent} from "./containers/home.component";

@NgModule({
  declarations: [
    HomeComponent
  ],
  exports: [
    HomeComponent
  ],
  imports: [
    HomeRoutingModule,
    ReactiveFormsModule,
    CoreModule,
    SharedModule
  ]
})
export class HomeModule {
}
