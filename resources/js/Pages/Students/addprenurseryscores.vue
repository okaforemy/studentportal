<style scoped>
    .overflow{
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: normal;
    }
</style>
<template>
    <div>
        <Head title="add student scores" />
        <div class="pt-3">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add scores for <span class="text-bold">{{student.fullname}}</span> in {{student.grade}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="" id="scores" @submit.prevent="saveStudentScores">
                               <table class="table table-sm mt-4" v-for="(subject, index) in subjects" :key="index">
                                <thead>
                                    <tr>
                                        <th>{{ index }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(subj, ind) in subject" :key="ind">
                                        <td>{{ subj.subject}}</td>
                                        <td>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-primary btn-sm text-white" :class="{active:subj.value==2}">
                                                    <input type="radio" :checked="subj.value==2" ref="mastered" :name="'scores'+(subj.id+1)" value="2"> Mastered Concepts
                                                </label>
                                                <label class="btn btn-primary btn-sm text-white" :class="{active: subj.value==1}">
                                                    <input type="radio" ref="needs" :checked="subj.value==1" :name="'scores'+(subj.id+1)" value="1"> NEEDs Work
                                                </label>
                                            </div>
                                            <input type="hidden" ref="subject" name="subject" :value="subj.subject">
                                            <input type="hidden" ref="category" name="category" :value="index">
                                            <input type="hidden" ref="student_id" name="student_id" :value="student.id">
                                            <input type="hidden" ref="id" :value="subj.pre_nursery_exams_id? subj.pre_nursery_exams_id:''">
                                        </td>
                                    </tr>
                                </tbody>
                               </table>
                               <button class="btn btn-primary float-right" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Students</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-sm-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr v-for="(student,index) in students.data" :key="index" :class="{'table-success': index==selectedstudent}">
                                       <td>{{(page != null)? index+1+page: index+1}}</td>
                                       <td class="overflow">
                                           <Link href="/students-exam-scores" :data='{studentid:student.id, arm:student.arm, grade: grade, page:pagination_page, currentStudent: index, section:section}'>{{student.fullname}}</Link>
                                        </td>
                                   </tr>
                                </tbody>
                            </table>
                            <nav aria-label="..." class="ml-4 mt-4" >
                                <ul class="pagination">
                                    <li class="page-item" :class="{active : link.active, disabled : link.url ==null }" v-for="(link,index) in students.links" :key="index">
                                    <Link  :href="link.url"  preserve-scroll :data="{newpage:true}"  v-html="link.label" class="page-link" />
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue'
export default {
    components:{
        Inertia, Link
    },
    props:['students', 'student','selectedstudent','page','currentpage','grade','section','subjects'],
    
    data(){
        return{
            pagination_page: (this.currentpage)? this.currentpage:1,
        }
    },
    methods: {
        saveStudentScores(){
           //let scores = $('#scores').serializeArray();
           let needs = this.$refs['needs'];
           let mastered = this.$refs['mastered'];
           let subject = this.$refs['subject'];
           let category = this.$refs['category'];
           let student_id = this.$refs['student_id'];
           let id = this.$refs['id'];
           
            let scores = [];

           for(let i=0; i < needs.length; i++){
            //console.log(needs[i].checked)
                if(needs[i].checked){
                    let arr ={
                        value: 1,
                        subject: subject[i].value,
                        category: category[i].value,
                        student_id: student_id[i].value,
                        session: '2020/2021',
                        term:'second term',
                        id: id[i].value
                    }
                    scores.push(arr)
                } 
           }

           for(let i=0; i < mastered.length; i++){
            //console.log(needs[i].checked)
            if(mastered[i].checked){
                    let arr ={
                        value: 2,
                        subject: subject[i].value,
                        category: category[i].value,
                        student_id: student_id[i].value,
                        session: '2020/2021',
                        term:'second term',
                        id: id[i].value
                    }
                    scores.push(arr)
                }
           }
          let data = {
            data: scores,
            section: this.section,
            grade: this.grade,
            // student_id: this.student.id
          }
          axios.post('/students-exam-scores',data).then((response)=>{
            toastr.success('Saved successfully!', 'Success')
          })
        }
    },
}
</script>