import { Component, OnInit } from '@angular/core';
import {TranslateService} from "@ngx-translate/core";
import {FormBuilder} from "@angular/forms";

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {
  form: any;

  constructor(private translateService: TranslateService,
              private formBuilder: FormBuilder) {

  }

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      language: ['']
    });
    this.form.get('language').valueChanges.subscribe(()=>{
      console.log('algo');
      this.translateService.use(this.form.get('language').value);
      this.translateService.setDefaultLang(this.form.get('language').value);
    });

    // (document.getElementById('credits') as HTMLDivElement).w

    (document.getElementById('credits') as HTMLDivElement).style.marginLeft = (46.5 + "%");
    (document.getElementById('copyRight') as HTMLDivElement).style.marginLeft = (45 + "%");


  }

}
