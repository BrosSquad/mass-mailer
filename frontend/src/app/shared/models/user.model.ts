export interface User {
  name: string;
  surname: string;
  email: string;
  bio?: string;
  avatar?: string | null;
  backgroundImage?: string | null;
  phone?: string | null;
  role: string;
}
