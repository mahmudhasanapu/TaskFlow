<script setup>

import { useAuthstore } from '../stores/AuthStore';

const authstore = useAuthstore();

</script>


<template>
  <!-- Navbar -->
  <nav
    class="navbar navbar-expand-lg navbar-light bg-light fixed-top px-3 shadow-sm"
  >
    <div class="container-fluid">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <i class="bi bi-list h4 m-0"></i>
        <img
          src="https://cdn-icons-png.flaticon.com/256/906/906334.png"
          class="nav-logo mx-2"
          alt="logo"
        />
      </a>
      <div class="d-flex align-items-center">
        <div class="user-dropdown">
          <img
            src="https://t3.ftcdn.net/jpg/02/00/90/24/360_F_200902415_G4eZ9Ok3Ypd4SZZKjc8nqJyFVp1eOD6V.jpg"
            alt="User"
            class="icon-nav-img"
          />
          <div class="user-dropdown-content p-3">
            <div class="text-center">
              <img
                src="https://t3.ftcdn.net/jpg/02/00/90/24/360_F_200902415_G4eZ9Ok3Ypd4SZZKjc8nqJyFVp1eOD6V.jpg"
                class="icon-nav-img mb-2"
                alt=""
              />
              <h6>User Name</h6>
              <hr class="p-0" />
            </div>
            <a href="/profile" class="side-bar-item">
              <i class="bi bi-person side-bar-item-icon"></i>
              <span class="side-bar-item-caption">Profile</span>
            </a>
            <span @click="authstore.logout" class="side-bar-item" style="cursor: pointer">
              <i class="bi bi-box-arrow-right side-bar-item-icon"></i>
              <span class="side-bar-item-caption">Logout</span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="side-nav-open">
    <RouterLink :to="{ name: 'summary' }" class="side-bar-item mt-2">
      <i class="bi bi-speedometer2 side-bar-item-icon"></i>
      <span>Dashboard</span>
    </RouterLink>
    <RouterLink :to="{ name: 'create' }" class="side-bar-item mt-2">
      <i class="bi bi-pencil-square side-bar-item-icon"></i>
      <span>Create New</span>
    </RouterLink>
    <RouterLink :to="{ name: 'newtasks' }" class="side-bar-item mt-2">
      <i class="bi bi-list-ul side-bar-item-icon"></i>
      <span>New Task</span>
    </RouterLink>
    <RouterLink :to="{ name: 'inprogress' }" class="side-bar-item mt-2">
      <i class="bi bi-hourglass-split side-bar-item-icon"></i>
      <span>In Progress</span>
    </RouterLink>
    <RouterLink :to="{ name: 'completed' }" class="side-bar-item mt-2">
      <i class="bi bi-check-circle side-bar-item-icon"></i>
      <span>Completed</span>
    </RouterLink>
    <RouterLink :to="{ name: 'canceled' }" class="side-bar-item mt-2">
      <i class="bi bi-x-octagon side-bar-item-icon"></i>
      <span>Canceled</span>
    </RouterLink>
    <RouterLink :to="{ name: 'trashed' }" class="side-bar-item mt-2">
      <i class="bi bi-x-octagon side-bar-item-icon"></i>
      <span>Trashed</span>
    </RouterLink>
  </div>

  <!-- Content -->
  <div class="content">
    <RouterView />
  </div>
</template>

<style scoped>
.side-nav-open {
  width: 250px;
  height: 100vh;
  background: #f8f9fa;
  position: fixed;
  /* top: 56px; */
  left: 0;
  overflow-y: auto;
}
.content {
  margin-left: 250px;
  margin-top: 56px;
  padding: 20px;
}
.side-bar-item {
  display: flex;
  align-items: center;
  padding: 10px 20px;
  color: #333;
  text-decoration: none;
}
.side-bar-item:hover,
.side-bar-item-active {
  background-color: #e9ecef;
  font-weight: bold;
}
.side-bar-item-icon {
  margin-right: 10px;
}
.user-dropdown {
  position: relative;
}
.user-dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: white;
  min-width: 200px;
  border: 1px solid #ddd;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}
.user-dropdown:hover .user-dropdown-content {
  display: block;
}
.icon-nav-img {
  width: 35px;
  height: 35px;
  border-radius: 50%;
}
.nav-logo {
  height: 35px;
}
</style>
