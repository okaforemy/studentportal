<template>
    <div>
   <Head title="add parent"/>
        <div class="pt-3">
            <div class="row">
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-header">
                    <h3 class="card-title">Add Parent/Guardian </h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                           <div class="row">
                               <div class="col-md-6">
                                   <label for="fullname">Fullname <Required/></label>
                                   <input type="text" name="" v-model="form.fullname" id="fullname" class="form-control" placeholder="(designation) Surname first, other names">
                                    <div v-if="errors.fullname" class="text-danger">{{ errors.fullname }}</div>
                               </div>
                               <div class="col-md-6">
                                   <label for="nationality">Nationality <Required/></label>
                                   <input type="text" name="" v-model="form.nationality" id="nationality" class="form-control" placeholder="Country of origin">
                                    <div v-if="errors.nationality" class="text-danger">{{ errors.nationality }}</div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-6 pt-md-4 pt-sm-2">
                                   <label for="occupation">occupation</label>
                                   <input type="text" name="" v-model="form.occupation" id="occupation" class="form-control" placeholder="occupation">
                               </div>
                               <div class="col-md-6 pt-md-4 pt-sm-2">
                                   <label for="home_address">Home Address <Required/></label>
                                   <input type="text" name="" v-model="form.home_address" id="home_address" class="form-control" placeholder="home address">
                                    <div v-if="errors.home_adddress" class="text-danger">{{ errors.home_adddress }}</div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-6 pt-md-4 pt-sm-2">
                                   <label for="office_address">Office Address</label>
                                   <input type="text" name="" v-model="form.office_address" id="office_address" placeholder="office address" class="form-control">
                               </div>
                               <div class="col-md-6 pt-md-4 pt-sm-2">
                                   <label for="email">E-mail</label>
                                   <input type="email" name="" id="email" v-model="form.email" class="form-control" placeholder="email_address@mail.com">
                                    <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-6 pt-md-4 pt-sm-2">
                                   <label for="phone">Phone Number <Required/></label>
                                   <input type="text" v-mask="'###########'" name="" id="phone" v-model="form.phone" class="form-control" placeholder="phone number">
                                    <div v-if="errors.phone" class="text-danger">{{ errors.phone }}</div>
                               </div>
                               <div class="col-md-6 pt-md-4 pt-sm-2">
                                   <label for="parent">Parent or Guardian? <Required/></label>
                                   <select name="" id="parent" v-model="form.isparent" class="custom-select">
                                       <option value="">Choose</option>
                                       <option v-for="(ptype,index) in parent_type" :key="index" :value="ptype |toLower">{{ptype}}</option>
                                      
                                   </select>
                                    <div v-if="errors.isparent" class="text-danger">{{ errors.isparent }}</div>
                               </div>
                           </div>
                           <div class="text-center pt-4">
                               <button class="btn btn-primary" type="submit">Save</button>
                           </div>
                        </form>
                    </div>  
                        
                </div>
            </div>
            <div class="col-md-4">

                 <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Search</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-sm-responsive p-0">
                      
                       <autocomplete
                            :search="search"
                            placeholder="Search for parents"
                            aria-label="Search for parents"
                            :get-result-value="getResultValue"
                            @submit="handleChange"
                            class="px-3 py-4"
                        ></autocomplete>
                    </div>
                    <!-- /.card-body -->
                </div>

                    <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Actions</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-sm-responsive p-0">
                      
                    </div>
                    <!-- /.card-body -->
                </div>
               
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue'
import Required from '../../Shared/Required'
import { Link } from '@inertiajs/inertia-vue'

export default {
    props: {
        student_id: String,
        surname:String,
        othernames:String,
        errors: Object,
        Parents: Array,
    },
    components: {
        Head, Required,Link
    },
    data(){
        return{
            form: this.$inertia.form({
                fullname:null,
                nationality:null,
                occupation:null,
                home_adddress:null,
                office_adddress:null,
                email:null,
                phone:null,
                id:this.student_id,
                isparent:'',
            }),
            result:{},
            parent_type:{
                father:'Father',
                mother: 'Mother',
                guardian: 'Guardian'
            },
            mother:{},
            father:{},
            guardian:{},
        }
    },
    methods:{
        submit(){
            
            this.$inertia.post('/add-parents-only',this.form,{
                onSuccess: (response)=>{
                   this.form = this.$inertia.form({
                        fullname:null,
                        nationality:null,
                        occupation:null,
                        home_adddress:null,
                        office_adddress:null,
                        email:null,
                        phone:null,
                        id:this.student_id,
                        isparent:'',
                    })
                     toastr.success('Parent added successfully!', 'Success')
                }
            });
        },
        search(input) {
            const url = "/search-for-parent";
        
            return new Promise((resolve) => {
                if (input.length < 3) {
                return resolve([])
                }
    
                fetch(url+"?"+ new URLSearchParams({
                        search: input
                    })
                    )
                .then((response) => response.json())
                .then((data) => {
                    resolve(data)
                })
            })
            },
        getResultValue(result) {
            this.result = result
            return result.fullname
            },
        handleChange(event){
            this.form=this.$inertia.form(this.result)
        },
        checkValues(val){
            if(val.length>0){
                return true;
            }else{
                return false;
            }
        }
    },
    // computed:{
    //     ismother: function(){
    //         let mother= this.Parents.filter(val=>val.isparent == 'mother')
    //         if(this.checkValues(mother)){
    //             this.mother=mother
    //             delete this.parent_type.mother
    //             return mother[0].isparent
    //         }
    //     },
    //     isfather: function(){
    //         let father = this.Parents.filter(val=>val.isparent=='father')
    //         if(this.checkValues(father)){
    //             this.father=father
    //              delete this.parent_type.father
    //             return father[0].isparent
    //         }
    //     },
    //     isguardian: function(){
    //         let guardian = this.Parents.filter(val=>val.isparent == 'guardian')
    //         if(this.checkValues(guardian)){
    //             this.guardian = guardian
    //             delete this.parent_type.guardian
    //             return guardian[0].isparent
    //         }
    //     }
    // },
    filters:{
        toLower: function(value){
            if(value){
                return value.toLowerCase();
            }
        }
    }
}
</script>