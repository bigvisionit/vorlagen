import {Component, Inject} from '@angular/core';
import {IUser, userData} from './user.data';
import {UserService} from './user.service';

@Component({
    selector: 'login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})


export class LoginComponent {
    userList: IUser[] = userData;
    selectedUser: IUser;

    constructor(private userService: UserService, @Inject('author') public author: string) {

        //console.log(author);

        //this.userService.setUser(this.userList[0]);

        // this.selectedUser = this.userList.find((value) => {
        //    return value.id === 1;
        // });
        // console.log(this.selectedUser);

        //console.log(this.userService.getUser());

    }
}
