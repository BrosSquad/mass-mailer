import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UserCardAvatarComponent } from './user-card-avatar.component';

describe('UserCardAvatarComponent', () => {
  let component: UserCardAvatarComponent;
  let fixture: ComponentFixture<UserCardAvatarComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UserCardAvatarComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UserCardAvatarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
