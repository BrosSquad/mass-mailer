import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ChangeImageModel } from '../models/change-image.model';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  public constructor(private readonly httpClient: HttpClient) { }

  public me() {
    return this.httpClient.get('/me');
  }

  public changeImage(model: ChangeImageModel): Observable<{image: string}> {
    const formData = new FormData();
    console.log(model);
    formData.append('type', model.type);
    formData.append('avatar', model.file);


    formData.forEach(item => console.log(item));
    return this.httpClient.post<{image: string}>('/users/change-image', formData);

  }

  public updateProfile() {
    
  }

  public changeBackgrounImage() {

  }
}
