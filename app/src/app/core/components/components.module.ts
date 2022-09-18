import { NgModule } from '@angular/core';
import { FooterModule } from "./footer/footer.module";
import { HeaderModule } from "./header/header.module";
import { CommentModule } from "../../comment/comment.module";
import { CardMenuModule } from "../../card-menu/card-menu.module";
import {LoadingModule} from "./loading/loading.module";
import {SnackbarModule} from "./snackbar/snackbar.module";

@NgModule({
  imports: [
    FooterModule,
    HeaderModule,
    CommentModule,
    CardMenuModule,
    LoadingModule,
    SnackbarModule
  ],
  exports: [
    FooterModule,
    HeaderModule,
    CommentModule,
    CardMenuModule,
    LoadingModule,
    SnackbarModule
  ]
})
export class ComponentsModule {
}
