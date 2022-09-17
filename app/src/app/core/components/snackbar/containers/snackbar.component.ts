import { Component } from '@angular/core';

@Component({
  selector: 'snackbar',
  templateUrl:  './snackbar.component.html',
  styleUrls: ['./snackbar.component.scss']
})

export class SnackbarComponent {
  notifications: InnerSnackbarConfig[] = [];

  static compareNotifications(notification1: SnackbarConfig, notification2: SnackbarConfig): boolean {
    return notification1.message === notification2.message && notification1.style === notification2.style;
  }

  addMessage(notification: SnackbarConfig) {
    const indexFound = this.notifications.findIndex(element => SnackbarComponent.compareNotifications(element, notification));
    if (indexFound !== -1 ) {
      this.notifications = this.notifications.map(element => {
        if (SnackbarComponent.compareNotifications(element, notification)) {
          return { ...element, count: element.count + 1, show: true };
        } else {
          return element;
        }
      });
    } else {
      this.notifications.push({ ...notification, count: 0, show: true });
    }
  }

  closeMessage(notification: SnackbarConfig) {
    const indexFound = this.notifications.findIndex(element => SnackbarComponent.compareNotifications(element, notification));
    if (indexFound !== -1 ) {
      if (this.notifications[indexFound].count) {
        this.notifications = this.notifications.map(element => {
          if (SnackbarComponent.compareNotifications(element, notification)) {
            return { ...element, count: element.count - 1 };
          } else {
            return element;
          }
        });
      } else {
        this.notifications = this.notifications.filter(element => !SnackbarComponent.compareNotifications(element, notification));
      }
    }
  }

  hide(notification: SnackbarConfig) {
    this.notifications = this.notifications.map(element => {
      if (SnackbarComponent.compareNotifications(element, notification)) {
        return { ...element, show: false };
      } else {
        return element;
      }
    });
  }
}

export interface SnackbarConfig {
  message: string;
  params?: any;
  style: 'error' | 'success' | 'warning' | 'info';
}

export interface InnerSnackbarConfig extends SnackbarConfig {
  count: number;
  show: boolean;
}
