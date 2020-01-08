import { State, Action, StateContext, Selector } from "@ngxs/store";
import { LogoutAction, LoginAction } from "../actions/auth";

export interface AuthStateModel {}

@State<AuthStateModel>({
  name: "auth",
  defaults: {}
})
export class AuthState {
  @Selector()
  public static user(state: AuthStateModel) {}

  @Selector()
  public static isAuthenticated(): boolean {
    return false;
  }

  @Action(LoginAction)
  public login(context: StateContext<AuthStateModel>, action: LoginAction) {}

  @Action(LogoutAction)
  public logout(context: StateContext<AuthStateModel>, action: LogoutAction) {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
  }
}
