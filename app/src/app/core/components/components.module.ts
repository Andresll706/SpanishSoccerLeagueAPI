import { NgModule } from '@angular/core';
import { FooterModule } from "./footer/footer.module";
import { HeaderModule } from "./header/header.module";
import {LoadingModule} from "./loading/loading.module";
import {SnackbarModule} from "./snackbar/snackbar.module";
import {CardMenuModule} from "./card-menu/card-menu.module";

@NgModule({
  imports: [
    CardMenuModule,
    FooterModule,
    HeaderModule,
    LoadingModule,
    SnackbarModule
  ],
  exports: [
    CardMenuModule,
    FooterModule,
    HeaderModule,
    LoadingModule,
    SnackbarModule
  ]
})
export class ComponentsModule {
}
