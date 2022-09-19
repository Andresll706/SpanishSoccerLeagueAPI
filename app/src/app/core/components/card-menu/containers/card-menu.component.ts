import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'card-menu',
  templateUrl: './card-menu.component.html',
  styleUrls: ['./card-menu.component.scss']
})
export class CardMenuComponent implements OnInit {
  @Input() image: string = '';
  @Input() linkMenu: any;
  @Input() link: string | undefined;

  constructor() {
  }

  ngOnInit(): void {
  }

}
