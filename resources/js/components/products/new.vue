<template>
    <div class="container">
        <div class="products__create ">
            
            <div class="products__create__titlebar dflex justify-content-between align-items-center">
                <div class="products__create__titlebar--item">
                    
                    <h1 class="my-1">Add Product</h1>
                </div>
            </div>

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
                <p ></p>
                <button class="btn btn-secondary" @click="saveProduct()">Save</button>
            </div>

        </div>
    </div>
</template>
<script>
import { useRouter } from 'vue-router';

const router = useRouter();

export default {
    data() {
        return {
            form: {
                iden:'',
                name:'',
                price:'',
                image:'',
                img: '',
            }
        }
    },
    methods: {
        getImage(){
            let image = "/upload/image.png";
            if(this.form.image){
                if(this.form.image.indexOf('base64') !=-1){
                    image = this.form.image
                }else{
                    image = '/upload/'+this.form.image
                }
            }
            return image
        },
        updateImage(e) {
            let file = e.target.files[0];
            this.form.img = file;
            let reader = new FileReader();
            let limit = 1024*1024*2;
            if(file['size']>limit){
                return false
            }
            reader.onloadend = (file) => {
                this.form.image = reader.result;
            }
            reader.readAsDataURL(file);
        },
        saveProduct(){
            const formData = new FormData()
            formData.append('iden',this.form.iden)
            formData.append('name',this.form.name)
            formData.append('price',this.form.price)
            formData.append('img',this.form.img)
            axios.post("/api/add_product",formData)
            .then((response)=>{
                this.$router.push('/');

                toast.fire({
                    icon:"success",
                    title:"Product add successfully"
                })
            })
            .catch((error) => {

            })
        }
    }
}
</script>