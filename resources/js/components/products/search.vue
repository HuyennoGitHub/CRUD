<template>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class = "card">
                <input type="text" v-model="searchText" @keyup="search()">
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
                  <p class="table--heading--col7">Actions</p>
              </div>
      
              <div class="table--items products__list__item" v-for="item in searchArrs" :key="item.id" v-if="searchArrs.length >0">
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
import Axios from 'axios';
import { useRouter } from 'vue-router'
import { Swal } from 'sweetalert2/dist/sweetalert2';
import Edit1 from './edit.vue';

const router = useRouter() ;

export default {
    components: {
        Edit1
    },
    data() {
        return {
            searchText:'',
            searchArrs:[],
        }
    },
    methods: {
        search(){
            Axios.post('/api/search_product', {
                name: this.searchText
            })
             .then((response) => {
                this.searchArrs=response.data;
                console.log(this.searchArrs);
            })
             .catch((error) => {
                console.log(error);
             });
        },
        edit(id) {
            this.$router.push(`/product/edit/${id}`)
        },
        getImg (img) {
            return "/upload/"+img
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
                        this.$router.push('/');

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
        }

    }
}
</script>
<style scoped>
    input {
        width: 897px;
        height: 50px;
        font-size: x-large;
        margin: 10px;
    }
    .row {
        width: fit-content;
    }
</style>