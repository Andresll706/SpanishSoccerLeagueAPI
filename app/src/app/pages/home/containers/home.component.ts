import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  form: any;

  linksMenus: any[] = [
    {
      name: 'home.linksMenus.teams',
      description: 'home.linksMenus.descriptionTeams',
      linkPage: 'teams',
      image: 'assets/images/teams.jpeg'
    },
    {
      name: 'home.linksMenus.players',
      description: 'home.linksMenus.descriptionPlayers',
      linkPage: 'players',
      image: 'assets/images/players.jpg'
    }
  ];


  constructor() {
   // This is intentional
    window.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  ngOnInit(): void {
  }




}
