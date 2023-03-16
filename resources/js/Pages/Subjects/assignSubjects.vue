<style scoped>
 .list-group{
   min-height: 40px;
   background: #fff;
 }

 .move{
   cursor: move;
 }
 
</style>
<template>
    <div>
        <div class="row pb-4">
            <div class="col-md-8 col-sm-12 col-lg-6 offset-md-1">
              <h4 class="text-center pt-2 pb-4">Assign subjects to {{grade}} {{sectionStudentsTitle}}</h4>
               <ul class="list-group">
                <a href="#" class="list-group-item  d-flex justify-content-between align-items-center" v-for="(subj, index) in allsubjects" :key="index"> 
                  {{subj.subject}}
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" @click="selectSubject(subj, $event)" :checked="isSelected(subj.subject)" :id="'customSwitch'+index">
                    <label class="custom-control-label" :for="'customSwitch'+index"></label>
                  </div>
                  <span class="badge badge-primary badge-pill"></span>
                </a>
              </ul>
              <div class="text-center mt-4">
                    <span v-if="allsubjects.length <= 0" class="d-block mt-2 mb-2 font-italic">
                      <span class="font-weight-bold">Subjects not found!</span> please click the Add subjects button to add the subjects for the intended class
                    </span>
                    <Link href="/assign-subjects" v-if="allsubjects.length > 0" method="post" class="btn btn-primary" :data="{subjects: selectedsubjects, grade: grade, arm:arm}" :class="{'disabled':selectedsubjects.length==0}" :disabled="selectedsubjects.length == 0">Save Subjects</Link>
                    <Link href="/add-subjects" v-else class="btn btn-primary">Add Subjects</Link>
              </div>
            </div>

            <div class="col-md-6 col-sm-6">
             
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue'
import draggable from "vuedraggable/src/vuedraggable";
export default {
    props:['subjects','grade','arm','selected_subj'],
    components:{
        draggable, Link
    },
    data(){
        return{
            allsubjects: this.subjects,
            selectedsubjects: [],
           // grade:"",
            sectionStudentsTitle:"",
        }
    },
    methods: {
    isSelected(subject){
      let subjects = Object.values(this.selected_subj);
      let size = subjects.length
      if(size > 0){
       for(var i =0; i < size; i++){
         if(subjects[i].subject === subject){
           return true;
         }
       }
      }else{
        return false
      }
    },

    selectSubject(subj,event){
      let index = this.selectedsubjects.findIndex(element => element.id == subj.id)
      if(event.target.checked){
        if(index == -1){
          this.selectedsubjects.push(subj);
        }
      }else{
       if(index != -1){
        this.selectedsubjects.splice(index,1);
       }
      }
    }
  },
  created(){
    let params = new URL(location.href).searchParams;
    let grade = params.get('grade');
    let section = params.get('section');
    this.grade = grade;
    if(section =="pre_nursery" || section =="nursery" || section =="primary"){
      this.sectionStudentsTitle = "Pupils"
    }else{
      this.sectionStudentsTitle = "Students"
    }

    if(this.selected_subj===null){
      this.selectedsubjects = [];
    }else{
      //this.selectedsubjects = this.selected_subj;
      for(let subj in this.selected_subj){
        this.selectedsubjects.push(this.selected_subj[subj])
      }
    }
  }
}
</script>