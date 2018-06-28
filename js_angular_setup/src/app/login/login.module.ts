import {NgModule, ValueProvider} from '@angular/core';
import {CommonModule} from '@angular/common';
import {LoginComponent} from './login.component';
import {UtilsModule} from '../utils/utils.module';
import {UserService} from './user.service';

@NgModule({
    imports: [CommonModule, UtilsModule],
    declarations: [LoginComponent],
    exports: [LoginComponent],
    providers: [
        UserService,
        (<ValueProvider>{provide: 'author', useValue: 'david kempf', multi: false})
    ]
})

export class LoginModule {}