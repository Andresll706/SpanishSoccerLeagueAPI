import { ComponentRef, Injectable } from '@angular/core';
import { Overlay, OverlayRef } from '@angular/cdk/overlay';
import { ComponentPortal } from '@angular/cdk/portal';
import { SnackbarComponent } from './containers/snackbar.component';
import { SnackbarConfig } from './containers/snackbar.component';
import { timer } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SnackbarService {
  durationInSeconds = 10;

  private overlayRef: OverlayRef;
  private snackBarRef: ComponentRef<SnackbarComponent>;

  constructor(private overlay: Overlay) {
    this.overlayRef = this.overlay.create({
      positionStrategy: this.overlay.position()
        .global()
        .centerHorizontally()
        .bottom(),
      hasBackdrop: false
    });
    this.snackBarRef = this.overlayRef.attach(new ComponentPortal(SnackbarComponent));
  }

  publish(notification: SnackbarConfig) {
    this.snackBarRef.instance.addMessage(notification);
    timer(this.durationInSeconds * 1000).subscribe(() => {
      this.snackBarRef.instance.closeMessage(notification);
    });
  }
}
