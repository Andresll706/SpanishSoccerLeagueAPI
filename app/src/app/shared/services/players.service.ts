import { Injectable, OnInit } from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {catchError, throwError} from "rxjs";
import {PlayersInputDto} from "./playersInputDto";
import {PlayerOutputDto} from "./playerOutputDto";


@Injectable({
  providedIn: 'root'
})

export class PlayersService implements OnInit {

  public players:any;

  private readonly URL = 'http://localhost:8000';
  private headers = new HttpHeaders();
  private params = new HttpParams();

  constructor(private http: HttpClient) {
    // This is intentional
  }

  ngOnInit() {
    this.getPlayers().subscribe(value => { this.players = value; });
  }

  public getPlayers() {
    this.headers = new HttpHeaders({'Accept': 'application/json'});
    return this.http.get<PlayersInputDto[]>(this.URL+'/players' , { headers: this.headers } )
    .pipe(
      catchError((err) => {
          console.log('Error get players');
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public getPlayer(id: number) {
    this.headers = new HttpHeaders({'Accept': 'application/json'});
    return this.http.get<PlayersInputDto>(this.URL+'/player/'+ id )
    .pipe(
      catchError((err) => {
          console.log('Error get Player id = ' + id);
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public deletePlayer(id: number) {
    return this.http.delete(this.URL+'/player/'+ id )
    .pipe(
      catchError((err) => {
          console.log('Error delete player id = ' + id);
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public postPlayer(player: PlayerOutputDto){
    this.headers = new HttpHeaders({'content-type': 'application/json'});
    console.log(player);
    return this.http.post(this.URL+'/player', JSON.stringify(player), {headers: this.headers})
    .pipe(
      catchError((err) => {
          console.log('Error post player');
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public patchPlayer(id: number, player: PlayerOutputDto){
    this.headers = new HttpHeaders({'content-type': 'application/json'});
    console.log(player);
    return this.http.patch(this.URL+'/player/'+id, JSON.stringify(player), {headers: this.headers})
    .pipe(
      catchError((err) => {
          console.log('Error post player');
          console.error(err);
          return throwError(err);
        }
      )
    );
  }
}
