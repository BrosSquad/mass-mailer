import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SidebarUserComponent } from './sidebar-user.component';

describe('SidebarUserComponent', () => {
  let component: SidebarUserComponent;
  let fixture: ComponentFixture<SidebarUserComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SidebarUserComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SidebarUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
