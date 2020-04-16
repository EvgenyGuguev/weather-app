<template>
    <div class="text-white mb-8">

      <div class="data-input text-gray-800">
        <input type="search" id="address" class="form-control w-full rounded-lg outline-none px-2 py-1" placeholder="Where are we going?" />

        <p>Выбрано: <strong id="address-value">ничего</strong></p>
      </div>

      <div class="weather-container font-sans w-128 max-w-lg overflow-hidden bg-gray-900 shadow mt-4 rounded-lg">

        <div class="current-weather flex items-center justify-between px-6 py-8 ">
          <div class="flex items-center">
            <div>
              <div class="text-6xl font-seminold">{{ currentTemperature.actual }}&degC</div>
              <div>Ощущается как {{ currentTemperature.feels }} &degC</div>
            </div>
            <div class="mx-5">
              <div class="font-semibold">{{ toUpper(currentTemperature.summary) }}</div>
              <div>{{ location.name }}</div>
            </div>
          </div>
          <div class="weather-icon">

          </div>
        </div><!--End current-weather-->

        <div class="future-weather  bg-gray-800 px-6 py-4 overflow-hidden">
          <div
            v-for="(day, index) in daily"
            :key="day.dt"
            class="flex items-center"
          :class="{ 'mt-2' : index > 0 }"
          v-if="index < 5">
            <div class="w-1/6 text-lg text-gray-200">{{ toDaysOfWeek(day.dt) }}</div>
            <div class="w-4/6 px-4 flex items-center">
              <div class="daily-icon">
                <img :src="`https://openweathermap.org/img/wn/${day.weather[0].icon}@2x.png`">
              </div>
              <div class="ml-3">{{ toUpper(day.weather[0].description) }}</div>
            </div>
            <div class="w-1/6 text-right">
              <div>{{ Math.round(day.temp.max) }} &degC</div>
              <div>{{ Math.round(day.temp.min) }} &degC</div>
            </div>
          </div>
        </div><!--End future-weather-->

      </div>
    </div>
</template>

<script>
    export default {
        mounted() {
          this.fetchData();

          var placesAutocomplete = places({
            appId: 'pl5SROY90B3Q',
            apiKey: 'd0052e85ad73f5c1efd0e7f8dfc4fffc',
            container: document.querySelector('#address')
          }).configure({
            type: 'city',
            aroundLatLngViaIP: false,
            // language: 'en',
          });

          var $address = document.querySelector('#address-value');

          placesAutocomplete.on('change', (e) => {
            $address.textContent = e.suggestion.value;

            this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`;
            this.location.lat = e.suggestion.latlng.lat;
            this.location.lon = e.suggestion.latlng.lng;
          });

          placesAutocomplete.on('clear', function() {
            $address.textContent = 'none';
          });
        },
      watch: {
        location: {
          handler(newValue, oldValue) {
            this.fetchData();
          },
          deep: true
        }
      },
        data() {
          return {
            currentTemperature: {
              actual: '',
              feels: '',
              summary: '',
              icon: '',
              dailyIcon: '',
            },
            daily: [],
            location: {
              name: 'Москва, Россия',
              lat: 55.7421,
              lon: 37.6031,
            }
          }
        },
        methods: {
          fetchData() {

            fetch(`api/weather?lat=${this.location.lat}&lon=${this.location.lon}`)
              .then(response => response.json())
              .then(data =>{
                console.log(data);
                this.currentTemperature.actual = Math.round(data.current.temp);
                this.currentTemperature.feels = Math.round(data.current.feels_like);
                this.currentTemperature.summary = data.current.weather[0].description;
                this.currentTemperature.icon = data.current.weather[0].icon;
                document.querySelector('.weather-icon').innerHTML = `<img src="https://openweathermap.org/img/wn/${this.currentTemperature.icon}@2x.png">`;

                this.daily = data.daily;
                // this.currentTemperature.dailyIcon = data.daily.weather.icon;
                // document.querySelector('.daily-icon').innerHTML = `<img src="https://openweathermap.org/img/wn/${this.currentTemperature.dailyIcon}@2x.png">`;
              });
        },
          toDaysOfWeek(timestamp) {
            const newDate = new Date(timestamp*1000);
            const days = ['ПНД', 'ВТР', 'СРД', 'ЧТВ', 'ПТН', 'СУБ', 'ВСК'];

            return days[newDate.getDay()];
          },
          toUpper(string) {
            return string.charAt(0).toUpperCase() + string.substr(1);
          }
      }
    }
</script>
