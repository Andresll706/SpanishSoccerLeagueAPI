import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatInputModule} from '@angular/material/input';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {MatButtonModule} from '@angular/material/button';
import {MatCardModule} from '@angular/material/card';
import {MatIconModule} from '@angular/material/icon';
import {MatDividerModule} from '@angular/material/divider';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatSidenavModule} from '@angular/material/sidenav';
import {MatListModule} from '@angular/material/list';
import {MatTableModule} from '@angular/material/table';
import {MatProgressBarModule} from '@angular/material/progress-bar';
import {MatSelectModule} from '@angular/material/select';
import {MatNativeDateModule, MatOptionModule} from '@angular/material/core';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {MatDialogModule} from '@angular/material/dialog';
import {MatExpansionModule} from '@angular/material/expansion';
import {MatBadgeModule} from '@angular/material/badge';
import {MatMenuModule} from '@angular/material/menu';
import {MatGridListModule} from '@angular/material/grid-list';
import {MatButtonToggleModule} from '@angular/material/button-toggle';
import {MatProgressSpinnerModule} from '@angular/material/progress-spinner';
@NgModule({
    imports: [
        CommonModule,
        MatButtonModule,
        MatFormFieldModule,
        MatInputModule,
        MatCardModule,
        MatIconModule,
        MatDividerModule,
        MatButtonModule,
        MatSnackBarModule,
        MatSidenavModule,
        MatListModule,
        MatProgressBarModule,
        FormsModule,
        MatTableModule,
        ReactiveFormsModule,
        MatCheckboxModule,
        MatDatepickerModule,
        MatNativeDateModule,
        MatSelectModule,
        MatOptionModule,
        MatDialogModule,
        MatExpansionModule,
        MatBadgeModule,
        MatSidenavModule,
        MatMenuModule,
        MatGridListModule,
        MatButtonToggleModule,
        MatProgressSpinnerModule
    ],
    exports: [
        MatButtonModule,
        MatFormFieldModule,
        MatButtonModule,
        MatInputModule,
        MatCardModule,
        MatIconModule,
        MatDividerModule,
        MatSnackBarModule,
        MatSidenavModule,
        MatListModule,
        MatProgressBarModule,
        FormsModule,
        MatTableModule,
        MatCheckboxModule,
        MatDatepickerModule,
        MatSelectModule,
        MatOptionModule,
        MatDialogModule,
        ReactiveFormsModule,
        MatExpansionModule,
        MatBadgeModule,
        MatSidenavModule,
        MatMenuModule,
        MatGridListModule,
        MatButtonToggleModule,
        MatProgressSpinnerModule
    ],
    providers: [
        MatDatepickerModule
    ]
})
export class MaterialModule {
}
