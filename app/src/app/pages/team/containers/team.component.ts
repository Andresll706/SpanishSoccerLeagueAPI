import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {TeamsService} from "../../../shared/services/teams.service";

@Component({
  selector: 'team',
  templateUrl: './team.component.html',
  styleUrls: ['./team.component.scss']
})

export class TeamComponent implements OnInit {
  loading = true;
  team: any;
  teamId: any;
  constructor(
    protected activatedRoute: ActivatedRoute,
    private teamsService: TeamsService
  ) {

  }

  ngOnInit(): void {
    this.activatedRoute.params.subscribe(parameters => {
      this.teamId = parameters['id'] as number;
      console.log(parameters)
      console.log(this.teamId);
      if (this.teamId) {
        console.log(this.teamId);
        this.teamsService.getTeam(this.teamId).subscribe((resp) => {
            console.log(resp);
            if (resp) {
              this.team = resp;
            }
            this.loading = false;
          }
        );
      }
    });

  }
}
