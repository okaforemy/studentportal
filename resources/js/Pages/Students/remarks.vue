<style scoped>
    .form-control, .custom-select {
        height: calc(4.5rem + 2px) !important;
        font-size: 1rem !important;
    }
</style>

<template>
    <div>
        <h4 class="py-3 text-center">Student's Remarks for {{ grade }}</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Students</th>
                    <th>HT remarks</th>
                    <th>CT remarks</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student, index) in students" :key="index">
                    <td tabindex="-1">{{ index+1 }}</td>
                    <td tabindex="-1">{{ student.surname+" "+student.othernames }}</td>
                    <td><textarea class="form-control" :ref="'HT_remarks'+index" :class="'HT_remarks'+index" rows="3">{{ (student.remarks.length > 0)?student.remarks[0].HT_remarks: '' }}</textarea></td>
                    <td><textarea class="form-control" :ref="'CT_remarks'+index" :class="'CT_remarks'+index" rows="3">{{ (student.remarks.length > 0)?student.remarks[0].CT_remarks: '' }}</textarea></td>
                    <td tabindex="-1">
                        <input type="hidden" :ref="'student_id'+index" :value="student.id">
                        <input type="hidden" :ref="'id'+index" :value="(student.remarks.length > 0)?student.remarks[0].id:''">
                        <button tabindex="-1" class="btn btn-primary btn-sm" @click="saveRemarks(index)">save</button>
                    </td>
                </tr>   
            </tbody>
        </table>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
export default {
    props: ['students', 'grade'],

    data(){
        return{
            HTremark: '',
            CTremark: '',
            remark_by_HT:false,
            remark_by_CT: false,
            form:{

            }
        }
    },

    methods: {
        saveRemarks(index){
          let HT_remarks = this.$refs['HT_remarks'+index][0].value;
          let CT_remarks = this.$refs['CT_remarks'+index][0].value;
          let student_id = this.$refs['student_id'+index][0].value;
          let id = this.$refs['id'+index][0].value;
          let data = {
            HT_remarks: HT_remarks,
            CT_remarks: CT_remarks,
            session: '2022/2023',
            term: 'first term',
            student_id: student_id,
            id: id
          }
          axios.post('/remarks',data).then((response)=>{
            if(response.data.success){
                toastr.success("Remarks added successfully!", "Success");
            }
          })
        }
    },

    created(){

    }
}
</script>