<template>

    <div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat" style="background-image:url('https://images.unsplash.com/photo-1499123785106-343e69e68db1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1748&q=80')">
      
        <div class="flex flex-col items-center p-6">
  <h1 class="text-2xl font-bold mb-6">Book Your Appointment</h1>
  <form class="w-full max-w-sm">
    <div class="mb-4">
      <label class="block font-bold mb-2" for="date">
        Date:
      </label>
      <input 
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
        id="date" 
        type="date" 
        required
      >
    </div>
    <div class="mb-4">
      <label class="block font-bold mb-2" for="time">
        Time:
      </label>
      <input 
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
        id="time" 
        type="time" 
        required
      >
    </div>
    <div class="flex items-center justify-center">
      <button 
        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
        type="submit"
      >
        Book Appointment
      </button>
    </div>
  </form>
</div>

    </div>
    
    
    </template>
    
    <script>
    export default {
        name: "PageHome"
    };
    </script>
    
    <style>
    .bg-black-semi-transparent {
        background-color: rgba(0, 0, 0, 0.5);
      }
    </style>
    