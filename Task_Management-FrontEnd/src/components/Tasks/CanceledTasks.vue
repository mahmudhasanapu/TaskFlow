<script setup>
import { onBeforeMount } from "vue";
import ShimmerLoader from "../ShimmerLoader.vue";
import { useTaskStore } from "../../stores/taskStore";

const taskStore = useTaskStore();

onBeforeMount(async () => {
  await taskStore.fetchTasksByStatus("canceled");
});
</script>

<template>
  <div class="content-body container-fluid">
    <!-- Header and Search -->
    <div class="row p-0 m-0">
      <div class="col-12 col-md-6 col-lg-8 px-3">
        <h5>Task Canceled</h5>
      </div>
    </div>

    <!-- Tasks -->
    <ShimmerLoader :loading="taskStore.loading" :count="12" :lines="1">
      <div class="row p-0 m-0">
        <div
          class="col-12 col-lg-4 col-sm-6 col-md-4 p-2"
          v-for="task in taskStore.tasks"
          :key="task.id"
        >
          <div class="card h-100">
            <div class="card-body">
              <h6 class="animated fadeInUp">{{ task.title }}</h6>
              <p class="animated fadeInUp">{{ task.description }}</p>
              <p class="m-0 animated fadeInUp p-0">
                <svg
                  stroke="currentColor"
                  fill="currentColor"
                  stroke-width="0"
                  viewBox="0 0 1024 1024"
                  height="1em"
                  width="1em"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M880 184H712v-64c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v64H384v-64c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v64H144c-17.7 0-32 14.3-32 32v664c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V216c0-17.7-14.3-32-32-32zm-40 656H184V460h656v380zM184 392V256h128v48c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-48h256v48c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-48h128v136H184z"
                  ></path>
                </svg>
                {{ new Date(task.created_at).toLocaleDateString() }}

                <a class="icon-nav text-primary mx-1">
                  <svg
                    stroke="currentColor"
                    fill="currentColor"
                    stroke-width="0"
                    viewBox="0 0 1024 1024"
                    height="1em"
                    width="1em"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M257.7 752c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9a9.96 9.96 0 0 0 0-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 0 0 9.4 29.8c6.6 6.4 14.9 9.9 23.8 9.9zm67.4-174.4L687.8 215l73.3 73.3-362.7 362.6-88.9 15.7 15.6-89zM880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32z"
                    ></path>
                  </svg>
                </a>

                <a class="icon-nav text-danger mx-1">
                  <svg
                    stroke="currentColor"
                    fill="currentColor"
                    stroke-width="0"
                    viewBox="0 0 1024 1024"
                    height="1em"
                    width="1em"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"
                    ></path>
                  </svg>
                </a>

                <a class="badge float-end bg-danger">Canceled</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </ShimmerLoader>
  </div>
</template>
