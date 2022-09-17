import { Component, OnInit } from '@angular/core';

import {AuthService} from "../../../../shared/services/auth/auth.service";
import {StorageService} from "../../../../shared/services/storage/storage.service";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

  perfil: string | null;
  login: string | null;
  private adminRole: string;
  public userLogged: any;

  constructor(
              protected authService:AuthService,
              protected storageService:StorageService) {
    if(!this.storageService.getItem("userId")){
      this.adminRole = 'admin';
      this.userLogged = null;
      this.perfil = "";
      this.login = "1";
    }else{
      this.login = "";
      this.perfil = "1";
      this.adminRole = 'admin';
    }

  }


  ngOnInit(): void {
    this.userLogged = this.authService.isUserLogged.subscribe((resp) => {
      if(resp){
        this.login = "";
        this.perfil = "Perfil";
      }
    });
  }
}

