import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { User } from '../models/User';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  users: User[];
  data: Observable<any>;

  constructor() {
    this.users = [
      {
        firstName: 'John',
        lastName: 'Doe',
        email: 'john@gmail.com',
        // age: 70,
        // address: {
        //   street: '50 Main st',
        //   city: 'Boston',
        //   state: 'MA'
        // },
        // image: 'http://lorempixel.com/600/600/people/3',
        isActive: true,
        // balance: 100,
        registered: new Date('01/02/2018 08:30:00'),
        hide: true
      },
      {
        firstName: 'Kevin',
        lastName: 'Johnson',
        email: 'kevin@yahoo.com',
        // age: 34,
        // address: {
        //   street: '20 School st',
        //   city: 'Lynn',
        //   state: 'MA'
        // },
        // image: 'http://lorempixel.com/600/600/people/2',
        isActive: false,
        // balance: 200,
        registered: new Date('03/11/2017 06:20:00'),
        hide: true
      },
      {
        firstName: 'Karen',
        lastName: 'Williams',
        email: 'karen@gmail.com',
        // age: 26,
        // address: {
        //   street: '55 Mill st',
        //   city: 'Miami',
        //   state: 'FL'
        // },
        // image: 'http://lorempixel.com/600/600/people/1',
        isActive: true,
        // balance: 50,
        registered: new Date('11/02/2016 10:30:00'),
        hide: true
      }
    ];
  }

  getData() {
    this.data = new Observable(observer => {
      setTimeout(() => {
        observer.next(1);
      }, 1000);

      setTimeout(() => {
        observer.next(2);
      }, 2000);

      setTimeout(() => {
        observer.next(3);
      }, 3000);

      setTimeout(() => {
        observer.next({name: 'Brad'});
      }, 4000);
    });

    return this.data;
  }

  getUsers(): Observable<User[]> {
    return of(this.users);
  }

  addUser(user: User) {
    this.users.unshift(user);
  }
}
