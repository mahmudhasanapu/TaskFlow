<script setup>

import { ref } from "vue";
import { useRouter } from 'vue-router';
import { useAuthstore } from '../stores/AuthStore';

const router = useRouter();
const authstore = useAuthstore();

const email = ref("");
const password = ref("");

const login = async () => {
  const success = await authstore.login({
    email: email.value,
    password: password.value,
  });
  if(success) {
    router.push({ name: "dashboard"});
  }
};

</script>


<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6 center-screen">
        <div class="card w-90 p-4">
          <div class="card-body">
            <form @submit.prevent="login">
              <h4>SIGN IN</h4>
              <br />
              <input
                placeholder="User Email"
                class="form-control animated fadeInUp"
                type="email"
                name="email"
                v-model="email"
              />
              <br />
              <input
                placeholder="User Password"
                class="form-control animated fadeInUp"
                type="password"
                name="password"
                v-model="password"
              />
              <br />
              <button class="btn w-100 animated fadeInUp float-end btn-primary">
                Next
              </button>
            </form>
            <hr />
            <div class="float-end mt-3">
              <span>
                <RouterLink
                  :to="{ name: 'register' }"
                  class="text-center ms-3 h6 animated fadeInUp"
                  >Sign Up
                </RouterLink>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
