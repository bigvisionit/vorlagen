import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {TodosComponent} from './todos.component';

@NgModule({
    imports: [CommonModule],
    declarations: [TodosComponent],
    exports: [TodosComponent]
})

export class TodosModule {}