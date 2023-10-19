<template>
    <div>
       <div v-if="total == 0">
            <div class="col-md-8 pt-4">
                <h4>Welcome to purplins' School CBT Exam/Text, <span class="font-weight-bold">{{ fullname }}</span>, Please click the button below to start the test.</h4>
            </div>
            <div class="text-center pt-4">
                <button class="btn  btn-success" @click.prevent="startExam" ref="start_btn">Start Exam/Test</button>
            </div>
       </div>
        <div class="pt-3">
            <div class="col-md-10 px-4">
                <div class="mt-2">
                            <label for="">Question for {{ fullname }}</label>
                            <div class="card">
                                <div class="card-body">
                                    <span>{{ index+1 }}.</span><h5 v-html="question.question"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">A.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="question.option_a" name="option_a" required id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" @click="answerQuestion" v-model="question.your_answer" value="option_a" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">B.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="question.option_b" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" @click="answerQuestion" value="option_b" v-model="question.your_answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">C.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="question.option_c"  id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" @click="answerQuestion" name="correct_option" value="option_c" v-model="question.your_answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">D.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="question.option_d" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" @click="answerQuestion" name="correct_option" value="option_d" v-model="question.your_answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">E.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="question.option_e" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" value="option_e" v-model="question.your_answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                            <input type="hidden" name="" ref="question_id" :value="question.id">
                        </div>
                        <div class="mt-3 text-center pb-4">
                            <button class="btn btn-secondary mr-3" @click.prevent="previous" v-show="index > 0">Previous</button>
                            <button class="btn btn-success" @click.prevent="next" v-if="is_next">Next</button>
                            <button class="btn btn-success" @click="submitQuestion" v-if="is_submit">Submit</button>
                        </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['fullname','student_id'],
    data(){
        return{
            questions: [],
            question:[],
            index:0,
            total:0,
        }
    },
    methods:{
        startExam(){
            this.$refs['start_btn'].textContent = "Please wait..."
            this.getQuestions();
        },

        getQuestions(){
            axios.get('/prepare-exam',{params:{student_id: this.student_id}}).then((response)=>{
                console.log(response.data);
                this.questions = response.data;
                this.total = this.questions.length;
                this.question = this.questions[0];
                this.$refs['start_btn'].textContent = "Start Exam/Test"
            })
        },

        next(){
            if(this.index <= this.total){
                this.index++
                this.question = this.questions[this.index];
            }
        },

        previous(){
            this.index--
            this.question = this.questions[this.index];
        },

        answerQuestion(){
            let question_id = this.$refs['question_id'].value;
            let answer = $('input[name="correct_option"]:checked').val()
            axios.post('/answer-question',{question_id: question_id, your_answer: answer}).then((response)=>{
                console.log(response.data);
            })
        },
        submitQuestion(){
            window.location.href = '/cbt-result';
        }
    },
    computed: {
        is_next() {
            return (this.index+1) < this.total;
        },
        is_submit() {
            return (this.index +1) === this.total;
        }
    },
    created(){
        this.getQuestions()
    }
}
</script>