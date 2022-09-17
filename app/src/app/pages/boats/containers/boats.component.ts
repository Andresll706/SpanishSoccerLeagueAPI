import { Component, OnInit } from '@angular/core';
import {BoatOutputDTO, BoatOutputDTOGenericResponseDTO, BoatsService, BoatTypeOutputDTO} from "../../../shared/sdk";
import { HttpClient } from "@angular/common/http";
import {ActivatedRoute, Router} from '@angular/router';
import {FormBuilder, Validators} from "@angular/forms";

@Component({
  selector: 'boats',
  templateUrl: './boats.component.html',
  styleUrls: ['./boats.component.scss']
})
export class BoatsComponent implements OnInit {
  loading = true;
  boats?: Array<BoatOutputDTO> | null;
  boatTypes: BoatTypeOutputDTO[] = [];
  images: any[] = [];
  form: any;
  initDate: string = '';
  finalDate: string = '';

  constructor(private formBuilder: FormBuilder,
              protected boatsApiService: BoatsService,
              protected http: HttpClient,
              protected router: Router,
              private activatedRoute: ActivatedRoute) {
    this.setBoatTypes();
    window.scroll({
      top: 0,
      left: 0,
      behavior: 'smooth'
    });
  }

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      initialDate: ['', Validators.required],
      endDate: ['', Validators.required]
    });

    this.activatedRoute.queryParams.subscribe(parameters => {
      let initialDate = undefined;
      if(parameters['initialDate'] && parameters['initialDate'] !== '')
      {
        initialDate = decodeURIComponent(parameters['initialDate']);
        console.log(initialDate);
        this.form.get('initialDate').setValue(initialDate);
      }
      let endDate = undefined;
      if(parameters['endDate'] && parameters['endDate'] !== '')
      {
        endDate = decodeURIComponent(parameters['endDate']);
        this.form.get('endDate').setValue(endDate);
      }
      if(initialDate && endDate) {
        this.boatsApiService.apiBoatsAvailableBoatsGet(initialDate, endDate).subscribe(resp => {
          const items = this.handlerBoats(resp).items;
          this.boats = items;
          if(items != null) {
            for (let item of items) {
              if(item && item.boatResources) {
                this.images.push(item?.boatResources?.find(x => x.main)?.uri ??
                item?.boatResources.length > 0 ? item?.boatResources[0].uri : '');
              }
            }
          }
          this.loading = false;
        },
          ()=>{
            this.loading = false;
          });
      }else {
        this.loading = false;
      }
    });
  }

  handlerBoats(resp: BoatOutputDTOGenericResponseDTO) {
    return resp;
  }

  searchAct() {
    this.loading = true;
    console.log('searchboat')
    if(this.form.valid) {
      console.log('isValid')
      console.log(this.form)
      let initialDate = undefined;
      if (this.form.get('initialDate').value) {
        console.log(this.form.get('initialDate').value)
        const date = this.form.get('initialDate').value as unknown as Date;
        initialDate = date.toISOString();
        this.initDate = date.toISOString();
      }
      let endDate = undefined;
      if (this.form.get('endDate').value) {
        const date = this.form.get('endDate').value as unknown as Date;
        endDate = date.toISOString();
        this.finalDate = endDate;
      }
      this.boatsApiService.apiBoatsAvailableBoatsGet(initialDate, endDate).subscribe(resp => {
        const items = this.handlerBoats(resp).items;
        this.boats = items;
        if(items != null) {
          console.log('BARCOS NO ES NULL');
          console.log(items);
          for (let item of items) {
            console.log(item);
            if(item && item.boatResources) {
              console.log(item.boatResources);
              this.images.push(item?.boatResources?.find(x => x.main)?.uri ??
              item?.boatResources.length > 0 ? item?.boatResources[0].uri : '');
              console.log(this.images);
            }
          }
        }
        this.loading = false;
      },
        ()=>{
          this.loading = false;
        });
    }
  }

  private setBoatTypes() {
    this.boatsApiService.apiBoatsTypesGet()
      .subscribe((resp: BoatTypeOutputDTO[]) => {
        this.boatTypes = resp;
      });
  }
}
