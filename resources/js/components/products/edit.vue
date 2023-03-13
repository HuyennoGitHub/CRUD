
<template>
    <div class="products__edit ">
       
       <div class="products__create__titlebar dflex justify-content-between align-items-center">
            <!-- <div>{{msg}}</div> -->
            <!-- <div><button @click="oldData(form.id)">click</button></div> -->
            <div>ID: {{id}}</div>
           <div class="products__create__titlebar--item">
               
               <h1 class="my-1">Edit Product</h1>
           </div>
       </div>
       <button @click="getOldData(id)">Get Product's Info</button>
       <div class="products__create__cardWrapper mt-2">
                <div class="products__create__main">
                    <div class="products__create__main--addInfo card py-2 px-2 bg-white">
                        <p class="mb-1 mt-1">ID</p>
                        <input type="text" class="input" placeholder="Nhập vào mã sản phẩm..." v-model="form.iden">

                        <p class="mb-1 mt-1">Name</p>
                        <input type="text" class="input" placeholder="Nhập vào tên sản phẩm..." v-model="form.name">

                        <p class="mb-1 mt-1">Price</p>
                        <input type="text" class="input" placeholder="Nhập vào giá sản phẩm..." v-model="form.price">
                        
                        <div class="products__create__main--media--images mt-2">
                        <ul class="products__create__main--media--images--list list-unstyled">
                            <li class="products__create__main--media--images--item">
                                <div class="products__create__main--media--images--item--imgWrapper">
                                    <img class="products__create__main--media--images--item--img" :src="getImage()" alt="" />  
                                </div>
                            </li>
                            <!-- upload image small -->
                            <li class="products__create__main--media--images--item">
                                <form class="products__create__main--media--images--item--form">
                                    <label class="products__create__main--media--images--item--form--label" for="myfile">Add Image</label>
                                    <input class="products__create__main--media--images--item--form--input" type="file" id="myfile" @change="updateImage">
                                </form>
                            </li>
                        </ul>
                        </div>
                
                    </div>

                </div>
            </div>
       <!-- Footer Bar -->
       <div class="dflex justify-content-between align-items-center my-3">
                <button class="btn btn-secondary" @click="updateProduct(id)">Update</button>
            </div>
   
    </div>
</template>

<script >
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();



export default {
    props: ['id'],
    data() {    
        return {
            form : {
                
                iden:'',
                name:'',
                price:'',
                image:'',
                img:''
            }
        }
    },
    created() {
        axios.get(`/api/get_edit_product/`+this.id)
             .then(res=>{
                 this.form = res.data.product;
                //   console.log(this.props);
                //console.log(res);
             })
             .catch(errors=>{
                console.log(errors);
             })
    }
    ,
    methods: {
        getImage() {
            if(this.form.image){
                if(this.form.image.indexOf('base64') !=-1){
                    return  this.form.image
                }else{
                    return '/upload/'+this.form.image
                }
            }   
        },
        updateImage(e) {
            const file = e.target.files[0];
            this.form.img=file;
            const reader = new FileReader();
            const limit = 1024*1024*2;
            if (file['size']>limit) {
                return false;
            }
            reader.onloadend = (file) => {
                this.form.image = reader.result;
            }
            reader.readAsDataURL(file);
        },
        getOldData(id){
            axios.get(`/api/get_edit_product/${id}`)
             .then(res=>{
                 this.form = res.data.product;
                //  console.log(this.form);
                //console.log(res);
             })
             .catch(errors=>{
                console.log(errors);
             })
        },
        updateProduct(id){
            const formData = new FormData()
            formData.append('iden',this.form.iden)
            formData.append('name',this.form.name)
            formData.append('price',this.form.price)
            formData.append('img',this.form.img)

            axios.post(`/api/update_product/${id}`,formData)
            .then((response)=>{
                this.$router.push('/')
                toast.fire({
                    icon:"success",
                    title:"Product update successfully"
                })
                console.log(response)
            })
            .catch((error) => {
                console.log(error);
            })
        },
    }
}
</script>

<style>

</style>