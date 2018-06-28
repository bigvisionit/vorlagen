import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {AppComponent} from './app.component';
import {LoginModule} from './login/login.module';
import {TodosModule} from './todos/todos.module';
import {AddModule} from './add/add.module';
import {routing} from './app.routing';
import {UtilsModule} from './utils/utils.module';

@NgModule({
    imports: [BrowserModule, LoginModule, TodosModule, AddModule, UtilsModule, routing],
    declarations: [AppComponent],
    bootstrap: [AppComponent]
})

export class AppModule {}
