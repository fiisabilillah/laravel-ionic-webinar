import { Component } from '@angular/core';
import { Session } from 'src/provider/Session';
import { Utility } from 'src/provider/Utility';
import { register } from 'swiper/element/bundle';
register();
@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {
  constructor(public util: Utility, public session: Session) {
    this.cekLogin();
  }
  cekLogin() {
    let session = this.session.get('user');
    if (session == null) {
      this.util.NavigasiUrl('/welcome');
    } else {
      this.util.NavigasiUrl('/home/beranda');
    }
  }
}
