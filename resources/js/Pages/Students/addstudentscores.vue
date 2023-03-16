<style scoped>
    .page-item:nth-child(1) {
        display: none;
    }
    .page-item:last-child{
        display: none;
    }
    .table th {
        border-top: none;
    }
    .form-control, .custom-select {
        height: calc(2.2rem + 2px) !important;
        font-size: 1.0rem !important;
    }
</style>

<template>
    <div>
        <Head title="add student" />
        <div class="pt-3">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add scores for <span class="text-bold">{{student.fullname}}</span> in {{student.grade}}</h3>
                        </div>
                        <div class="card-body">
                            <form action="" id="scores" @submit.prevent="saveStudentScores">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Subjects</th>
                                            <th>1st CAT (20)</th>
                                            <th>2nd CAT (20)</th>
                                            <th>Exam (60)</th>
                                            <th>Total</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="subjects.length > 0">
                                        <tr v-for="(subj, index) in subjects" :key="index">
                                            <td>
                                                {{subj.subject}}
                                                <input type="hidden" name="subject" :value="subj.subject">
                                                <input type="hidden" name="id" :value="subj.id">
                                            </td>
                                            <td>
                                                <input type="text" :value="subj.first_ca" @keypress="isNumber" @blur="total($event,20,index)" @keyup="total($event,20,index)" name="first_ca" :id="'first_ca_'+index" class="form-control" placeholder="first CA">
                                            </td>
                                            <td>
                                                <input type="text" :value="subj.second_ca" @keypress="isNumber" @blur="total($event,20,index)" @keyup="total($event,20,index)" name="second_ca" :id="'second_ca_'+index" class="form-control" placeholder="second CA">
                                            </td>
                                            <td>
                                                <input type="text" :value="subj.exam" @keypress="isNumber" @blur="total($event,60,index)" @keyup="total($event,60,index)" name="exam" :id="'exam_'+index" class="form-control" placeholder="exam">
                                            </td>
                                            <td>
                                                <input type="text" :value="subj.total" name="total" :id="'total_'+index" readonly tabstop="false" tabindex="2" class="form-control" placeholder="total">
                                            </td>
                                            <td>
                                                <input type="text" :value="subj.remark" name="remark" :id="'remark_'+index" readonly tabstop="false" tabindex="3" class="form-control" placeholder="remark">
                                            </td>
                                                <input type="hidden" name="arm" :value="student.arm">
                                                <input type="hidden" name="grade" :value="grade">
                                                <input type="hidden" name="student_id" :value="student.id">
                                                <input type="hidden" name="term" :value="term">
                                                <input type="hidden" name="session" :value="session">
                                                
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                       <tr>
                                           <td colspan="6">
                                                <button class="btn btn-primary float-right" type="submit">Save</button>
                                           </td>
                                       </tr>
                                    </tfoot>
                                </table>
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
                                       <td>
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
import Paginator from '../../Shared/paginator.vue'
import { Link } from '@inertiajs/inertia-vue'
import { parse } from '@fortawesome/fontawesome-svg-core'
import { Inertia } from '@inertiajs/inertia'

export default {
    props:{
        students: Object,
        page:Number,
        student: Object,
        grade: String,
        currentpage: String,
        selectedstudent: Number,
        subjects: Array,
        primaryexam: Object,
        section: String,
    },
    components:{
        Paginator, Link, Inertia
    },
    data(){
        return{
            arm:null,
            studentid:null,
            term:"second term",
            session:"2021/2022",
            pagination_page: (this.currentpage)? this.currentpage:1,
        }
    },
    methods:{
        saveStudentScores(){
            let params = new URL(location.href).searchParams;
            let studentid = params.get('studentid');
            let grade = params.get('grade');
            let arm = params.get('arm');
            this.grade=grade;
            this.arm=arm;
            this.studentid = studentid;
            let scores = $('#scores').serializeArray();
            let data = {
                data:scores,
                grade:this.grade, 
                page: this.currentpage, 
                currentStudent:this.selectedstudent,
                student_id: this.studentid,
                arm: this.arm
                }
           
            axios.post('/students-exam-scores',data).then((response)=>{
                toastr.success('Saved successfully!', 'Success')
                Inertia.reload({ only: ['students','student','subjects'] })
            })
        },
        isNumber(evt){
            const charcode = evt.which? evt.which: evt.keyCode;
            if(charcode > 31 && (charcode < 48 || charcode > 57) && charcode !=46){
                evt.preventDefault();
            }
        },
        total(evt,max,index){
            let val = evt.target.value;
            if(val > max){
                toastr.error('Maximum number entered!', 'Error')
                evt.target.value="";
               // return true;
            }
            let first_ca =  $('#first_ca_'+index).val();
            let second_ca = $('#second_ca_'+index).val();
            let exam = $('#exam_'+index).val();
            first_ca = first_ca!=""? parseFloat(first_ca) : 0;
            second_ca = second_ca !=""? parseFloat(second_ca) : 0;
            exam = exam !=""? parseFloat(exam) : 0;
            let total = first_ca + second_ca + exam;
            $('#total_'+index).val(total)
            
            let remark = ""
            if(total >= 90){
                remark = "A+"
            }else if(total <=89.98 && total >=79.99){
                remark = "A"
            }else if(total <= 79.98 && total >= 69.99){
                remark = "B+"
            }else if(total <=69.98 && total >=59.99){
                remark = "B"
            }else if(total <=59.98 && total >= 49.99){
               remark = "C"
            }else if(total <=49.98 && total >= 39.99){
                remark = "D"
            }else if(total <= 39.98){
                remark = "E"
            }
            
            $('#remark_'+index).val(remark);
        },

    }
}
</script>