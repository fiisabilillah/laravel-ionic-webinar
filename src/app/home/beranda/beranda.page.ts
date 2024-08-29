import { Component, OnInit } from '@angular/core';
import { NavigationExtras, Router } from '@angular/router';
import { RestApi } from 'src/provider/RestApi';
import { Session } from 'src/provider/Session';
import { Utility } from 'src/provider/Utility';

@Component({
  selector: 'app-beranda',
  templateUrl: './beranda.page.html',
  styleUrls: ['./beranda.page.scss'],
})
export class BerandaPage implements OnInit {
  products: any = [];
  currentPage: number = 1;
  itemsPerPage: number = 12;
  searchTerm:any;
  constructor(
    public session: Session,
    public util: Utility,
    public router: Router,
    public api: RestApi
  ) {}

  ngOnInit() {
    this.loadData(null);
  }



  getProduct(page: number) {
    return this.api.get(`barang?page=${page}`);
  }

  loadData(event:any){
    this.util.showLoading();
    this.getProduct(this.currentPage).subscribe((res: any) => {
      this.util.dismissLoading();
      console.log(res);

      this.products = this.products.concat(res.data.data);
      if (event) {
        event.target.complete();
      }
      this.currentPage++;
      if (res.page === res.total) {
        if (event) {
          event.target.disabled = true;
        }
      }
    });
  }

  toSerach(cari:any) {
    let navigationExtras: NavigationExtras = {
      queryParams: {
        cari: cari,
      },
    };
    this.router.navigate(['/cari'], navigationExtras);

  }

  detail(id:any) {

    let navigationExtras: NavigationExtras = {
      queryParams: {
        id: id,
      },
    };
    this.router.navigate(['/detail-produk'], navigationExtras);

  }
}
