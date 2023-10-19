<template>
    <div class="pt-3 row">
        <Head title="Add Question" />
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Question</h3>
                    <div class="col-md-">
                        <a href="" class="float-right"><i class="fas fa-plus"></i></i></a>
                    </div>
                </div>
                <div class="card-body">
                  <div class="add-form">
                    <form action="" @submit.prevent="saveQuestion">
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
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary">Add question</button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <ol>
                        <li v-for="(question, index) in questions" :key="index" v-html="question.question"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { Head } from "@inertiajs/inertia-vue";

export default {
    props:['subjects','classes','errors','questions'],
    components: { Head},
    data(){
        return {
                editor: ClassicEditor,
                editorData: '',
                editorConfig: {
                    // The configuration of the editor.
                },
                form: this.$inertia.form({
                   grade: '',
                   subject:'',
                   question: '',
                   option_a:'',
                   option_b:'',
                   option_c:'',
                   option_d:'',
                   option_e:'',
                    answer: ''
                })
        };
    },
    
    methods:{
        saveQuestion(){
            this.$inertia.post('/add-question', this.form,{onSuccess:()=>{  
                this.form.question = '';
                this.form.option_a = '';
                this.form.option_b = '';
                this.form.option_c = '';
                this.form.option_d = ''; 
                this.form.option_e = '';
                this.form.answer = '';
                   toastr.success('questions added successfully!', 'Success')
            }}).then((response)=>{
               
            })
        }
    }

}
</script>