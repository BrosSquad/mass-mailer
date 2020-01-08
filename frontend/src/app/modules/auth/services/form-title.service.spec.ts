import { TestBed } from '@angular/core/testing';

import { FormTitleService } from './form-title.service';

describe('FormTitleService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: FormTitleService = TestBed.get(FormTitleService);
    expect(service).toBeTruthy();
  });
});
