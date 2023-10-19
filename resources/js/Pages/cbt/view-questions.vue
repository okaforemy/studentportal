<template>
    <div>
        <div class="card">
            <div class="card-header">
                <span>Questions</span>
            </div>
            <div class="card-body">
                <div class="mt-2 col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <select name="" ref="classes" @change="getQuestion" id="" class="form-control">
                                <option value="">Select class</option>
                                <option v-for="(grade, index) in classes" :value="grade.class_name" :key="index">{{ grade.class_name }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="" ref="subject" @change="getQuestion" class="form-control" id="">
                                <option value="">Select subject</option>
                                <option v-for="(subject, index) in subjects" :value="subject.id" :key="index">{{ subject.subject }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Questions</th>
                                <th>Options</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(question, index) in questions" :key="index">
                                <td>{{ question.id+1 }}</td>
                                <td v-html="question.question"></td>
                                <td>
                                    <ol type="a">
                                        <li :class="{'font-weight-bold':question.option_a == question[question.answer_to_question] }">{{ question.option_a }}</li>
                                        <li :class="{'font-weight-bold':question.option_b == question[question.answer_to_question] }">{{ question.option_b }}</li>
                                        <li :class="{'font-weight-bold':question.option_c == question[question.answer_to_question] }">{{ question.option_c }}</li>
                                        <li :class="{'font-weight-bold':question.option_d == question[question.answer_to_question] }">{{ question.option_d }}</li>
                                        <li :class="{'font-weight-bold':question.option_e == question[question.answer_to_question] }" v-if="question.option_e">{{ question.option_e }}</li>
                                    </ol>
                                </td>
                                <td>
                                    <button @click.prevent="editQuestion(index)" class="btn btn-success btn-sm">edit</button>
                                    <button class="btn btn-danger btn-sm" @click.prevent="deleteQuestion(question.id)">delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" @submit.prevent="saveEditQuestion">
                        <div>
                            <label for="">Class</label>
                            <select name="grade" id="" required v-model="form.grade" class="form-control">
                                <option value="">select class</option>
                                <option v-for="(cls, index) in classes" :key="index" :value="cls.class_name">{{ cls.class_name }}</option>
                            </select>
                            <div v-if="errors.grade" class="text-danger">{{ errors.grade }}</div>
                        </div>
                        <div class="mt-3">
                            <label for="">Subjects</label>
                            <select name="subject" required id="" v-model="form.subject" class="form-control">
                                <option value="">select subject</option>
                                <option v-for="(subject, index) in subjects" :key="index" :value="subject.id">{{ subject.subject }}</option>
                            </select>
                            <div v-if="errors.subject" class="text-danger">{{ errors.subject }}</div>
                        </div>
                        <div class="mt-2">
                            <label for="">Question</label>
                            <ckeditor :editor="editor" v-model="form.question" :config="editorConfig"></ckeditor>
                            <div v-if="errors.question" class="text-danger">{{ errors.question }}</div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">A.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.option_a" name="option_a" required id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" v-model="form.answer" value="option_a" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">B.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.option_b" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" value="option_b" v-model="form.answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">C.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.option_c"  id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" value="option_c" v-model="form.answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">D.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.option_d" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" value="option_d" v-model="form.answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <div class="mt-3 ml-2 form-group row">
                            <label for="">E.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.option_e" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="correct_option" value="option_e" v-model="form.answer" id="" class="form-check-input ml-4 mt-3">
                            </div>
                        </div>
                        <input type="hidden" name="question_id" v-model="form.question_id">
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary">Edit question</button>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    props: [ 'classes','subjects', 'errors'],
    data(){
        return{
            editor: ClassicEditor,
                editorData: '',
                editorConfig: {
                    // The configuration of the editor.
                },
            questions:[],
            form: this.$inertia.form({
                grade: '',
                subject:'',
                question: '',
                option_a: '',
                option_b: '',
                option_c: '',
                option_d:'',
                option_e: '',
                question_id:'',
            })
        }
    },
    methods:{
        getQuestion(){
            let grade = this.$refs['classes'].value;
            let subject = this.$refs['subject'].value;
            axios.get('/get-questions',{params:{grade:grade, subject:subject}}).then((response)=>{
                this.questions = response.data
            })
        },

        editQuestion(index){
            
            let question = this.questions[index];
            this.form.grade = question.grade;
            this.form.subject = question.subject
            this.form.option_a = question.option_a;
            this.form.option_b = question.option_b;
            this.form.option_c = question.option_c;
            this.form.option_d = question.option_d;
            this.form.option_e = question.option_e;
            this.form.question = question.question;
            this.form.answer = question.answer_to_question;
            this.form.question_id = question.id;
            
            $('#exampleModal').modal('show');
        },

        saveEditQuestion(){
            this.$inertia.post('/add-question', this.form,{onSuccess:()=>{  
                this.form.question = '';
                this.form.option_a = '';
                this.form.option_b = '';
                this.form.option_c = '';
                this.form.option_d = ''; 
                this.form.option_e = '';
                this.form.answer = '';
                   toastr.success('question updated successfully!', 'Success')
                   $('#exampleModal').modal('hide')
                   this.getQuestion()
            }}).then((response)=>{
                
            })
        },

        deleteQuestion(ind){
            axios.get('/delete-question',{params:{id:ind}}).then((response)=>{
                this.getQuestion();
            })
        }
    }
}
</script>