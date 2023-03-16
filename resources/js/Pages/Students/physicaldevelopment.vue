<template>
    <div class="container">
        <form id="physicaldev_form" @submit.prevent="saveForm">
            <table class="table table-responsive">
                <thead>
                <tr>
                        <th>S/N</th>
                        <th>Students</th>
                        <th>Initial Height</th>
                        <th>Current Height</th>
                        <th>Initial Weight</th>
                        <th>Current Weight</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(student, index) in students" :key="index">
                        <td>{{index+1}}</td>
                        <td>{{student.fullname}}</td>
                        <td>
                            <input type="text" :value="student.physicaldevelopment?student.physicaldevelopment.initial_height: ''" class="form-control" name="initial_height" placeholder="Initial height">
                        </td>
                        <td>
                            <input type="text" :value="student.physicaldevelopment?student.physicaldevelopment.current_height: ''" class="form-control" name="current_height" placeholder="Current height">
                        </td>
                        <td>
                            <input type="text" :value="student.physicaldevelopment?student.physicaldevelopment.initial_weight: ''" class="form-control" name="initial_weight" placeholder="Initial weight">
                        </td>
                        <td>
                            <input type="text" :value="student.physicaldevelopment?student.physicaldevelopment.current_weight: ''" class="form-control" name="current_weight" placeholder="Current weight">
                        </td>
                        <input type="hidden" name="studentid" :value="student.id">
                        <input type="hidden" name="id" :value="(student.physicaldevelopment)? student.physicaldevelopment.id:''">
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <input type="submit" value="Save" class="btn btn-primary float-right">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
export default {
    props: [
        'students'
    ],
    components:{
        Inertia,
    },
    data(){
        return {

        }
    },
    methods:{
        saveForm(){
            let form = $('#physicaldev_form').serializeArray();
            axios.post('/physical-development',form).then((response)=>{
               if(response.data){
                   toastr.success("Physical development added successfully!", "Success");
                    Inertia.reload({ only: ['students'] });
               }
            })
        }
    }
    
}
</script>