import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  public constructor(private readonly httpClient: HttpClient) { }

  public me() {
    return this.httpClient.get('/me');
  }

  public changeAvatar() {

  }

  public updateProfile() {
    
  }

  public changeBackgrounImage() {

  }
}
