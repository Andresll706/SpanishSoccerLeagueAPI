import { Component, OnInit } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';

@Component({
  selector: 'players',
  templateUrl: './players.component.html',
  styleUrls: ['./players.component.scss']
})
export class PlayersComponent implements OnInit {
  loading = true;
  images: any[] = [];
  form: any;
  players: any;

  constructor(protected http: HttpClient,
              protected router: Router,) {
    window.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  ngOnInit(): void {

    // this.teamApiService.getAll().subscribe((resp) => {
      //       if (resp) {
      //         this.teams = resp;
      //       }
      //       this.loading = false;
      //     }
  }
}
