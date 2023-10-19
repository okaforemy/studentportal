<template>
    <div class="col-md-12 pt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span>Add students</span>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div>
                                <label for="">First Name</label>
                                <input type="text" required class="form-control" name="firstname" v-model="form.firstname" id="">
                            </div>
                            <div class="mt-4">
                                <label for="">Last Name</label>
                                <input type="text" required class="form-control" name="lastname" v-model="form.lastname" id="">
                            </div>
                            <div class="mt-4">
                                <label for="">grade</label>
                                <select name="" v-model="form.grade" id="" required class="custom-select">
                                    <option v-for="(gr, index) in classes" :value="gr.class_name" :key="index">{{ gr.class_name }}</option>
                                </select>
                            </div>
                            <div class="mt-4 text-center">
                                <button class="btn btn-primary" @click.prevent="addStudent">Add Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <span>Recently added students</span>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li v-for="(student, index) in students" :key="index">{{ student.lastname+" "+student.firstname }}
                                <button class="btn ml-2 btn-sm" @click.prevent="deleteStudent(student.id)"><i class="fas fa-trash text-danger"></i></button>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['classes','students'],
    data(){
        return{
            form: this.$inertia.form({
                 grade:'',
                firstname:'',
                lastname: '',
            })
        }
    },
    methods:{
        addStudent(){
            this.$inertia.post('/add-cbt-student',this.form).then((response)=>{
                    toastr.success('user added successfully!', 'Success')
                    this.grade= '';
                    this.firstname = '';
                    this.lastname = '';
            })
        },
        deleteStudent(id){
            this.$inertia.get('/delete-cbt-student',{id:id}).then((response)=>{
                
            })
        }
    }
}
</script>