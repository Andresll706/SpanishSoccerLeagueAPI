import { Component, OnInit } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';
import {TeamsService} from "../../../shared/services/teams.service";

@Component({
  selector: 'teams',
  templateUrl: './teams.component.html',
  styleUrls: ['./teams.component.scss']
})
export class TeamsComponent implements OnInit {
  loading = true;
  images: any[] = [];
  form: any;
  teams: any;

  constructor(protected http: HttpClient,
              protected router: Router,
              private teamsService: TeamsService) {
    window.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  ngOnInit(): void {
    this.teamsService.getTeams().subscribe((resp) => {
      if (resp) {
        this.teams = resp;
      }
      this.loading = false;
    });
  }
}
