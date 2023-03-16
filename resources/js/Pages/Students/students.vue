<style scoped>
    .card{
        margin-bottom: 0;
    }
    .table-responsive{
      overflow: visible;
    }
</style>
<template>
    <div class="pt-4 pb-4 px-3">
        <Head title="Students"/>
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Students</h3>

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
                      <th>ID</th>
                      <th>Surname</th>
                      <th>Other names</th>
                      <th>Date of birth</th>
                      <th>Sex</th>
                      <th>Grade</th>
                      <th>Student ID</th>
                      <th>Reg Progress</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(student,index) in students.data" :key="index">
                      <td>{{index+1}}</td>
                      <td>{{student.surname}}</td>
                      <td>{{student.othernames}}</td>
                      <td>{{student.dob | date}}</td>
                      <td>{{student.sex}}</td>
                      <td>{{student.grade}}</td>
                        <td>{{student.student_id}}</td>
                        <td>
                           <radial-progress-bar :diameter=45
                       :completed-steps="student.reg_progress"
                       :total-steps=100
                       :strokeWidth=8
                       :innerStrokeWidth=8
                       :startColor="'#2ECC71'"
                       :stopColor="'#2ECC71'"
                       :innerStrokeColor="'#F1F1F1'"
                       >
                           </radial-progress-bar>
                        </td>
                        <td>
                            <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Options
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <Link class="dropdown-item" href="/add-parents" :data="{id:student.id,surname:student.surname, othernames:student.othernames}">Add parents' info</Link>
                                <a class="dropdown-item" href="#">Add medical info</a>
                                <a class="dropdown-item" href="#">Assign hostel</a>
                                <a class="dropdown-item" href="#">Assign house</a>
                                <a class="dropdown-item" href="#">Assign club</a>
                                <div class="dropdown-divider"></div>
                                 <a class="dropdown-item" href="#">Add scores</a>
                                <a class="dropdown-item" href="#">Check result</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" @click.prevent="deleteStudent(student.name, student.id)" href="/delete-student" > Delete </a>
                            </div>
                            </div>
                        </td>
                    </tr>
                  
                  </tbody>
                </table>
                <Paginator :links="students.links"/>
              </div>
              <!-- /.card-body -->
            </div>
    </div>
</template>

<script>
import moment from 'moment'
import { Head } from '@inertiajs/inertia-vue'
import { Link } from '@inertiajs/inertia-vue'
import Paginator from '../../Shared/paginator.vue'
import RadialProgressBar from 'vue-radial-progress'
import { Inertia } from '@inertiajs/inertia'

export default {
    components:{
        Head,Link, Paginator, RadialProgressBar, Inertia
    },
    props:{
        students:Object
    },
    data(){
        return{
           
        }
    },
    methods:{
       deleteStudent(name,id){
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
                       axios.get('/delete-student',{params:{id:id}}).then((response)=>{
                         console.log(response.data)
                           if(response.data){
                               Inertia.reload({ only: ['students'] })
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
    filters:{
        date: function(value){
            if(value){
               return moment(String(value)).format('ll')
               //return moment(value).format("MMM Do YY")
           }
        }
    },
    mounted(){
        console.log(this.students)
    }
    
}
</script>