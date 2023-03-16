<template>
    <div class="pt-4">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{grade+", "+arm}} Class List</h3>

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
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(student,index) in students.data" :key="index">
                      <td>{{index+1+parseInt(page)}}</td>
                      <td>{{student.surname}}</td>
                      <td>{{student.othernames}}</td>
                      <td>{{student.dob | date}}</td>
                      <td>{{student.sex}}</td>
                      <td>{{student.grade}}</td>
                        <td>{{student.student_id}}</td>
                        
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
import { Inertia } from '@inertiajs/inertia'

export default {
    components:{
        Head,Link, Paginator, Inertia
    },
    props:{
        students: Object,
        grade: String,
        page: String,
        arm: String,
    }
    
}
</script>