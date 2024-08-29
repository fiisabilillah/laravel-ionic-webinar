import { Component, OnInit } from '@angular/core';
import { RestApi } from '../../provider/RestApi';


@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
  constructor(private api: RestApi) {
    this.getproduk();
  }

  OnInit(){
    this.getproduk();
  }
  ionViewDidLoad() {
    this.getproduk();
  }
  getproduk() {
    this.api.get('barang').subscribe((res: any) => {
      console.log(res.data.data);
    });
  }
}
