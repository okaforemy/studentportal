<style scoped>
    .page-item:nth-child(1) {
        display: none;
    }
    .page-item:last-child{
        display: none;
    }

    @media print {
        .no-print {
            display: none;
        }
    }

</style>
<template>
    <div class="col-md-12">
        <div class="mx-auto col-md-5 py-3 no-print">
            <select class="form-control" @change="getResult" ref="student_id">
                <option value="">select pupil</option>
                <option :value="student.id" v-for="(student, ind) in students" :key="ind">{{ student.surname+" "+student.othernames }}</option>
            </select>
        </div>
        <div>
            <div class="col-md-12 text-center mt-4">
                <img src="/images/midterm.png" width="50%" alt="" class="result_logo">
            </div>
        </div>
        <div class="text-center my-4">
            <img src="" height="70px" alt="student" class="img-thumbnail">
        </div>
        <div>
            <p class="text-center">Holiday Assessment/Midterm Progress Report for <span class="term"></span> <span class="session"></span> Session.</p>
            <p class="text-center">
                <span class=" font-weight-bold"> PUPIL'S NAME:</span> 
                <span class="std_name mr-5">{{ result.length !=0 ? result.surname+" "+result.othernames:'' }}</span>
                <!-- <span class=" font-weight-bold">	DATE:</span> 
                <span class="date" style="text-transform: uppercase;">May 11, 2023, 12:56 pm</span> -->
            </p>
            <p class="text-center">
                <span class=" font-weight-bold">CLASS:</span> 
                <span class="clas mr-5">{{result.grade}}</span>
                <span class=" font-weight-bold">	SCHOOL RESUMES:</span> 
                <span class="resume">Monday, 17th April, 2023</span>
            </p>

            <table class="table table-bordered table-sm primary2">
			<thead>
				<tr>
					<th>SUBJECTS</th>
					<th>MARKS OBTAINABLE</th>
					<th>MARKS OBTAINED</th>
				</tr>
			</thead>
			<tbody class="midterm-td">
                <tr v-for="(primary, ind) in result.primary_exam" :key="ind">
                    <td style="text-transform: uppercase;">{{primary.subject}}</td> 
                    <td class="text-center">100</td>
                    <td class="text-center">{{(primary.first_ca /20) * 100}}</td>
                </tr>
                <tr>
                        <td class="text-center font-weight-bold">CLASS PERCENTAGE</td>
                        <td></td>
                        <td class="text-center font-weight-bold">{{ class_avg }}</td>
                    </tr>
                    <tr>
                        <td class="text-center font-weight-bold">PUPIL'S PERCENTAGE</td>
                        <td></td>
                        <td class="text-center font-weight-bold">{{ percentage }}</td>
                    </tr>
                    <tr>
                        <td class="text-center font-weight-bold">GRADE</td>
                        <td></td>
                        <td class="text-center font-weight-bold">A+</td>
                    </tr>
            </tbody>
		</table>

        <table class="table table-bordered table-sm primary">
			<tbody><tr>
                    <td colspan="2" class="font-weight-bold">HOLIDAY ASSESSMENT REPORT</td>
                </tr>
                <tr>
                    <td class="subject1" v-for="(holiday,ind) in result.holiday_assessment " :key="ind">{{ holiday.subject }}</td>
                </tr>
                <tr>
                    <td v-for="(holiday,ind) in result.holiday_assessment " :key="ind">{{ holiday.score }}</td>
                </tr>
		    </tbody>
        </table>

        <p><bold></bold>Class Teacher's Comment: <span class="ct_remarks">Derick is an impressive learner. He is making steady progress in all his subjects. Howbeit, he needs a little push in his Creative Arts. Happy Easter!</span></p>

        <p>Class Teacher's Sign:...............................     Head Teacher's Sign: ....................................</p>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    props:['students'],
    components:{Link},
    data(){
        return{
            result: [],
            student_id:"",
            percentage: 0,
            class_avg: 0,
        }
    },
    methods:{
        getResult(){
            this.student_id = this.$refs.student_id.value;
            axios.get('/get-midterm-result',{params:{student_id:this.student_id}}).then((response)=>{
                this.result = response.data
                this.calculatePercentage();
                this.class_avg = ((this.result.class_avg/20) *100).toFixed(2)
            })
        },
        calculatePercentage(){
            let total = 0;
            for(let exam of this.result.primary_exam){
                total += Number((exam.first_ca/20) * 100)
                console.log(Number(exam.first_ca))
            }
           this.percentage = (total/this.result.primary_exam.length).toFixed(2)
        }
    }
}
</script>