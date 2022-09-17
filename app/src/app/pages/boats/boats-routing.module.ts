import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {BoatsComponent} from "./containers/boats.component";

const routes: Routes = [
  {
    path: '',
    component: BoatsComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class BoatsRoutingModule {
}

