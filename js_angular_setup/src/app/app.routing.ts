import {RouterModule, Routes} from '@angular/router';
import {ModuleWithProviders} from '@angular/core';
import {LoginComponent} from './login/login.component';
import {TodosComponent} from './todos/todos.component';
import {AddComponent} from './add/add.component';


const appRoutes: Routes = [
    {
      path: '',
      pathMatch: 'full',
      redirectTo: 'login'
    },
    { path: 'login', component: LoginComponent },
    { path: 'todos', component: TodosComponent },
    { path: 'add', component: AddComponent },
    {
        path: '**',
        redirectTo: 'login'
    }
];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);
