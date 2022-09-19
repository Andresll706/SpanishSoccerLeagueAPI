import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'team',
  templateUrl: './team.component.html',
  styleUrls: ['./team.component.scss']
})

export class TeamComponent implements OnInit {
  loading = true;
  team: any;
  teamId: number | undefined;
  image: any = '';
  constructor(
    protected activatedRoute: ActivatedRoute,
    private router: Router
  ) {
    this.team={};
  }

  ngOnInit(): void {
    this.activatedRoute.queryParams.subscribe(parameters => {
      this.teamId = parameters['id'] as number;
      // if (this.teamId) {
      //   this.teamApiService.get(this.teamId).subscribe((resp) => {
      //       if (resp) {
      //         this.team = resp;
      //         this.image = url + this.team.image;
      //       }
      //       this.loading = false;
      //     }
      //   );
      // }
    });

  }
}
