import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'loading',
  templateUrl: './loading.component.html',
  styleUrls: ['./loading.component.scss']
})
export class LoadingComponent implements OnInit {

  @Input()
  public  loading:boolean = false;

  constructor() {
    //This is intentional
  }

  ngOnInit(): void {
    //This is intentional
  }

}
