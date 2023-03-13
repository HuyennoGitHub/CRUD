<template>
    <div class="container">
        <div class="products__list table  my-3">
            
              <div class="customers__titlebar dflex justify-content-between align-items-center">
                  <div class="customers__titlebar--item">
                      <h1 class="my-1">Products</h1>
                  </div>
                  <div class="customers__titlebar--item">
                      <button class="btn btn-primary" @click="sortBy('AZ')">A->Z</button>
                      <button class="btn btn-primary" @click="sortBy('ZA')">Z->A</button>
                      <button class="btn btn-primary" @click="search">Search</button>
                      <button class="btn btn-secondary my-1" @click="newProduct">
                          Add Product
                      </button>
                  </div>
              </div>
      
              <div class="table--heading mt-2 products__list__heading " style="padding-top: 20px;background:#FFF">
                  <p class="table--heading--col1">ID</p>
                  <p class="table--heading--col2">
                      Product
                  </p>
                  <p class="table--heading--col4">Price</p>
                  <p class="table--heading--col3">
                      Image
                  </p>
                  <p class="table--heading--col5">
                    Created_at
                  </p>
                  <p class="table--heading--col6">
                    Updated_at
                  </p>
                  <p class="table--heading--col7">Actions</p>
              </div>
      
              <div class="table--items products__list__item" v-for="item in products" :key="item.id" v-if="products.length >0">
                  <p class="table--items--col2">
                     {{item.iden}}
                  </p>
                  <p class="table--items--col2">
                      {{item.name}}
                  </p>
                  <p class="table--items--col3">
                        {{item.price}}
                  </p>    
                  <div class="products__list__item--imgWrapper">
                      <img class="products__list__item--img" :src="getImg(item.image)" style="height: 40px" v-if="item.image">
                  </div>
                  <p class="table--items--col5" > 
                    {{ format_date(item.created_at) }}
                  </p> 
                  <p class="table--items--col6" > 
                    {{ format_date(item.updated_at) }}
                  </p>
                  <div>     
                      <button class="btn-icon btn-icon-success" @click="edit(item.id)">
                          <i class="fas fa-pencil-alt"></i>
                          <div>
                            <Edit1 :id=item.id v-if="false"></Edit1>
                          </div>
                      </button>
                      <button class="btn-icon btn-icon-danger" @click="deleteProduct(item.id)">
                          <i class="far fa-trash-alt"></i>
                      </button>
                  </div>
              </div> 
                <div class="table--items products__list__item" v-else>
                    <p>Product not found</p>
                </div>
          </div>
    </div>
    
</template>

<script>
import { Swal } from 'sweetalert2/dist/sweetalert2';
import { useRouter } from 'vue-router'
import Edit1 from './edit.vue';

const router = useRouter();


export default {
    
    components: {
        Edit1
    },
    data() {
        return {
            products: [],
            date: {
                time_created: Date,
                time_updated: Date
            },
            order:0
        };
},
    
  
   methods: {
        newProduct() {
            this.$router.push('/product/new')
        },
        edit(id){
            this.$router.push(`/product/edit/${id}`)
        },
        search(){
            this.$router.push('/product/search')
        },
        getImg (img) {
        return "upload/"+img
        },
       
        deleteProduct(id) {
            toast.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this product!',
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
            })
            .then((result) => {
                console.log('result:',result)
                if (result.value) {
                    axios.delete('/api/delete_product/'+id)
                     .then((response) => {
                        //this.products.splice(this.products.indexOf(id),1)
                        //this.$router.push('/');
                        axios.get(`/api/get_all_product`)
                        .then(res => {
                            this.products = res.data;
                        })
                        .catch(e => {
                            console.log(e);
                        })
                        toast.fire(
                            'Deleted!',
                            'Product Deleted Successfully!',
                            'success'
                        )
                    })
                     .catch((error) => {
                        console.log(error)
                        toast.fire(
                            'Error!',
                            'Something went wrong! Try again!',
                            'error'
                        )
                    })
                }
            })
        },
        format_date(time){
            const date = {year: 'numeric', month: 'numeric', day: 'numeric'};
            return new Date(time).toLocaleDateString(date);
        },
        sortBy(sortKey) {
            if (sortKey == 'AZ') {
                this.products = _.orderBy(this.products, 'name', 'asc');
            }
            else {
                console.log('za');
                this.products = _.orderBy(this.products, 'name', 'desc');
            }
        }
    },
    created() {
            axios.get(`/api/get_all_product`)
                .then(res => {
                    this.products = res.data;
                })
                .catch(e => {
                    console.log(e);
                })
    }  ,
}

</script>
<style scoped>
p {
    overflow-x: auto !important;
}
</style>