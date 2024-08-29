import { ComponentFixture, TestBed, waitForAsync } from '@angular/core/testing';
import { BerandaPage } from './beranda.page';

describe('BerandaPage', () => {
  let component: BerandaPage;
  let fixture: ComponentFixture<BerandaPage>;

  beforeEach(waitForAsync(() => {
    fixture = TestBed.createComponent(BerandaPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
