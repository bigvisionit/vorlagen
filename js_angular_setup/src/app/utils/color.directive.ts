import {Directive, HostBinding, Input} from '@angular/core';


@Directive({
    selector: '[myColor]'
})

export class MyColor {
    @HostBinding('style.color') fontColor: string;

    @Input()
    set myColor (color: string) {
        this.fontColor = color;
    }
    get myColor (): string {
        return this.fontColor;
    }
}
