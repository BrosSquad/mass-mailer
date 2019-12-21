import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RequestPasswordChangeComponent } from './request-password-change.component';

describe('RequestPasswordChangeComponent', () => {
  let component: RequestPasswordChangeComponent;
  let fixture: ComponentFixture<RequestPasswordChangeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RequestPasswordChangeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RequestPasswordChangeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
