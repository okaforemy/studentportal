<template>
     <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <Link href="/" class="brand-link">
      <img src="" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </Link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <Link href="/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </Link>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Student
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <Link href="/add-students" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Add Students
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/students" class="nav-link" preserve-scroll >
                  <i class="fas fa-users"></i>
                  <p>
                    Students
                  </p>
                </Link>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-user-tie"></i>
              <p>
                Parent
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <Link href="/add-parents-only" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Add Parents
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/parents" class="nav-link">
                  <i class="fas fa-users"></i>
                  <p>
                    Parents
                  </p>
                </Link>
              </li>
            </ul>
          </li>
              <li class="nav-item">
                <Link href="/add-class" class="nav-link">
                <i class="fas fa-laptop-house"></i>
                  <p>
                    Add classes
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/classes" class="nav-link">
                <i class="fas fa-laptop-house"></i>
                  <p>
                    Classes
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/add-subjects" class="nav-link">
                <i class="fas fa-laptop-house"></i>
                  <p>
                    Add subjects
                  </p>
                </Link>
              </li>
              <li class="nav-item">

            <a href="#" class="nav-link">
              <i class="fas fa-user-tie"></i>
              <p>
                CBT
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <Link href="/add-question" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Add questions
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/add-cbt-student" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Add students
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/cbt-students" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Students
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/view-questions" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Questions
                  </p>
                </Link>
              </li>
              <li class="nav-item">
                <Link href="/cbt-settings" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  <p>
                    Settings
                  </p>
                </Link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faHatWizard } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
export default {
    components:{Link, library, faHatWizard, FontAwesomeIcon}
}
</script>