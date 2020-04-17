export interface UserState {
  name: string;
  surname: string;
  email: string;
  created_at: Date | string;
  updated_at: Date | string;
}

const userState: UserState | null = null;

export default userState;
