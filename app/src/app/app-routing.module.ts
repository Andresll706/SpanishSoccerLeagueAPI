import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {HomeModule} from "./pages/home/home.module";
import {TeamsModule} from "./pages/teams/teams.module";
import {PlayersModule} from "./pages/players/players.module";
import {TeamModule} from "./pages/team/team.module";

const routes: Routes = [
  {
    path: '',
    children: [
      { path: '', redirectTo: 'home', pathMatch: 'full' },
      {
        path: 'home',
        loadChildren: () => HomeModule
      },
      {
        path: 'teams',
        loadChildren: () => TeamsModule
      },
      {
        path: 'players',
        loadChildren: () => PlayersModule
      },
      {
        path: 'team/:id',
        loadChildren: () => TeamModule
      },
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { relativeLinkResolution: 'legacy' })],
  exports: [RouterModule]
})

export class AppRoutingModule {
}
