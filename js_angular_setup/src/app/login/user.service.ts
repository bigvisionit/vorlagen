import {IUser} from './user.data';
import {Injectable} from '@angular/core';

@Injectable()
export class UserService {

    setUser(user: IUser): void {
        localStorage.setItem('user', JSON.stringify(user));
    }

    getUser(): IUser {
        return <IUser>JSON.parse(localStorage.getItem('user'));
    }

}
