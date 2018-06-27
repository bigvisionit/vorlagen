import {Component, Input, Output, EventEmitter} from '@angular/core';
import {Router} from '@angular/router';

@Component({
    selector: 'add',
    templateUrl: './add.component.html',
    styleUrls: ['./add.component.css']
})


export class AddComponent {
    @Input()
    param: string;

    @Output()
    choise: EventEmitter<string> = new EventEmitter<string>();

    constructor(private router: Router) {}

    goBack(evt: Event): void {

        // alert(this.param);

        // this.choise.emit('test');

        this.router.navigate(['/todos']);
    }

}