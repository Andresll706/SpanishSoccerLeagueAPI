import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'sinfoto'
})
export class SinfotoPipe implements PipeTransform {
  //TODO: terminar de implementar
  transform(image : any): any {
    let noimage = 'assets/img/noimage.png';
    if(!image){
      return noimage;
    }else{
      return 'https://localhost:44316/Images/'+ image;
    }
  }

}
