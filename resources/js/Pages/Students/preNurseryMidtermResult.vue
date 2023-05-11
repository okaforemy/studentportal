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
            <select class="form-control">
                <option value="">select pupil</option>
                <option :value="student.id" v-for="(student, ind) in students" :key="ind">{{ student.surname+" "+student.othernames }}</option>
            </select>
        </div>
        <div>
            <div class="col-md-12 text-center mt-4">
                <img src="/images/midterm.png" width="50%" alt="" class="result_logo">
            </div>
            <!-- <div class="col-md-3 no-print">
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Subjects</h3>
                        </div>
                       
                        <div class="card-body table-sm-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr v-for="(student, ind) in students.data" :key="ind">
                                       <td>{{ind+1}}</td>
                                       <td>
                                           <Link href="/students-exam-scores">{{student.surname+" "+student.othernames}}</Link>
                                        </td>
                                   </tr>
                                </tbody>
                            </table>
                            <nav aria-label="..." class="ml-4 mt-4" >
                                <ul class="pagination">
                                    <li class="page-item" :class="{active : link.active, disabled : link.url ==null }" v-for="(link,index) in students.links" :key="index">
                                    <Link  :href="link.url"  preserve-scroll :data="{newpage:true}"  v-html="link.label" class="page-link" />
                                    </li>
                                </ul>
                            </nav>
                        </div>
                       
                    </div>
            </div> -->
        </div>
        <div class="text-center my-4">
            <img src="" height="70px" alt="student" class="img-thumbnail">
        </div>
        <div>
            <p class="text-center">Holiday Assessment/Midterm Progress Report for <span class="term"></span> <span class="session"></span> Session.</p>
            <p class="text-center">
                <span class=" font-weight-bold"> PUPIL'S NAME:</span> 
                <span class="std_name mr-5">HEMBA TERYIMA DERICK</span>
                <span class=" font-weight-bold">	DATE:</span> 
                <span class="date" style="text-transform: uppercase;">May 11, 2023, 12:56 pm</span>
            </p>
            <p class="text-center">
                <span class=" font-weight-bold">CLASS:</span> 
                <span class="clas mr-5">GRADE 2  RARE GEM</span>
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
                <tr>
                    <td>I.C.T</td> 
                    <td class="text-center">100</td>
                    <td class="text-center">100</td></tr><tr><td>CREATIVE ARTS</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>VERBAL REASONING</td> <td class="text-center">100</td><td class="text-center">90</td></tr><tr><td>QUANTITATIVE REASONING</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>NUMERACY</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>PERSONAL, SOCIAL AND HEALTH EDUCATION</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>CITIZENSHIP EDUCATION</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>GENERAL STUDIES</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>SCIENCE AND TECHNOLOGY</td> <td class="text-center">100</td><td class="text-center">85</td></tr><tr><td>LANGUAGE ART</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr><td>HANDWRITING</td> <td class="text-center">100</td><td class="text-center">81</td></tr><tr><td>FRENCH</td> <td class="text-center">100</td><td class="text-center">95</td></tr><tr><td>MUSIC</td> <td class="text-center">100</td><td class="text-center">96</td></tr><tr><td>CRK/IRK</td> <td class="text-center">100</td><td class="text-center">100</td></tr><tr>
                        <td class="text-center font-weight-bold">CLASS PERCENTAGE</td>
                        <td></td>
                        <td class="text-center font-weight-bold">438.81</td>
                    </tr>
                    <tr>
                        <td class="text-center font-weight-bold">PUPIL'S PERCENTAGE</td>
                        <td></td>
                        <td class="text-center font-weight-bold">96.21</td>
                    </tr>
                    <tr>
                        <td class="text-center font-weight-bold">GRADE</td>
                        <td></td>
                        <td class="text-center font-weight-bold">A+</td>
                    </tr></tbody>
		</table>

        <table class="table table-bordered table-sm primary">
			<tbody><tr>
				<td colspan="2" class="font-weight-bold">HOLIDAY ASSESSMENT REPORT</td>
			</tr>
			<tr>
				<td class="subject1">Language Arts (40)</td>
				<td class="subject2">Numeracy (30)</td>
				<td class="subject3">General Studies (30)</td>
			</tr>
			<tr>
				<td class="score1">29</td>
				<td class="score2">30</td>
				<td class="score3">27</td>
			</tr>
		</tbody></table>

        <p><bold></bold>Class Teacher's Comment: <span class="ct_remarks">Derick is an impressive learner. He is making steady progress in all his subjects. Howbeit, he needs a little push in his Creative Arts. Happy Easter!</span></p>

        <p>Class Teacher's Sign:...............................     Head Teacher's Sign: ....................................</p>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    props:['students'],
    components:{Link}
}
</script>