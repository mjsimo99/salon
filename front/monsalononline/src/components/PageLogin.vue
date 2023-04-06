<template>
  <div
    class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat bg-cover bg-center bg-no-repeat"
    style="background-image:url('https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1611&q=80')">
    <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
      <div class="text-white">



        <div v-if="showAlert" class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
          <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd"></path>
          </svg>
          <div>
            <span class="font-medium">Danger alert!</span> Change a few things up and try submitting again.
          </div>
        </div>




        <div class="mb-8 flex flex-col items-center">
          <img src="https://img.icons8.com/color/256/circled-user-male-skin-type-1-2.png" width="150" alt="" srcset="" />
          <h1 class="mb-2 text-2xl">Login</h1>
          <span class="text-gray-300">Enter Login Details</span>
        </div>
        <form @submit.prevent="handleSubmit">
          <div class="mb-4 text-lg text-center">
            <input id="reference" v-model="reference"
              class="rounded-3xl text-black border-none  bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md"
              type="text" name="name" placeholder="reference" />
          </div>
          <div class="mt-8 flex justify-center text-lg text-black">
            <button type="submit"
              class="rounded-3xl bg-red-400 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-red-600">
              Login
            </button>
          </div>
        </form>
        <div v-if="client">
          <p>Client Name: {{ client.first_name }}</p>
          <p>Client Email: {{ client.last_name }}</p>
          <p>Client Phone: {{ client.phone }}</p>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import axios from "axios";

export default {
  data() {
    return {
      reference: "",
      client: null,
      showAlert: false,
    };
  },
  methods: {
    handleSubmit() {
      axios
        .get(`http://localhost/salon/back/old/routes/login.php?reference=${this.reference}`)
        .then((response) => {
          // Check if the response contains a valid client object
          if (response.data.client) {
            this.client = response.data.client;
            // Save only the client ID in local storage
            console.log(this.client);
            localStorage.setItem("isLoggedIn", true);
            localStorage.setItem("clientId", this.client.clientId);
            // Navigate to the homepage
            this.$router.push({ path: "/" });
            window.location.reload();
          } else {
            this.showAlert = true; // Show the danger alert
          }
        })
        .catch((error) => {
          console.log(error);
          this.showAlert = true; // Show the danger alert
        });
    },
  },
};
</script>




<style>
.bg-black-semi-transparent {
  background-color: rgba(0, 0, 0, 0.5);
}
</style>