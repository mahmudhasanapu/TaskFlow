<script setup>
import { onBeforeMount, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();
const route = useRoute();
const router = useRouter();

const id = route.params.id;

const title = ref("");
const description = ref("");
const status = ref("new"); // default

// Load existing task data
onBeforeMount(async () => {
  const task = await taskStore.getTaskById(id);
  console.log(task);
  if (task) {
    title.value = task.title;
    description.value = task.description;
    status.value = task.status;
  }
});

// Update handler
const updateTask = async () => {
  if (!title.value.trim()) {
    alert("Title is required");
    return;
  };

  await taskStore.updateTask(id, {
    title: title.value,
    description: description.value,
    status: status.value,
  });

  // Redirect or success message
  router.push("/dashboard"); // route path based on your routing
};
</script>

<template>
  <div class="content-body container-fluid">
    <div class="d-flex justify-content-center row">
      <div class="col-12 col-lg-8 col-sm-12 col-md-8 p-2">
        <div class="card">
          <div class="card-body">
            <h4>Update Task</h4>

            <br />
            <input
              placeholder="Task Name"
              class="form-control animated fadeInUp"
              type="text"
              v-model="title"
            />

            <br />
            <textarea
              rows="5"
              placeholder="Task Description"
              class="form-control animated fadeInUp"
              v-model="description"
            ></textarea>

            <br />
            <select class="form-control animated fadeInUp" v-model="status">
              <option value="new">New</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="canceled">Canceled</option>
            </select>

            <br />
            <button @click="updateTask" class="btn float-end btn-success mt-2">
              Update
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
