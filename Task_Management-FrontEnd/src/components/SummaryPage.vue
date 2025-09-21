<script setup>
import { onBeforeMount } from "vue";
import { useTaskStore } from "../stores/taskStore";
import ShimmerLoader from "./ShimmerLoader.vue";

const taskStore = useTaskStore();

onBeforeMount(async () => {
  await taskStore.fetchSummary();
});
</script>

<template>
  <div class="container">
    <ShimmerLoader :loading="taskStore.loading" :count="4" :lines="1">
      <!-- <div class="row animate__animated animate__fadeInUp"> -->
      <div class="row">
        <div class="col-12 col-lg-3 col-sm-6 col-md-3 p-2">
          <div class="card h-100">
            <div class="card-body">
              <h5>Total Task</h5>
              <h6 class="text-secondary">
                {{
                  taskStore.summary.new +
                  taskStore.summary.in_progress +
                  taskStore.summary.completed +
                  taskStore.summary.canceled
                }}
              </h6>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 col-sm-6 col-md-3 p-2">
          <div class="card h-100">
            <div class="card-body">
              <h5>Total Completed</h5>
              <h6 class="text-secondary">{{ taskStore.summary.completed }}</h6>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 col-sm-6 col-md-3 p-2">
          <div class="card h-100">
            <div class="card-body">
              <h5>Total Progress</h5>
              <h6 class="text-secondary">
                {{ taskStore.summary.in_progress }}
              </h6>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 col-sm-6 col-md-3 p-2">
          <div class="card h-100">
            <div class="card-body">
              <h5>Total Canceled</h5>
              <h6 class="text-secondary">{{ taskStore.summary.canceled }}</h6>
            </div>
          </div>
        </div>
      </div>
    </ShimmerLoader>
  </div>
</template>
