import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "./pages/LoginPage.vue";
import RegistrationPage from "./pages/RegistrationPage.vue";
import DashboardPage from "./pages/DashboardPage.vue";
import CreateTask from "./components/Tasks/CreateTask.vue"; 
import NewTasks from "./components/Tasks/NewTasks.vue";
import ProgressTasks from "./components/Tasks/ProgressTasks.vue";
import CompletedTasks from "./components/Tasks/CompletedTasks.vue";
import CanceledTasks from "./components/Tasks/CanceledTasks.vue";
import EditTask from "./components/Tasks/EditTask.vue";
import TrashedTasks from "./components/Tasks/TrashedTasks.vue";
import SummaryPage from "./components/SummaryPage.vue";


const routes = [
  { path: "/", redirect: "/login" },
  { path: "/login", component: LoginPage, name: "login" },
  { path: "/register", component: RegistrationPage, name: "register" },
  { 
    path: "/dashboard", 
    component: DashboardPage, 
    name: "dashboard",
    children: [
      {
        path: "summary",
        component: SummaryPage, 
        name: "summary",
      },
      {
        path: "create",
        component: CreateTask, 
        name: "create",
      },
      {
        path: "newtasks",
        component: NewTasks,
        name: "newtasks",
      },
      {
        path: "inprogress",
        component: ProgressTasks,
        name: "inprogress"
      },
      {
        path: "completed",
        component: CompletedTasks,
        name: "completed",
      },
      {
        path: "canceled",
        component: CanceledTasks,
        name: "canceled",
      },
      {
        path: "task/:id/edit",
        component: EditTask,
        name: "edittask",
      },
      {
        path: "tasks/trashed",
        component: TrashedTasks,
        name: "trashed",
      },
    ],
  },
]; 

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;