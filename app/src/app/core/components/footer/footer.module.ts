import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FooterComponent} from "./containers/footer.component";
import {ChatModule} from "../chat/chat.module";
import {SharedModule} from "../../../shared/shared.module";

@NgModule({
  declarations: [
    FooterComponent
  ],
    imports: [
        CommonModule,
        ChatModule,
        SharedModule
    ],
  exports: [
    FooterComponent
  ]
})
export class FooterModule {
}
