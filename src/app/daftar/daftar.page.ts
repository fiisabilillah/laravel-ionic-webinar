import { Component, OnInit } from '@angular/core';
import { RestApi } from 'src/provider/RestApi';
import { Utility } from 'src/provider/Utility';

@Component({
  selector: 'app-daftar',
  templateUrl: './daftar.page.html',
  styleUrls: ['./daftar.page.scss'],
})
export class DaftarPage implements OnInit {
name:any;
email:any;
password:any;
c_password:any;
  constructor(
    public api:RestApi,
    public util :Utility
  ) { }

  ngOnInit() {
  }


  daftar(){
    let body={
      name:this.name,
      email:this.email,
      password:this.password,
      c_password:this.c_password
    }
    this.api.post(body,'user/register').subscribe((res:any)=>{

      if (res.success==true) {
        this.util.alertNotif('Pendaftaran Berhasil Silahkan login');
      }else{
        this.util.alertNotif('Pendaftaran Gagal Silahkan Ulangi');
      }
    });
  }
}
