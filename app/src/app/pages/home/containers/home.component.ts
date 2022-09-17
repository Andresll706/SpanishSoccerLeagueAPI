import { Component, OnInit } from '@angular/core';
import {FormBuilder, Validators} from "@angular/forms";
import {Router} from "@angular/router";

@Component({
  selector: 'home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  form: any;

  linksMenus: any[] = [
    {
      name: 'home.linksMenus.activities',
      description: 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
      linkPage: 'activities',
      image: 'assets/images/jet-ski.jpg'
    },
    {
      name: 'home.linksMenus.services',
      description: 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
      linkPage: 'services',
      image: 'assets/images/services.jpg'
    },
    {
      name: 'home.linksMenus.boatRental',
      description: 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
      linkPage: 'boats',
      image: 'assets/images/catamaran.jpg'
    }
  ];

  comments: any[] = [
    {
      user: 'home.comments.user1',
      date: '02/04/21',
      stars: 5,
      comment: 'home.comments.comment1',
      image: 'assets/images/1.png'
    },
    {
      user: 'home.comments.user2',
      date: '05/05/21',
      stars: 5,
      comment: 'home.comments.comment2',
      image: 'assets/images/2.png'
    },
    {
      user: 'home.comments.user3',
      date: '25/06/21',
      stars: 5,
      comment: 'home.comments.comment3',
      image: 'assets/images/3.png'
    },
    {
      user: 'home.comments.user4',
      date: '15/07/21',
      stars: 5,
      comment: 'home.comments.comment4',
      image: 'assets/images/4.png'
    }
  ];


  activities: string | undefined = '';

  constructor(private formBuilder: FormBuilder,
              private router: Router) {
   // This is intentional
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
  }

  find() {
    let initialDate = '';
    if (this.form.get('initialDate').value) {
      console.log(this.form.get('initialDate').value);
      initialDate = (this.form.get('initialDate').value as unknown as Date).toISOString();
    }
    let endDate = '';
    if (this.form.get('endDate').value) {
      console.log(this.form.get('endDate').value);
      endDate = (this.form.get('endDate').value as unknown as Date).toISOString();
    }

    this.router.navigate(['/boats'], { queryParams: { initialDate , endDate } });
  }

  rent() {
    this.router.navigate(['/rent-boat']);
  }
  boats(){
    this.router.navigate(['/boats']);
  }




}
