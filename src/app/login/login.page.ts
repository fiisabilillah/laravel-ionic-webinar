import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { RestApi } from 'src/provider/RestApi';
import { Session } from 'src/provider/Session';
import { Utility } from 'src/provider/Utility';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  email: any;
  password: any;
  constructor(
    private util: Utility,
    public api: RestApi,
    public session: Session,
    public utility: Utility,
    public router: Router
  ) {}

  ngOnInit() {}

  cekLogin() {
    this.util.showLoading();
    let body = {
      email: this.email,
      password: this.password,
    };
    this.api.post(body, 'user/login').subscribe((res: any) => {
      this.util.dismissLoading();
      if (res.success == true) {
        this.session.set('user', res.data);
        this.router.navigate(['/home/beranda'], { replaceUrl: true });
      } else {
        this.util.alertNotif('Login Gagal, Cek Email dan Password');
      }
    });
  }

}
