import { Component, OnInit } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';
import {PlayersService} from "../../../shared/services/players.service";
import {PlayersInputDto} from "../../../shared/services/playersInputDto";

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
              protected router: Router,
              private playersService: PlayersService) {
    window.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  ngOnInit(): void {

    this.playersService.getPlayers().subscribe((resp) => {
      if (resp) {
        this.players = resp;
      }
      this.loading = false;
    });
  }
}
