<style scoped>
    .fixed{
        position: fixed;
    }
</style>
<template>
    <div class="pt-3 px-4 py-4 col-md-10">
        <form action="" id="holidayForm">
            
            <table class="table table-strip">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Names</th>
                        <!-- <th>
                            <select class="">
                                <option value="">Select subject</option>
                                <option :value="subj.subject" v-for="(subj, ind) in students[1].subjects" :key="ind">{{ subj.subject }}</option>
                            </select> 
                            <input type="number" class="" placeholder="max">
                        </th> -->
                        <th ref="subject1" :data-value="students[0].subjects[0].subject">{{ students[0].subjects[0].subject }} (40)</th>
                        <th ref="subject2" :data-value="students[0].subjects[1].subject">{{ students[0].subjects[1].subject }} (30)</th>
                        <th ref="subject3" :data-value="students[0].subjects[2].subject">{{ students[0].subjects[2].subject }} (30)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(student, index) in allstudents" :key="index">
                        <td>{{ index+1 }}</td>
                        <td>{{ student.surname+' '+student.othernames }}</td>
                        <td><input type="number" ref="score1"  @keyup="validate($event,40)" name="score1" class="form-control"></td>
                        <td><input type="number" ref="score2" @keyup="validate($event,30)" name="score2" class="form-control"></td>
                        <td><input type="number" ref="score3" @keyup="validate($event,30)" name="score3" class="form-control"></td>
                        <input type="hidden" ref="student_id" name="student_id" :value="student.id">
                    </tr>
                </tbody>
            </table>
            <div class="text-right">
                <button class="btn btn-primary my-2" @click.prevent="saveHolidayAssessment">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props:['students'],
    data(){
        return{
            allstudents: this.students
        }
    },
    methods:{
        saveHolidayAssessment(){
           
            let score1 = this.$refs['score1'];
            let score2 = this.$refs['score2'];
            let score3 = this.$refs['score3'];
            let student_id = this.$refs['student_id'];
            let subject1 = this.$refs['subject1'].getAttribute('data-value');
            let subject2 = this.$refs['subject2'].getAttribute('data-value');
            let subject3 = this.$refs['subject3'].getAttribute('data-value');
           
            let data = []
            let j =1;
            for(let i=0; i < score1.length; i++){
               
               for(let j =1; j <=3; j++){

                let score = j==1?score1: j==2? score2: score3
                let subject =j==1? subject1: j==2? subject2: subject3;

                let val ={
                    score: score[i].value,
                    subject: subject,
                    student_id: student_id[i].value,
                    term: 'second',
                    session: '2021/2022'
                }
                data.push(val)
               }
              
            }
            axios.post('/holiday-assessment',data).then((response)=>{
                console.log(response)
            })
        },
        validate(event,val){
            if(event.target.value > val){
                toastr.error('Maximum number entered!', 'Error')
                event.target.value=""
            }
        },
        isNumber(evt){
            alert(evt.which)
            const charcode = evt.which? evt.which: evt.keyCode;
            if(charcode > 31 && (charcode < 48 || charcode > 57) && charcode !=46){
                alert(evt.which)
                evt.preventDefault();
            }
        },
    },

}
</script>