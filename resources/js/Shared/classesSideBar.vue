<template>
    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Classes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-sm-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Class Name</th>
                                        <th>Arms</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <tr v-for="(cl, index) in classes" :key="index">
                                       <td>{{index + 1}}</td>
                                       <td>{{cl.class_name}}</td>
                                       <td>
                                           <span class="mx-1" v-for="(arm, inde) in cl.arms" :key="inde">
                                               {{arm.arm_name+", "}}
                                           </span>
                                       </td>
                                   </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
</template>

<script>
export default {
    props:{
        classes:Array
    }
}
</script>