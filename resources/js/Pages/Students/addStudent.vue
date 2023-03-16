<style scoped>
    .hide{
        display: none;
    }
    .show{
        display: block;
    }
</style>
<template>
    <div>
        <Head title="add student" />
        <div class="pt-3">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add student</h3>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div class="row">
                                    <div class="col-md-6 pt-sm-3 pt-md-0">
                                        <label for="surname"
                                            >Surname <Required
                                        /></label>
                                        <input
                                            type="text"
                                            v-model="form.surname"
                                            required
                                            name="surname"
                                            id="surname"
                                            class="form-control"
                                            placeholder="surname"
                                        />
                                        <div
                                            v-if="errors.surname"
                                            class="text-danger"
                                        >
                                            {{ errors.surname }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 pt-sm-3 pt-md-0">
                                        <label for="other_names"
                                            >Other names <Required
                                        /></label>
                                        <input
                                            type="text"
                                            v-model="form.othernames"
                                            name=""
                                            id="other_names"
                                            class="form-control"
                                            placeholder="other names"
                                        />
                                        <div
                                            v-if="errors.othernames"
                                            class="text-danger"
                                        >
                                            {{ errors.othernames }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pt-sm-3 pt-md-4">
                                        <label for="dob"
                                            >Date of birth <Required
                                        /></label>
                                        <input
                                            type="date"
                                            id="dob"
                                            v-model="form.dob"
                                            class="form-control"
                                        />
                                        <div
                                            v-if="errors.dob"
                                            class="text-danger"
                                        >
                                            {{ errors.dob }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 pt-sm-3 pt-md-4">
                                        <label for="sex"
                                            >Sex <Required
                                        /></label>
                                        <select
                                            name=""
                                            v-model="form.sex"
                                            id="sex"
                                            class="custom-select"
                                        >
                                            <option value="">Choose sex</option>
                                            <option value="male">Male</option>
                                            <option value="female">
                                                Female
                                            </option>
                                        </select>
                                        <div
                                            v-if="errors.sex"
                                            class="text-danger"
                                        >
                                            {{ errors.sex }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pt-sm-3 pt-md-4">
                                        <label for="student_id"
                                            >Student ID <Required
                                        /></label>
                                        <input
                                            type="text"
                                            v-model="form.student_id"
                                            class="form-control"
                                            id="student_id"
                                            placeholder="Student's ID"
                                        />
                                        <div
                                            v-if="errors.student_id"
                                            class="text-danger"
                                        >
                                            {{ errors.student_id }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 pt-sm-3 pt-md-4">
                                        <label for="grade">Grade</label>
                                        <select
                                            @change="checkArmExistence(form.grade)"
                                            name="grade"
                                            v-model="form.grade"
                                            id="grade"
                                            class="custom-select"
                                        >
                                            <option value="">
                                                Choose Grade (Class)
                                            </option>
                                            <option
                                                v-for="(clas, index) in classes"
                                                :key="index"
                                                :value="clas.id"
                                            >
                                                {{ clas.class_name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-6 pt-sm-3 pt-md-4" v-if="arms.length > 0">
                                            <label for="arms">Arms</label>
                                             <select v-model="form.arm" class="custom-select" id="arms">
                                                 <option value="">Select arm</option>
                                                <option v-for="(arm,index) in arms" :key="index" :value="arm.arm_name">
                                                    {{arm.arm_name}}
                                                </option>
                                            </select>
                                        </div>
                                </div>
                                <div class="row pt-4 pb-3">
                                    <div class="col-md-12 text-center">
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="btn btn-primary mb-1 pl-3 pr-3"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recently added</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-sm-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Full Name</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            recent, index
                                        ) in recent_students"
                                        :key="recent.id"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <Link>{{
                                                recent.surname +
                                                " " +
                                                recent.othernames
                                            }}</Link>
                                        </td>
                                        <!-- <td>{{ recent.created_at | date }}</td> -->
                                        <td>{{ recent.grade }} {{ (recent.arm===null)?'':recent.arm }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";
import Required from "../../Shared/Required";
import { Link } from "@inertiajs/inertia-vue";
import moment from "moment";

export default {
    props: {
        errors: Object,
        classes: Array,
    },

    components: {
        Head,
        Required,
        Link,
    },
    data() {
        return {
            form: this.$inertia.form({
                surname: null,
                othernames: null,
                dob: null,
                sex: "",
                student_id: null,
                grade: "",
                reg_progress: 50,
                arm:"",
            }),
            recent_students: {},
            arms:[],
            // id:1,
        };
    },
    methods: {
        submit() {
            this.$inertia.post("/add-students", this.form, {
                onSuccess: (response) => {
                    this.form.reset();
                    this.getRecentlyAddedStudent();
                    toastr.success("Student added successfully!", "Success");
                },
            });
        },
        getRecentlyAddedStudent() {
            axios.get("/recently-added-students").then((response) => {
                this.recent_students = response.data;
            });
        },
        checkArmExistence(class_name){
            console.log(class_name)
            axios.get('/get-arms',{params:{class_name:class_name}}).then((response)=>{
                this.arms = response.data
            })
        }
    },
    filters: {
        date: function (value) {
            if (value) {
                return moment(String(value)).format("ll");
                //return moment(String(value), "YYYYMMDD").fromNow();
            }
        },
    },
    created() {
        this.getRecentlyAddedStudent();
    },
};
</script>
