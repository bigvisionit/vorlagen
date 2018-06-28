import {IUser} from './user.data';

export class UserService {

    setUser(user: IUser): void {
        localStorage.setItem('user', JSON.stringify(user));
    }

    getUser(): IUser {
        return <IUser>JSON.parse(localStorage.getItem('user'));
    }

}
