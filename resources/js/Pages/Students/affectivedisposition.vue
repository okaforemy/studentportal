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
    .active{
        color: #fff !important;
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
                            <h3 class="card-title">Affective disposition </h3>
                        </div>
                        <div class="card-body">
                            <form id="affective">
                                <table class="table table-sm affective_disp">
                                    <thead>
                                        <tr>
                                            <th>Affective Disposition</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody v-if="studentid && section==='primary'">
                                        <tr v-for="(pa,index) in primary_affective" :key="index">
                                            <td>{{pa}}</td>
                                            <td>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-success" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required="" value="1" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)">Very Good</label>

                                                    <label class="btn btn-outline-warning" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()"  required="" value="2" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)">Good</label>

                                                    <label class="btn btn-outline-danger" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required=""  
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)" value="3" class="custom-radio">Satisfactory
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                     <tbody v-if="studentid && section==='nursery'">
                                        <tr v-for="(pa,index) in nursery_affective" :key="index">
                                            <td>{{pa}}</td>
                                            <td>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-success" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required="" value="1" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)">Very Good</label>

                                                    <label class="btn btn-outline-warning" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()"  required="" value="2" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)">Good</label>

                                                    <label class="btn btn-outline-danger" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required=""  
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)" value="3" class="custom-radio">Satisfactory
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tbody v-if="studentid && (section==='junior_secondary' || section === 'senior_secondary')">
                                        <tr v-for="(pa,index) in secondary_affective" :key="index">
                                            <td>{{pa}}</td>
                                            <td>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-success" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required="" value="1" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)">Very Good</label>

                                                    <label class="btn btn-outline-warning" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()"  required="" value="2" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)">Good</label>

                                                    <label class="btn btn-outline-danger" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required=""  
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)" value="3" class="custom-radio">Satisfactory
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tbody v-if="studentid && section==='pre_nursery'">
                                        <tr v-for="(pa,index) in pre_nursery_affective" :key="index">
                                            <td>{{pa}}</td>
                                            <td>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-success" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required="" value="1" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==1)">Very Good</label>

                                                    <label class="btn btn-outline-warning" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()"  required="" value="2" class="custom-radio" 
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==2)">Good</label>

                                                    <label class="btn btn-outline-danger" :class="{'active': (affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)}">
                                                    <input type="radio" :name="pa.split(' ')[pa.split(' ').length-1].toLowerCase()" required=""  
                                                        :checked="(affective[pa.split(' ')[pa.split(' ').length-1].toLowerCase()]==3)" value="3" class="custom-radio">Satisfactory
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="2">
                                            <input type="hidden" name="studentid" :value="studentid">
                                            <input type="hidden" name="id" :value="affective.id">
                                            <input type="hidden" name="section" :value="section">
                                            <button type="submit" @click="save" id="save" class="btn btn-primary float-right">Save</button>
                                        </td>
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
                                           <Link href="/affective-disposition" :data='{studentid:student.id, arm:student.arm, grade: grade, currentStudent: index, section:section}'>{{student.fullname}}</Link>
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
import { Link } from '@inertiajs/inertia-vue'
export default {
    components:{
        Link
    },
    props:{
        students: Object,
        page: Number,
        grade: String,
        selectedstudent: String,
        studentid: Number,
        affective: Object,
        section: String,
    },
    data(){
        return{
            primary_affective:[
                'Mental alertness',
                'Assumes responsibility',
                'Takes care of personal appearance',
                'Takes care of books and property',
                'Attentive and works independently',
                'Does neat work',
                'Honesty',
                'Relationship with peers',
                'Leadership',
                'Politeness',
                'Confidence',
                'Speaking',
            ],
            pre_nursery_affective:[
                'Mental alertness',
                'Takes care of personal appearance',
                'Attentive and works independently',
                'Does neat work',
                'Honesty',
                'Relationship with peers',
                'Leadership',
                'Politeness',
                'Confidence',
            ],
            nursery_affective:[
                'Mental alertness',
                'Assumes responsibility',
                'Takes care of personal appearance',
                'Takes care of book and property',
                'Attentive and works independently',
                'Does neat work',
                'Honesty',
                'Team work and cooperation',
                'Politeness',
                'Confidence',
                'Speaking',
            ],
            secondary_affective:[
                'Mental alertness',
                'Assumes responsibility',
                'Takes care of personal appearance',
                'Takes care of books and property',
                'Attentive and works independently',
                'Does neat work',
                'Honesty',
                'Team work and cooperation',
                'Politeness',
                'Confidence',
                'Speaking',
            ],
            student:{},
        }
    },
    methods:{
        save(event){
            event.preventDefault();
            let form = $('#affective').serialize();
        
            axios.post('/affective-disposition',form).then((response)=>{
                console.log(response.data)
                toastr.success("Successfully saved", 'Success!')
            }).catch((error)=>{
                if(error.response){
                    let errors = error.response.data.errors
                    for(const err in errors){
                        toastr.warning(errors[err], 'Error!')
                    }
                }
            })
        },
        fillStudent(student){
            this.student=student;
        }
    }
}
</script>