<template>

<div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat bg-cover bg-center bg-no-repeat" style="background-image:url('https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1611&q=80')">
      
      <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
        <div class="text-white">
          <div class="mb-8 flex flex-col items-center">
            <img src="https://img.icons8.com/fluency/256/writer-male.png" width="150" alt="" srcset="" />
            <h1 class="mb-2 text-2xl">Register</h1>
            <span class="text-gray-300">Enter Register Details</span>
          </div>
          <form  @submit.prevent="addClient">
           
    
            
            <div class="mb-4 text-lg">
          <input class="rounded-3xl text-black border-none bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="text" id="first_name" v-model="client.first_name">
        </div>

        <div class="mb-4 text-lg">
          <input class="rounded-3xl text-black border-none bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="text" id="last_name" v-model="client.last_name" />
        </div>
        <div class="mb-4 text-lg">
          <input class="rounded-3xl text-black border-none bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="text" id="phone" v-model="client.phone"/>
        </div>
        <div class="mt-8 flex justify-center text-lg text-black">
          <button type="submit" class="rounded-3xl bg-green-400 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-green-600">register</button>
        </div>
          </form>
        </div>
      </div>
    </div>
    
    
    </template>

    
<script>
export default {
  data() {
    return {
      client: {
        first_name: '',
        last_name: '',
        phone: '',
      },
    };
  },
  methods: {
    addClient() {
      // your AJAX call to register the client goes here
      fetch('http://localhost/salon/back/old/routes/web.php', {
        method: 'POST',
        body: JSON.stringify(this.client),

      })
        .then(response => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error('Failed to register client');
          }
        })
        .then(data => {
          alert('Client registered successfully. Reference: ' + data.reference); // show the generated reference in an alert
          this.client = {
            first_name: '',
            last_name: '',
            phone: '',
          };
        })
        .catch(error => {
          alert('Failed to register client due to: ' + error.message);
        });
    },
  },
};
</script>



<style>.bg-black-semi-transparent {
  background-color: rgba(0, 0, 0, 0.5);
}</style>
    



    