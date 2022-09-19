import {WithoutPhotoPipe} from "./withoutPhoto.pipe";

describe('SinFotoPipe', () => {
  it('create an instance', () => {
    const pipe = new WithoutPhotoPipe();
    expect(pipe).toBeTruthy();
  });
});
