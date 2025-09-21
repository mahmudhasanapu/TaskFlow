import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../services/axiosClient";
import { useRouter } from "vue-router";
import cogoToast from "cogo-toast";

export const useAuthstore = defineStore('auth', ()=> {
    const router = useRouter();
    //state
    const user = ref(null);
    const token = ref(localStorage.getItem("token") || null);

    //Actions
    //Registration
    const register = async (credentials) => {
        try {
            await apiClient.post("/register", credentials);
            cogoToast.success("Registration Successful", {
                position: "bottom-center",
            });
            return true; 
        }catch(error) {
        //   validation error
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            for (const field in errors) {
                errors[field].forEach((msg) => {
                    cogoToast.error(msg, { position: "bottom-center" });
                });
            }
        }
        //   Email already Taken
              else if (error.response?.data?.message) {
                cogoToast.error(error.response.data.message, {
                  position: "bottom-center",
            });
        }
        // Server or Network
        else {
         cogoToast.error("Something went wrong", {
            position: "bottom-center",
            });
        }
        return false;
    }
 };

    //Login
    const login = async (credentials) =>  {
        try {
            const res = await apiClient.post("/login", credentials);
            console.log(res);
            token.value = res.data.data.token;
            localStorage.setItem("token",token.value);
            cogoToast.success("Login Successfully", {position: "bottom-center"});
            return true;
        }catch (error) {
            console.log(error);
            //validation error
            if(error.response?.data?.errors) {
                const errors =error.response.data.errors;
                for (const field in errors) {
                  errors[field].forEach((msg) => {
                    cogoToast.error(msg, {position: "bottom-center"});
                  });
                }
            } 
            //invalid credential
            else if(error.response?.data?.message) {
                cogoToast.error(error.response.data.message, {
                    position: "bottom-center",
                });
            }
            //server error
            else {
                cogoToast.error("something went wrong", {
                    position: "bottom-center",
                })
            }
        }
    };

    // Logout
    const logout = async () => {
        try {
          const success = await apiClient.post("/logout");
          token.value = null;
          localStorage.removeItem("token");
          cogoToast.success("Logout Successful", { position: "bottom-center" });
    
          if (success) {
            router.push({ name: "login" });
          }
    
          return true;
        } catch (error) {
          console.log(error);
          if (error?.message) {
            cogoToast.error(error.message, {
              position: "bottom-center",
            });
          }
          return false;
        }
      };
    //Get-User

    return {
        user,
        token,
        register,
        login,
        logout,
    };
});