import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { WithoutPhotoPipe } from './pipes/withoutPhoto.pipe';
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
    WithoutPhotoPipe,
    TranslateModule
  ],
  declarations: [WithoutPhotoPipe]
})
export class SharedModule {
}
