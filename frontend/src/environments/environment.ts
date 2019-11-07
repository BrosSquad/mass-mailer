export interface Environment {
  production: boolean;
  api: string;
}
export const environment: Environment = {
  production: false,
  api: 'http://notifications.com/api'
};
