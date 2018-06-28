import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {MyItalic} from './italic.directive';
import {MyColor} from './color.directive';
import {ReversePipe} from './reverse.pipe';

@NgModule({
    imports: [CommonModule],
    declarations: [MyItalic, MyColor, ReversePipe],
    exports: [MyItalic, MyColor, ReversePipe]
})

export class UtilsModule {}