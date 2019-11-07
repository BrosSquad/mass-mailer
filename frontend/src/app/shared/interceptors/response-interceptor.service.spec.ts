import { TestBed } from '@angular/core/testing';

import { ResponseInterceptorService } from './response-interceptor.service';

describe('ResponseInterceptorService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ResponseInterceptorService = TestBed.get(ResponseInterceptorService);
    expect(service).toBeTruthy();
  });
});
