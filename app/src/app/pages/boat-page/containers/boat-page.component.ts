import { Component, OnInit } from '@angular/core';
import {BoatOutputDTO, BoatsService} from "../../../shared/sdk";
import {ActivatedRoute, Router} from "@angular/router";
import {StorageService} from "../../../shared/services/storage/storage.service";

@Component({
  selector: 'boat',
  templateUrl: './boat-page.component.html',
  styleUrls: ['./boat-page.component.scss']
})

export class BoatPageComponent implements OnInit {
  loading = true;
  boat: BoatOutputDTO;
  boatId: any;
  initialDate: any;
  endDate: any;
  image: any = '';
  constructor(
    protected boatsApiService: BoatsService,
    protected activatedRoute: ActivatedRoute,
    private storageService: StorageService,
    private router: Router
  ) {
    this.boat={};
  }

  ngOnInit(): void {
    this.activatedRoute.queryParams.subscribe(parameters => {
      this.boatId = parameters['id'] as string;
      this.initialDate = parameters['initialDate'];
      this.endDate = parameters['endDate'];
      if (this.boatId) {
        this.boatsApiService.apiBoatsIdGet(parseInt(this.boatId)).subscribe((resp) => {
            if (resp) {
              this.boat = resp;
              if (resp && resp.boatResources) {
                this.image = resp.boatResources.find(x => x.main)?.uri ??
                resp.boatResources.length > 0 ? resp.boatResources[0].uri : '';
              }
            }
            this.loading = false;
          }
        );
      }
    });

  }

  booking(){
    const id = this.boatId;
    if (id) {
      const bookingCart = this.storageService.getItem('bookingCart');
      let bookingCartJSON:any;
      if (bookingCart) {
        bookingCartJSON = JSON.parse(bookingCart);
        if (bookingCartJSON.boats) {
          if(!this.existBoat(bookingCartJSON, id)) {
            bookingCartJSON.boats.push({id, initialDate: this.initialDate, endDate: this.endDate});
          }
        } else {
          bookingCartJSON.boats = [{id, initialDate: this.initialDate, endDate: this.endDate}];
          console.log(bookingCartJSON);
        }
      } else {
        bookingCartJSON = {boats: [{id, initialDate: this.initialDate, endDate: this.endDate}]};
      }
      this.storageService.setItem('bookingCart', JSON.stringify(bookingCartJSON));
      console.log(bookingCartJSON);
      this.router.navigate(['/booking']);
    }
  }
  private existBoat(bookingCartJSON: any, id: number) {
    for (let boat of bookingCartJSON.boats) {
      if (parseInt(boat.id) === id) {
        return true;
      }
    }
    return false;
  }
}
