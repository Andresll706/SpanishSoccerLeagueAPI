import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'withoutPhoto'
})

export class WithoutPhotoPipe implements PipeTransform {
  transform(image : any): any {
    let noimage = 'assets/img/noimage.png';
    if(!image){
      return noimage;
    }else{
      return 'https://localhost:8000/public/'+ image;
    }
  }
}
