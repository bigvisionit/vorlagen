import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {AddComponent} from './add.component';
import {UtilsModule} from '../utils/utils.module';

@NgModule({
    imports: [CommonModule, UtilsModule],
    declarations: [AddComponent],
    exports: [AddComponent]
})

export class AddModule {}