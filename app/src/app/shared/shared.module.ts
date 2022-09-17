import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import {SinfotoPipe} from "./pipes/sinfoto.pipe";
import {TranslateModule} from "@ngx-translate/core";
import { MaterialModule } from "../core/material/material.module";

@NgModule({
  imports: [
    MaterialModule,
    RouterModule,
    TranslateModule
  ],
  providers: [
  ],
  exports: [
    MaterialModule,
    RouterModule,
    SinfotoPipe,
    TranslateModule
  ],
  declarations: [SinfotoPipe]
})
export class SharedModule {
}
