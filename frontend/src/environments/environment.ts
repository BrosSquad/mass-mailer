export interface Environment {
  production: boolean;
  api: string;
}
export const environment: Environment = {
  production: false,
  api: 'http://localhost:8000/api', // Laravel development server
};
