<template>
  <div class="text-white mb-8">
    <div class="places-input text-gray-800">
      <input
        type="search"
        id="city"
        class="form-control"
        placeholder="Where are we going?"
      />

      <p>Selected: <strong id="address-value">none</strong></p>
    </div>
    <div
      class="weather-container font-sans w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4 rounded-lg"
    >
      <div class="current-weather flex items-center justify-between px-6 py-8">
        <div class="flex items-center">
          <div>
            <div class="text-6xl font-semibold">{{ currentTemp.actual }}°C</div>
            <div>Feels like {{ currentTemp.feels }}°C</div>
          </div>
          <div class="mx-5">
            <div class="font-semibold">{{ currentTemp.summary }}</div>
            <div>{{ location.name }}</div>
          </div>
        </div>
        <div class="">
          <img
            :src="
              'http://openweathermap.org/img/wn/' + currentTemp.icon + '@2x.png'
            "
          />
        </div>
      </div>
      <!-- Current weather ends here -->

      <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
        <div
          class="flex items-center"
          v-for="(day, index) in daily"
          :key="day.dt"
          :class="{ 'mt-8': index > 0 }"
          v-if="index < 5"
        >
          <div class="w-1/6 text-lg text-gray-200">
            {{ toDayOfWeek(day.dt) }}
          </div>
          <div class="w-4/6 px-4 flex items-center">
            <div>
              <img
                :src="
                  'http://openweathermap.org/img/wn/' +
                  day.weather[0].icon +
                  '@2x.png'
                "
              />
            </div>
            <div class="ml-3">{{ day.weather[0].description }}</div>
          </div>
          <div class="w-1/6 text-right">
            <div>{{ Math.round(day.temp.max) }}°C</div>
            <div>{{ Math.round(day.temp.min) }}°C</div>
          </div>
        </div>
      </div>
    </div>
    <!-- weather-container ends here -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      location: {
        name: "Dhaka, Bangladesh",
        lat: 23.8103,
        lon: 90.4125,
        unit: "metric",
      },
      daily: [],
      currentTemp: {
        actual: "",
        feels: "",
        summary: "",
        icon: "",
      },
    };
  },
  watch: {
    location: {
      handler(newValue, oldValue) {
        this.fetchData();
      },
      deep: true,
    },
  },
  methods: {
    fetchData() {
      fetch(
        `/api/weather?lat=${this.location.lat}&lon=${this.location.lon}&unit=${this.location.unit}`
      )
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          this.currentTemp.actual = Math.round(data.current.temp);
          /* console.log(this.currentTemp.actual); */
          this.currentTemp.feels = Math.round(data.current.feels_like);
          /* console.log(this.currentTemp.feels); */
          this.currentTemp.summary = data.current.weather[0].description;
          this.currentTemp.icon = data.current.weather[0].icon;
          this.daily = data.daily;
          console.log(this.daily);
        });
    },
    toDayOfWeek(timestamp) {
      const newDate = new Date(timestamp * 1000);
      const days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
      return days[newDate.getDay()];
    },
  },
  mounted() {
    var placesAutocomplete = places({
      appId: "plPZK5V5NPU9",
      apiKey: "60d14b73f2ec008a1aeeff9f1cd82947",
      container: document.querySelector("#city"),
    });

    var $address = document.querySelector("#address-value");
    placesAutocomplete.on("change", (e) => {
      console.log(e.suggestion);
      $address.textContent = e.suggestion.value;

      this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`;
      this.location.lat = e.suggestion.latlng.lat;
      this.location.lon = e.suggestion.latlng.lng;
    });

    placesAutocomplete.on("clear", function () {
      $address.textContent = "none";
    });

    this.fetchData();
  },
};
</script>
