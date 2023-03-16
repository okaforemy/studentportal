<style scoped>
.fa-plus {
    cursor: pointer;
}
#accept-child {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding-top: 10px;
    padding-left: 5px;
    padding-right: 5px;
}
#accept-child span {
    padding: 5px;
}
.no-border-input {
    border: none;
}
#accept-child span {
    padding: 5px;
}
.no-style {
    list-style: none;
    padding-left: 0;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
}
.no-style li {
    padding: 8px 0 8px 12px;
    border-bottom: 1px solid #ced4da;
    cursor: pointer;
}
.no-style li:hover {
    background: #dde0e4;
    border-radius: 2px;
}
.tags {
    list-style: none;
    list-style: none;
    display: inline;
    padding-left: 5px;
    padding-right: 5px;
}
.tag-item {
    background: gray;
    margin-right: 12px;
    color: white;
    padding: 2px 10px 5px 10px;
    border-radius: 6px;
    line-height: 1.4;
    float: left;
    margin: 5px;
}
.tag-item span {
    cursor: pointer;
}
li.page-item:first-child {
    display: none;
}
li.page-item:last-child {
    display: none;
}
.fa-trash{
    display: none;
}
.subj-table-tr:hover .fa-trash{
    display: inline;
}
</style>
<template>
    <div class="pt-2">
        <Head title="add subject" />

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Subjects</h3>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <label class="typo__label">Section</label>
                                <multiselect @input="checkEmpty" v-model="selectedSection" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Please select a section" label="name" track-by="name" :preselect-first="false">
                                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} selected</span></template>
                                </multiselect>
                        </form>
                    </div>

                    <div v-if="iscategory" class="mx-4 mb-2">
                        <label for="">Category</label>
                        <input type="text" name="" v-model="category" class="form-control" id="">
                    </div>

                    <label for="arm" class="ml-4">Subjects</label>
                   <div id="accept-child" class="mx-4 mb-4">
                            <ul class="tags" v-if="allSubjects.length > 0" >
                                <li class="tag-item" v-for="(subj, inde) in allSubjects" :key="inde"> 
                                    {{subj}}
                                </li>
                            </ul>
                        <input type="text" ref="subjects"  v-model="subjects" autofocus  placeholder="Enter coma seperated list of subjects e.g English, Mathematics," class="form-control no-border-input">
                    </div>

                    <div class="mt-2 mb-4 text-center">
                        <button @click.prevent="addSubjects" disabled type="submit" class="btn btn-primary savesubjects">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Subjects</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-sm-responsive p-0">
                        <table class="table table-hover text-nowrap table-responsive">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Subjects</th>
                                    <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(subject,index) in latestsubjects.data" :key="index" class="subj-table-tr">
                                    <td>{{index+1+parseInt(page)}}</td>
                                    <td>
                                        {{subject.subject}}
                                         <a href="#" class="pl-1" @click.prevent="deleteSubject(subject.id)"><i class="fas fa-trash text-danger"></i></a>
                                        </td>
                                    <td> {{subject.section}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- paginator -->
                        <nav aria-label="..." class="ml-4 mt-4" >
                            <ul class="pagination">
                                <li class="page-item" :class="{active : link.active, disabled : link.url ==null }" v-for="(link,index) in latestsubjects.links" :key="index">
                                <Link  :href="link.url"  preserve-scroll  v-html="link.label" class="page-link" />
                                </li>
                            </ul>
                        </nav>
                        <!-- paginator ends here -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
 import { Inertia } from '@inertiajs/inertia'
 import paginator from '../../Shared/paginator.vue'
 import { Link } from '@inertiajs/inertia-vue'

export default {
    // props:{
    //     sections,
    //     latestsubjects
    // },
    props:[
        'sections','latestsubjects','page'
    ],
    components:{
        Multiselect,
        Inertia,
        paginator,
        Link
    },
    data(){
        return{
            selectedSection: [],
            options: this.sections,
            allSubjects:[],
            subjects:[],
            iscategory:false,
            category: ''
        }
    },
    methods: {
        addSubjects(){
            axios.post('/add-subjects',{subjects: this.allSubjects, sections: this.selectedSection,category: this.category}).then((response)=>{
                this.subjects=[]
                if(!response.data){
                    toastr.error('Subjects already exist!', 'Error')
                }
                Inertia.reload({ only: ['latestsubjects','sections'] })
            })
        },
        checkEmpty(){
             if(this.allSubjects.length ==0  && this.selectedSection.length ==0){
                    $('.savesubjects').attr('disabled',true)
                }
                if(this.allSubjects.length ==1  && this.selectedSection.length ==0){
                    $('.savesubjects').attr('disabled',true)
                }
                if(this.allSubjects.length !=0 && this.selectedSection.length !=0){
                    $('.savesubjects').attr('disabled',false);
                }

                this.checkPreNursery()
        },
        deleteSubject(id){
            axios.get('/delete-subject',{params:{id:id}}).then((response)=>{
                Inertia.reload({ only: ['latestsubjects','sections'] })
            })
        },

        checkPreNursery(){
            let found = this.selectedSection.findIndex(element=>element.name == 'pre_nursery');
            if(found != -1){
                this.iscategory = true
            }else{
                this.iscategory = false
            }
        }
    },
    watch:{
        subjects:function(){
           let subject = this.$refs.subjects.value;

                if(subject.length == 0 && this.selectedSection.length ==0){
                    $('.savesubjects').attr('disabled',true)
                }
                if(subject.length == 0 && this.selectedSection.length ==1){
                    $('.savesubjects').attr('disabled',true)
                }
                if(subject.length != 0 && this.selectedSection.length !=0){
                    $('.savesubjects').attr('disabled',false);
                }
                this.allSubjects=[];
                if(this.subjects.length !=0){
                    let myarr = this.subjects.split(',');
                    this.allSubjects = myarr.filter(entry => entry.trim() != '');
                }
        }
    }
};
</script>
