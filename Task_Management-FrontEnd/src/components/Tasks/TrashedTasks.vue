<script setup>
import { onBeforeMount } from "vue";
import ShimmerLoader from "../ShimmerLoader.vue";
import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();

onBeforeMount(() => {
  taskStore.fetchTrashedTasks();
});

const forceDeleteTask = async (id) => {
  await taskStore.forceDeleteTask(id);
};

const restoreTask = async (id) => {
  await taskStore.restoreTask(id);
};
</script>

<template>
  <div class="content-body container-fluid">
    <h5>Trashed Tasks</h5>

    <ShimmerLoader :loading="taskStore.loading" :count="8" :lines="1">
      <div class="row">
        <div
          v-for="task in taskStore.tasks"
          :key="task.id"
          class="col-12 col-md-6 col-lg-4 p-2"
        >
          <div class="card h-100">
            <div class="card-body">
              <h6>{{ task.title }}</h6>
              <p>{{ task.description }}</p>
              <p class="mb-0">
                <!-- Deleted at: {{ new Date(task.deleted_at).toLocaleString() }} -->
                Deleted at: {{ task.deleted_at }}
              </p>
              <button
                @click="forceDeleteTask(task.id)"
                class="btn btn-danger btn-sm mt-2"
              >
                Permanently Delete
              </button>

              <button
                @click="restoreTask(task.id)"
                class="btn btn-success btn-sm mt-2 ms-2"
              >
                Restore
              </button>
            </div>
          </div>
        </div>
      </div>
    </ShimmerLoader>
  </div>
</template>
