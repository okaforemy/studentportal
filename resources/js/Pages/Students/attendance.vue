<template>
    <div class="container">
        <h4 class="text-center pt-3 pb-3">{{grade}} Attendance Summaries</h4>
       <form id="attendance_form" @submit.prevent="saveForm">
            <table class="table table-responsive pt-3">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Students</th>
                        <th>No of times school opened</th>
                        <th>No of times present</th>
                        <th>No of times absent</th>
                        <th>No of times late</th>
                        <th>No of times absent for drills</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="(student,index) in students" :key="index">
                    <td>{{index+1}}</td>
                    <td>{{student.fullname}}</td>
                    <td>
                        <input type="text" name="no_of_times_school_opened" :value="(student.attendance)? student.attendance.no_of_times_school_opened:''" class="form-control" placeholder="No of times school opened">
                    </td>
                    <td>
                        <input type="text" name="no_of_times_present" :value="(student.attendance)? student.attendance.no_of_times_present:''" class="form-control" placeholder="No of times present">
                    </td>
                    <td>
                        <input type="text" name="no_of_times_absent" :value="(student.attendance)? student.attendance.no_of_times_absent:''" class="form-control" placeholder="No of times absent">
                    </td>
                    <td>
                        <input type="text" name="no_of_times_late" :value="(student.attendance)? student.attendance.no_of_times_late:''" class="form-control" placeholder="No of times late">
                    </td>
                    <td>
                        <input type="text" name="no_of_times_absent_from_drills" :value="(student.attendance)? student.attendance.no_of_times_absent_from_drills:''" class="form-control" placeholder="No of times absent from drills">
                    </td>
                    <input type="hidden" name="studentid" :value="student.id">
                    <input type="hidden" name="id" :value="(student.attendance)? student.attendance.id:''">
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7"><input type="submit" value="Save" class="btn btn-primary float-right"></td>
                    </tr>
                </tfoot>
            </table>
       </form>
    </div>
</template>

<script>
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

export default {
    props:['students','grade'],
    components:{
        Inertia
    },
    
    data(){
        return{

        }
    },
    methods: {
        saveForm(){
            let form = $('#attendance_form').serializeArray();
            axios.post('/attendance',form).then((response)=>{
                toastr.success("attendance added successfully!", "Success");
                Inertia.reload({ only: ['students'] });
            })
        }
    }
}
</script>