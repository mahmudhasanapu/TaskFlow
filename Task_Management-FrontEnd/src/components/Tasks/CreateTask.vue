<script setup>
import { ref } from "vue";
import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();

const title = ref("");
const description = ref("");

const createTask = async () => {
  if (!title.value.trim()) {
    alert("Please Enter Task Title");
    return;
  }

  await taskStore.createTask({
    title: title.value,
    description: description.value,
    status: "new",
  });

  //   Clear Form
  title.value = "";
  description.value = "";
};
</script>

<template>
  <div class="content-body container-fluid">
    <div class="d-flex justify-content-center row">
      <div class="col-12 col-lg-8 col-sm-12 col-md-8 p-2">
        <div class="card">
          <div class="card-body">
            <h4>Create New</h4>
            <br /><input
              placeholder="Task Name"
              class="form-control animated fadeInUp"
              type="text"
              v-model="title"
            /><br /><textarea
              rows="5"
              placeholder="Task Description"
              class="form-control animated fadeInUp"
              type="text"
              v-model="description"
            ></textarea
            ><br /><button
              @click="createTask"
              class="btn float-end btn-primary"
            >
              Create
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


