import { TestBed } from '@angular/core/testing';

import { NavTitleService } from './nav-title.service';

describe('NavTitleService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: NavTitleService = TestBed.get(NavTitleService);
    expect(service).toBeTruthy();
  });
});
