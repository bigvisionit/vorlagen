export interface IUser {
    id: number,
    login: string,
    password: string,
    mail: string
}

export let userData: IUser[] = [
    {
        id: 1,
        login: 'test',
        password: 'test',
        mail: 'test@test.de'
    },
    {
        id: 2,
        login: 'maxmuster',
        password: 'maxmuster',
        mail: 'maxmuster@musterfirma.de'
    }
]
