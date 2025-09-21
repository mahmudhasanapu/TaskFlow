import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../services/axiosClient";
import Swal from "sweetalert2";

export const useTaskStore = defineStore("task", ()=> {
    const tasks = ref([]); 
    const loading = ref(false);

      const summary = ref({
        new: 0,
        in_progress: 0,
        completed: 0,
        cancelled: 0,
      });
    
      // Fetch Summary
      const fetchSummary = async () => {
        loading.value = true;
        try {
          const res = await apiClient.get("tasks/summary");
          loading.value = false;
          // console.log(res);
          summary.value = res.data.data;
        } catch (error) {
          console.log("Failed to fetch summary", error);
        }
      };
    

    //Create Task
    const createTask = async (payload) => {
        const res = await apiClient.post("/tasks", payload);
        tasks.value.unshift(res.data);
    };
    //Get Tasks By status
    const fetchTasksByStatus = async (status = "new") => {
        tasks.value = [];
        loading.value = true;
        try {
            const res = await apiClient.get(`/tasksFilter?status=${status}`);
            console.log(res);
            tasks.value = res.data.data.data;
             

        } finally {
            loading.value = false;
        }
    };
    // Get Single Task
    const getTaskById = async (id) => {
       const res = await apiClient.get(`/tasks/${id}`);
       return res.data.data;
    };
    //   Update Task
    const updateTask = async (id, payload) => {
       const res = await apiClient.put(`/tasks/${id}`, payload);
       const index = tasks.value.findIndex((t) => t.id === id);
       if (index !== -1) tasks.value[index] = res.data;
    };
    //Normal Delete Task
    const deleteTask = async (id) => {
       await apiClient.delete(`/tasks/${id}`);
       tasks.value = tasks.value.filter((t) => t.id !== id);
    };
    //Fetch Trashed Tasks
    const fetchTrashedTasks = async () => {
         tasks.value = [];
         loading.value = true;
     try {
        const res = await apiClient.get("tasks/trashed");
          console.log(res);
          tasks.value = res.data.data.data ?? res.data.data ?? [];
       } catch (error) {
           console.error("Failed to fetch trashed tasks", error);
           cogoToast.error("Failed to load trashed tasks");
       } finally {
          loading.value = false;
       };
    };
    //   Permanent Delete Task
  const forceDeleteTask = async (id) => {
    const confirm = await Swal.fire({
      title: "Are you sure?",
      text: "You won’t be able to recover this task!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#e3342f",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes, delete it!",
    });

    if (confirm.isConfirmed) {
      try {
        await apiClient.delete(`/tasks/${id}/forceDelete`);
        tasks.value = tasks.value.filter((t) => t.id !== id);
        Swal.fire(
          "Deleted!",
          "The task has been permanently deleted.",
          "success"
        );
      } catch (error) {
        console.error("Failed to permanently delete task", error);
        Swal.fire("Failed", "Could not delete the task.", "error");
      }
    }
  };
   //Restore Task
  const restoreTask = async (id) => {
    const confirm = await Swal.fire({
      title: "Restore Task?",
      text: "Do you want to restore this task?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#38c172",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes, restore it!",
    });

    if (confirm.isConfirmed) {
      try {
        await apiClient.post(`/tasks/${id}/restore`);
        tasks.value = tasks.value.filter((t) => t.id !== id);
        Swal.fire({
          toast: true,
          position: "top-end",
          icon: "success",
          title: "Task restored successfully",
          showConfirmButton: false,
          timer: 3000,
        });
      } catch (error) {
        console.error("Failed to restore task", error);
        Swal.fire("Failed", "Could not restore the task.", "error");
      }
    }
  };
    
   

    return{
        tasks,
        loading,
        summary,            
        createTask,
        fetchSummary,
        fetchTasksByStatus, 
        getTaskById,
        updateTask,
        deleteTask,
        fetchTrashedTasks,
        forceDeleteTask,
        restoreTask,
    };
});



