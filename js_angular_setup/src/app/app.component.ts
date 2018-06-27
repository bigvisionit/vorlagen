import {Component} from '@angular/core';

@Component({
    selector: 'app',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css']
})


export class AppComponent {
    title: string = 'ToDo\'s';

    test(evt: Event): void {
        console.log(evt);
    }
}
