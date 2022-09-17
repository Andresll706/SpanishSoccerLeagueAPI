import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {BoatPageComponent} from "./containers/boat-page.component";

const routes: Routes = [
  {
    path: '',
    component: BoatPageComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class BoatPageRoutingModule {
}

