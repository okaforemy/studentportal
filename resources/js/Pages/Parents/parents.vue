<style scoped>
    .fa-user{
        font-size: 4em;
    }
    #accept-child {
        border: 1px solid #CED4DA;
        border-radius: 5px;
        padding-top: 10px;
        padding-left: 5px;
        padding-right: 5px;
    }
    .no-border-input{
        border: none;
    }
    #accept-child span{
        padding: 5px;
    }
    .no-style{
        list-style: none;
        padding-left: 0;
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    .no-style li{
        padding: 8px 0 8px 12px;
        border-bottom: 1px solid #CED4DA;
        cursor: pointer;
    }
    .no-style li:hover{
        background: #dde0e4;
        border-radius: 2px;
    }
    .tags{
        list-style: none;
        list-style: none;
        display: inline;
        padding-left: 5px;
        padding-right: 5px;
    }
    .tag-item {
        background: gray;
        margin-right: 12px;
        color: white;
        padding: 2px 10px 5px 10px;
        border-radius: 6px;
        line-height: 1.4;
        float: left;
        margin: 5px;
    }
    .tag-item span{
        cursor: pointer;
    }

    .fade-enter-active, .fade-leave-active {
        transition: .5s;
        }
</style>
<template>
    <div class="pt-4 pb-4 px-3">
        <Head title="Parents"/>
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Parents</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                 <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Phone number</th>
                        <th>Assigned?</th>
                        <th>No. of Wards</th>
                        <th>Options</th>
                    </tr>
                 </thead>
                 <tbody v-if="parents.data.length > 0">
                     <tr v-for="(parent,index) in parents.data" :key="index">
                         <td>{{index+1}}</td>
                         <td><a href="#" @click="viewParent(index)">{{parent.fullname}}</a></td>
                         <td>{{parent.email}}</td>
                         <td>{{parent.phone}}</td>
                         <td>
                             <a href="#" v-if="parent.students.length>0" @click="reAssign(index,parent.id)">Reassign</a>
                             <a href="#" @click="assign(index,parent.id)" v-else>Assign</a>
                         </td>
                         <td ref="totalstudent">{{parent.students.length}}</td>
                         <td>
                             <Link href="/edit-parent-only" :data="{id:parent.id}"><i class="fas fa-edit text-success"></i></Link>
                             <a href="#" @click.prevent="deleteParent(parent.id, parent.fullname)"><i class="fas fa-trash text-danger"></i></a>
                         </td>
                     </tr>
                 </tbody>
                </table>
                <Paginator :links="parents.links"/>
              </div>
              <!-- /.card-body -->
            </div>

            <!-- View parent Modal -->
        <div class="modal fade" id="viewparent" tabindex="-1" role="dialog" aria-labelledby="viewParentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewParentModalLabel"><strong>{{parent.fullname}}</strong>, {{parent.isparent}} to {{parent.students?parent.students.length:'unassigned'}} Children</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center" v-if="parent.url">
                            <img class="profile-user-img img-fluid img-circle" src="" alt="User profile picture">
                            </div>
                            <div v-else class="text-center">
                                <i class="fas fa-user"></i>
                            </div>

                            <h3 class="profile-username text-center">{{parent.fullname}}</h3>

                            <p class="text-muted text-center">{{parent.occupation}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nationality</b> <a class="float-right">{{parent.nationality}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right" :href="'mailto:'+parent.email">{{parent.email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <a class="float-right" :href="'tel:'+parent.phone">{{parent.phone}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Home Address</b> <a class="float-right">{{parent.home_address}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Office Address</b> <a class="float-right">{{parent.office_address}}</a>
                            </li>
                            </ul>

                            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                        </div>
                <!-- /.card-body -->
                </div>

                <!-- second card -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Children</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                         <table class="table table-hover text-nowrap table-responsive">
                             <thead>
                                 <tr>
                                     <th>S/N</th>
                                     <th>Name</th>
                                     <th>Class</th>
                                     <th>Student ID</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr v-for="(pa,index) in parent.students" :key="index">
                                     <td>{{index+1}}</td>
                                     <td>{{pa.surname+" "+pa.othernames}}</td>
                                     <td>{{pa.grade}}</td>
                                     <td>{{pa.student_id}}</td>
                                 </tr>
                             </tbody>
                         </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            
            </div>
        </div>
        </div>

        <!--Assign Modal -->
        <div class="modal fade" id="assign" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign a child to parent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" @click="closeModal">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="accept-child">
                    <transition name="fade">
                        <ul class="tags">
                            <li class="tag-item" v-for="(tag,index) in tags" :key="index">{{tag.fullname}} <span @click="close(index,tag)"><i class="fas fa-times"></i></span></li>
                        </ul>
                    </transition>
                    <input type="text" autofocus ref="search_input"  placeholder="search by name or student ID" v-model="search" class="form-control no-border-input">
                </div>
                <transition name="fade">
                        <ul class="no-style" v-if="students.length > 0 ">
                            <li v-for="(std, index) in students" :key="index" :class="{'text-danger': std.parents_count >= 2}" @click="selectStudent(index,std)">{{std.fullname+" ("+std.grade+")"}} 
                                <span v-if="std.parents_count >= 2" class="text-danger pl-2">[Cannot assign this student]</span>
                            </li>
                        </ul>
                        <ul class="no-style" v-if="!isfound">
                            <li>Student not found.</li>
                        </ul>
                </transition>
                <div class="text-center mt-2">
                    <form @submit.prevent="assignStudent(tags)">
                         <input v-if="tags.length > 0" :disabled="isprocessing"  type="submit" class="btn btn-primary" value="Assign">
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import { Head } from '@inertiajs/inertia-vue'
import { Link } from '@inertiajs/inertia-vue'
import Paginator from '../../Shared/paginator.vue'
import RadialProgressBar from 'vue-radial-progress'
import _ from 'lodash';
import axios from 'axios'
import { Inertia } from '@inertiajs/inertia'

export default {
    components:{
        Head, Link, Paginator, RadialProgressBar
    },
    props:{
        parents:Object
    },
    data(){
        return{
            parent:{},
            search:'',
            students:[],
            tags:[],
            istime:false,
            isfound:true,
            current_parent:null,
            index:null,
           // parents:this.parentss,
            temp:null,
            isprocessing:false,
            reassign:false
        }
    },
    watch:{
        parents:{
            students:{
                 handler(newValue, oldValue) {
                   this.parents = this.parents
                },
                deep: true
            }
        }
    },
    methods:{
        viewParent(id){
            this.parent = this.parents.data[id];
            $('#viewparent').modal('show');
        },
        assign(index,id){
           this.current_parent=id
           this.index = index
            $('#assign').modal('show');
            this.reassign=false;
            this.$nextTick(function () {
                this.$refs.search_input.focus()
                this.$el.querySelector(".no-border-input").focus()
            })
        },
        reAssign(index,id){
            this.current_parent=id
            this.index = index
            this.reassign=true;
            this.tags = this.parents.data[index].students
                $('#assign').modal('show');
                this.$nextTick(function () {
                    this.$refs.search_input.focus()
                    this.$el.querySelector(".no-border-input").focus()
                })
        },

        selectStudent(index,std){
            if(std.parents_count >= 2){
                return false;
            }else{
                this.tags.push(std)
                this.students.splice(index,1);
            }
          
        },
        close(index,tag){
            let val = tag
            this.tags.splice(index,1);
            this.students.push(tag);
        },
        assignStudent(tags){
            this.isprocessing=true;
            axios.post('/assign-children',{tags:this.tags,parent_id:this.current_parent,reassign:this.reassign}).then((response)=>{
              this.students.splice(0,(this.students.length))
              this.tags.splice(0,this.tags.length)
              //this.temp=this.index;
              this.search=""
                this.isprocessing=false;
                $('#assign').modal('hide');
                Inertia.reload({ only: ['parents'] })
            })
        },
        closeModal(){
            //this.students.splice(0,this.students.length)
           // this.tags.splice(0,this.tags.length)
            //this.search=""
            Inertia.reload({ only: ['parents'] })
        },
        deleteParent(id,name){
           $.confirm({
            title: 'Delete!',
            content: 'Do you want to delete '+name,
            type: 'red',
            buttons: {   
                ok: {
                    text: "ok!",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                       axios.get('/delete-parent',{params:{id:id}}).then((response)=>{
                           if(response.data){
                               Inertia.reload({ only: ['parents'] })
                           }
                       })
                    }
                },
                cancel: function(){
                       
                }
            }
        });
        }
    },

    watch:{
        search: _.debounce(function(){
            if(this.search !=""){
                axios.get('/search-students',{params:{search:this.search}}).then((response)=>{
                this.students = response.data
                if(response.data.length > 0){
                     this.isfound=true
                }else{
                     this.isfound=false
                }
                    })
            }else if(this.search==""){
                this.students.splice(0,(this.students.length))
                this.isfound=true
            }
       },400),

       temp: function(){
          // this.parents.data[this.index] = this.temp
           Inertia.reload({ only: ['parents'] })
       }
    },

}

// the temp file holds a temporary index data which enables me to 
// watch the returned data, and then refresh the page with 
// the data returned.
</script>