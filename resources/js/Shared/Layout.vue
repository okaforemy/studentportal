<template>
    <!-- Site wrapper -->
<div class="wrapper">
 
  <!-- Navbar -->
  <TopNav/>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <Nav/>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">

    <slot/>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; {{Date('Y')}} <a href="">Schoolportal</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</template>

<script>
import Nav from "./Nav.vue"
import TopNav from "./TopNav.vue"
import { Head } from '@inertiajs/inertia-vue'

export default {
    components: {Nav, TopNav, Head}
}
</script>