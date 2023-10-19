<template>
    <div>
        <div class="card">
            <div class="card-header">
                <span>CBT Users</span>
            </div>
            <div class="card-body">
                <div v-for="(student, index) in students" :key="index"><h4 class="text-center font-weight-bold">{{ index }}</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Names</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(stu, ind) in student" :key="ind">
                            <td>{{ stu.lastname+" "+stu.firstname }}</td>
                            <td>{{ stu.student_id }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['students'],
    data(){
        return{

        }
    },
}
</script>