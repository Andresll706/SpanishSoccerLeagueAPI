import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MaterialModule } from './material/material.module';
import { ComponentsModule } from './components/components.module';

@NgModule({
  imports: [
    CommonModule,
    ComponentsModule,
    MaterialModule
  ],
  exports: [
    CommonModule,
    ComponentsModule,
    MaterialModule
  ]
})
export class CoreModule {
}
