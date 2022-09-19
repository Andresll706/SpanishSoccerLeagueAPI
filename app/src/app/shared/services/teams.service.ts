import { Injectable, OnInit } from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {catchError, throwError} from "rxjs";
import {TeamInputDto} from "./teamInputDto";
import {TeamOutputDto} from "./teamOutputDto";


@Injectable({
  providedIn: 'root'
})

export class TeamsService implements OnInit {

  public teams:any;

  private readonly URL = 'http://localhost:8000';
  private headers = new HttpHeaders();
  private params = new HttpParams();

  constructor(private http: HttpClient) {
    // This is intentional
  }

  ngOnInit() {
    this.getTeams().subscribe(value => { this.teams = value; });
  }

  public getTeams() {
    this.headers = new HttpHeaders({'Accept': 'application/json'});
    return this.http.get<any>(this.URL+'/teams' , { headers: this.headers } )
    .pipe(
      catchError((err) => {
          console.log('Error get teams');
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public getTeam(id: number) {
    this.headers = new HttpHeaders({'Accept': 'application/json'});
    return this.http.get<TeamInputDto>(this.URL+'/team/'+ id )
    .pipe(
      catchError((err) => {
          console.log('Error get Team id = ' + id);
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public deleteTeam(id: number) {
    return this.http.delete(this.URL+'/team/'+ id )
    .pipe(
      catchError((err) => {
          console.log('Error delete Team id = ' + id);
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public postTeam(team: TeamOutputDto){
    this.headers = new HttpHeaders({'content-type': 'application/json'});
    console.log(team);
    return this.http.post(this.URL+'/team', JSON.stringify(team), {headers: this.headers})
    .pipe(
      catchError((err) => {
          console.log('Error post team');
          console.error(err);
          return throwError(err);
        }
      )
    );
  }

  public patchTeam(id: number,team: TeamOutputDto){
    this.headers = new HttpHeaders({'content-type': 'application/json'});
    console.log(team);
    return this.http.patch(this.URL+'/team/'+id, JSON.stringify(team), {headers: this.headers})
    .pipe(
      catchError((err) => {
          console.log('Error post team');
          console.error(err);
          return throwError(err);
        }
      )
    );
  }
}
