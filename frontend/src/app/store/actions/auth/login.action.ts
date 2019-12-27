export interface Login {
    email: string;
    password: string;
}

export class LoginAction {
    public static readonly type: string = '[Auth] LOGIN';

    public constructor(public readonly payload: Login) {}
}