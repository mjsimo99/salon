<template>

<!-- c -->
  <div class="max-w-md  mx-auto mt-36">
    <h1 class="text-2xl font-bold mb-4">Book an Appointment</h1>
    <div class="mb-4">
      <label for="client_date" class="block font-medium mb-2">Select a date:</label>
      <input type="date" id="client_date" v-model="client_date" 
       :min="minDate" @change="updateAvailableHours"
       class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
    </div>
    <div v-if="availableHours.length > 0" class="mb-4">
      <label class="block font-medium mb-2">Select an available hour:</label>
      <div class="grid grid-cols-2 gap-4">
        <div v-for="hour in availableHours" :key="hour.time" @click="selectHour(hour.time)"
          :class="{ 'bg-red-500': isReserved(hour.time), 'bg-indigo-500 text-white': hour.time === selectedHour, 'bg-gray-200': hour.time !== selectedHour && !isReserved(hour.time) }"
          class="rounded-md py-2 px-4 cursor-pointer">{{ hour.time }}</div>
      </div>
    </div>
    <div v-else class="text-red-500 mb-4">No available hours for selected date.</div>
    <button @click="bookAppointment" :disabled="!selectedHour"
      class="bg-indigo-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">Book
      Appointment</button>
    <div v-if="success" class="text-green-500 mt-4">Appointment booked successfully!</div>
    <div v-if="reservedHours.length > 0" class="mt-4">
      <h2 class="text-lg font-bold mb-2">Reserved Hours:</h2>
      <ul>
        <li v-for="hour in reservedHours" :key="hour">{{ hour }}</li>
      </ul>
    </div>
  </div>
  
<!-- </div> -->
</template>

<script>
export default {
  data() {
    return {
      client_date: "",
      selectedHour: "",
      success: false,
      reservedHours: [],
      openingHours: {
        monday: ["9:00", "12:00", "14:00", "20:00"],
        tuesday: ["9:00", "12:00", "14:00", "20:00"],
        wednesday: ["9:00", "12:00", "14:00", "20:00"],
        thursday: ["9:00", "12:00", "14:00", "20:00"],
        friday: ["9:00", "12:00", "16:00", "22:00"],
        saturday: ["9:00", "12:00", "14:00", "20:00"],
        sunday: ["9:00", "12:00"],
      },
    };
  },
  beforeUnmount() {
    this.reservedHours = [];
  },
  computed: {
    availableHours() {
      const dayOfWeek = new Date(this.client_date).toLocaleDateString("en-US", { weekday: "long" }).toLowerCase();
      const openingHours = this.openingHours[dayOfWeek];
      if (!openingHours) return [];
      const availableHours = [];
      for (let i = 0; i < openingHours.length; i += 2) {
        const start = openingHours[i];
        const end = openingHours[i + 1] || "23:59";
        for (let j = this.timeToMinutes(start); j < this.timeToMinutes(end); j += 60) {
          const startTime = this.minutesToTime(j);
          const endTime = this.minutesToTime(j + 60);
          const reserved = this.reservedHours.includes(`${startTime}-${endTime}`);
          availableHours.push({ time: `${startTime}-${endTime}`, reserved });
        }
      }
      return availableHours;
    },
    minDate() {
      const today = new Date();
      const year = today.getFullYear();
      const month = `${today.getMonth() + 1}`.padStart(2, "0");
      const day = `${today.getDate()}`.padStart(2, "0");
      return `${year}-${month}-${day}`;
    },
  },
  methods: {



    bookAppointment() {
      if (this.selectedHour) {
        const data = {
          clientId: localStorage.getItem("clientId"),
          client_date: this.client_date,
          hour: this.selectedHour
        };
        fetch('http://localhost/salon/back/old/routes/webtwo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 201) {
            this.success = true;
            this.reservedHours.push(this.selectedHour);
            this.selectedHour = "";
            alert(data.message);
          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      }
    },
  



    async deleteReservation(clientId, client_date, start) {
  const url = `http://localhost/salon/back/old/routes/webtwo.php?clientId=${clientId}&client_date=${client_date}&hour=${start}`;
  try {
    const response = await fetch(url, {
      method: "DELETE"
    });
    console.log(response);
    this.deletedReservation = { client_id: clientId, client_date, start };
    if (response.status === 200) {
      console.log("Reservation deleted successfully");
      alert("Reservation deleted successfully");
    }
    else {
      alert("This hour reserved by another client");
    }
  } catch (error) {
    alert
    console.log(error);
    throw error;
  }
},



    selectHour(hour) {
      if (this.isReserved(hour, localStorage.getItem("clientId"))) {
        const [start] = hour.split("-");
        this.deleteReservation(localStorage.getItem("clientId"), this.client_date, start)
          .then(() => {
            this.fetchReservedHours();
          })
          .catch((error) => {
            console.log(error);
          });
      }
      else {
        this.selectedHour = hour;
      }
    },





    updateAvailableHours() {
      this.selectedHour = "";
      this.fetchReservedHours();
    },
    timeToMinutes(time) {
      const [hours, minutes] = time.split(":");
      return parseInt(hours) * 60 + parseInt(minutes);
    },
    minutesToTime(minutes) {
      const hours = Math.floor(minutes / 60);
      const mins = minutes % 60;
      return `${hours.toString().padStart(2, "0")}:${mins.toString().padStart(2, "0")}:00`;
    },
    async fetchReservedHours() {
      if (!this.client_date) return;
      this.reservedHours = []; // clear the reservedHours array
      try {
        const clientId = localStorage.getItem("clientId");
        const response = await fetch(`http://localhost/salon/back/old/routes/webtwo.php?client_date=${this.client_date}&clientId=${clientId}`);
        const data = await response.json();
        this.reservedHours = data.reservedHours.map(hour => `${hour}-` + this.minutesToTime(this.timeToMinutes(hour) + 60));
      } catch (error) {
        console.log(error);
      }
    },
    isReserved(hour) {
      const [start, end] = hour.split("-");
      const reserved = this.reservedHours.some(reservedHour => {
        const [reservedStart, reservedEnd] = reservedHour.split("-");
        return start === reservedStart && end === reservedEnd;

      });
      return reserved;
    },
  },
};
</script>


<style>
.bg-red-500 {
  background-color: #EF4444;
}
</style>
